<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CatalogCollection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Services\CampaignPriceSynchronizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CampaignPriceSynchronizerTest extends TestCase
{
    use RefreshDatabase;

    public function test_percentage_campaign_updates_discount_price_without_changing_original_price(): void
    {
        $product = $this->product('summer-dress', 1250);
        $inactiveProduct = $this->product('inactive-dress', 800, isActive: false);
        $this->campaign([
            'type' => 'all_active',
            'discount_type' => 'percentage',
            'discount_value' => 20,
        ]);

        app(CampaignPriceSynchronizer::class)->sync();

        $this->assertSame(1250.0, (float) $product->fresh()->original_price);
        $this->assertSame(1000.0, (float) $product->fresh()->display_price);
        $this->assertSame(1000.0, (float) $product->fresh()->discount_price);
        $this->assertNull($inactiveProduct->fresh()->discount_price);
    }

    public function test_category_product_and_price_range_campaigns_target_their_matching_products(): void
    {
        $category = $this->category('clothing', 'stitched');
        $otherCategory = $this->category('accessories', 'bags');
        $categoryProduct = $this->product('category-item', 1000, $category->id);
        $selectedProduct = $this->product('selected-item', 2000, $otherCategory->id);
        $anotherSelectedProduct = $this->product('another-selected-item', 2200, $otherCategory->id);
        $rangeProduct = $this->product('range-item', 3000, $otherCategory->id);
        $outsideRange = $this->product('outside-range', 5000, $otherCategory->id);

        $this->campaign([
            'type' => 'category',
            'category_id' => $category->id,
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'starts_at' => now()->subMinutes(3),
        ]);
        $this->campaign([
            'type' => 'product',
            'product_ids' => [$selectedProduct->id, $anotherSelectedProduct->id],
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'starts_at' => now()->subMinutes(2),
        ]);
        $this->campaign([
            'type' => 'price_range',
            'price_min' => 2500,
            'price_max' => 3500,
            'discount_type' => 'fixed',
            'discount_value' => 250,
            'starts_at' => now()->subMinute(),
        ]);

        app(CampaignPriceSynchronizer::class)->sync();

        $this->assertSame(900.0, (float) $categoryProduct->fresh()->discount_price);
        $this->assertSame(1600.0, (float) $selectedProduct->fresh()->discount_price);
        $this->assertSame(1760.0, (float) $anotherSelectedProduct->fresh()->discount_price);
        $this->assertSame(2750.0, (float) $rangeProduct->fresh()->discount_price);
        $this->assertNull($outsideRange->fresh()->discount_price);
    }

    public function test_latest_overlapping_campaign_wins_and_expired_campaign_restores_price(): void
    {
        $product = $this->product('overlapping-item', 1000);
        $this->campaign([
            'type' => 'all_active',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'starts_at' => now()->subMinutes(2),
        ]);
        $endingCampaign = $this->campaign([
            'type' => 'all_active',
            'discount_type' => 'fixed',
            'discount_value' => 300,
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addMinute(),
        ]);

        $synchronizer = app(CampaignPriceSynchronizer::class);
        $synchronizer->sync();
        $this->assertSame(700.0, (float) $product->fresh()->discount_price);

        $endingCampaign->update(['ends_at' => now()->subSecond()]);
        $synchronizer->sync();

        $this->assertSame(900.0, (float) $product->fresh()->discount_price);

        Campaign::query()->delete();
        $synchronizer->sync();
        $this->assertNull($product->fresh()->discount_price);
        $this->assertSame(1000.0, (float) $product->fresh()->display_price);
    }

    public function test_storefront_and_existing_cart_show_the_sale_price_with_the_original_price(): void
    {
        $product = $this->product('sale-item', 1250);
        $this->campaign([
            'type' => 'all_active',
            'discount_type' => 'fixed',
            'discount_value' => 250,
        ]);
        app(CampaignPriceSynchronizer::class)->sync();

        $this->get(route('shop'))
            ->assertOk()
            ->assertSee('PKR 1,250')
            ->assertSee('PKR 1,000')
            ->assertSee('<del', false);

        $this->get(route('product.details', ['categorySlug' => 'other', 'slug' => $product->slug]))
            ->assertOk()
            ->assertSee('Rs. 1,250')
            ->assertSee('Rs. 1,000')
            ->assertSee('<del', false);

        $this->postJson(route('cart.sync'), [
            'items' => [['id' => $product->id, 'qty' => 1]],
        ])
            ->assertOk()
            ->assertJsonPath("cart.{$product->id}.price", 1000)
            ->assertJsonPath("cart.{$product->id}.original_price", 1250);

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('"price":1000', false)
            ->assertSee('"original_price":1250', false);

        $this->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('"price":1000', false)
            ->assertSee('"original_price":1250', false);

        $this->assertSame(1000.0, (float) DB::table('products')->where('id', $product->id)->value('discount_price'));
    }

    public function test_admin_can_create_a_campaign_and_apply_its_discount_immediately(): void
    {
        $product = $this->product('admin-campaign-item', 1000);
        $admin = User::create([
            'name' => 'Campaign Admin',
            'email' => 'campaign-admin@example.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.campaigns.create'))
            ->assertOk()
            ->assertSee('Create Campaign')
            ->assertSee('Products within a price range')
            ->assertSee('type="checkbox" name="product_ids[]"', false)
            ->assertSee('PKT')
            ->assertDontSee('Use Ctrl');

        $anotherProduct = $this->product('another-admin-campaign-item', 2000);
        $this->actingAs($admin)
            ->post(route('admin.campaigns.store'), [
                'name' => 'Admin test sale',
                'type' => 'product',
                'product_ids' => [$product->id, $anotherProduct->id],
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'starts_at' => now()->subMinute()->format('Y-m-d H:i:s'),
                'ends_at' => '',
                'is_active' => 1,
            ])
            ->assertRedirect(route('admin.campaigns.index'));

        $this->assertSame(850.0, (float) $product->fresh()->discount_price);
        $this->assertSame(1700.0, (float) $anotherProduct->fresh()->discount_price);
        $this->assertDatabaseHas('campaigns', [
            'name' => 'Admin test sale',
            'type' => 'product',
            'is_active' => true,
        ]);
    }

    public function test_campaign_schedule_is_shown_in_pkt_and_saved_in_the_app_timezone(): void
    {
        config(['app.timezone' => 'UTC']);

        $admin = User::create([
            'name' => 'Campaign Admin',
            'email' => 'campaign-time-admin@example.com',
            'password' => 'password',
            'is_admin' => true,
        ]);
        $startsAt = now('Asia/Karachi')->addDay()->startOfHour()->format('Y-m-d\TH:i');
        $endsAt = Carbon::parse($startsAt, 'Asia/Karachi')->addHours(2)->format('Y-m-d\TH:i');

        $this->actingAs($admin)
            ->post(route('admin.campaigns.store'), [
                'name' => 'PKT schedule test',
                'type' => 'all_active',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'is_active' => 1,
            ])
            ->assertRedirect(route('admin.campaigns.index'));

        $this->assertDatabaseHas('campaigns', [
            'name' => 'PKT schedule test',
            'starts_at' => Carbon::parse($startsAt, 'Asia/Karachi')->setTimezone('UTC')->format('Y-m-d H:i:s'),
            'ends_at' => Carbon::parse($endsAt, 'Asia/Karachi')->setTimezone('UTC')->format('Y-m-d H:i:s'),
        ]);

        $campaign = Campaign::where('name', 'PKT schedule test')->firstOrFail();
        $this->actingAs($admin)
            ->get(route('admin.campaigns.edit', $campaign))
            ->assertOk()
            ->assertSee('value="'.$startsAt.'"', false)
            ->assertSee('value="'.$endsAt.'"', false);

        $this->get(route('admin.campaigns.index'))
            ->assertOk()
            ->assertSee($campaign->starts_at->timezone('Asia/Karachi')->format('M j, Y H:i'));
    }

    public function test_admin_can_create_a_price_range_with_only_one_bound(): void
    {
        $cheapProduct = $this->product('below-minimum', 1000);
        $includedProduct = $this->product('above-minimum', 3000);
        $higherProduct = $this->product('also-above-minimum', 5000);
        $admin = User::create([
            'name' => 'Campaign Admin',
            'email' => 'range-admin@example.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.campaigns.store'), [
                'name' => 'Minimum-only sale',
                'type' => 'price_range',
                'price_min' => 2000,
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'starts_at' => now()->subMinute()->format('Y-m-d H:i:s'),
                'ends_at' => '',
                'is_active' => 1,
            ])
            ->assertRedirect(route('admin.campaigns.index'));

        $this->assertNull($cheapProduct->fresh()->discount_price);
        $this->assertSame(2700.0, (float) $includedProduct->fresh()->discount_price);
        $this->assertSame(4500.0, (float) $higherProduct->fresh()->discount_price);
    }

    public function test_pivot_migration_preserves_existing_single_product_campaigns(): void
    {
        $product = $this->product('legacy-campaign-item', 1000);
        $campaignId = DB::table('campaigns')->insertGetId([
            'name' => 'Legacy product campaign',
            'type' => 'product',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'product_id' => $product->id,
            'starts_at' => now()->subMinute()->toDateTimeString(),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = require database_path('migrations/2026_11_14_000002_create_campaign_products_table.php');
        $migration->up();

        $this->assertDatabaseHas('campaign_products', [
            'campaign_id' => $campaignId,
            'product_id' => $product->id,
        ]);
    }

    private function product(string $slug, float $price, ?int $categoryId = null, bool $isActive = true): Product
    {
        return Product::create([
            'slug' => $slug,
            'name' => str_replace('-', ' ', ucfirst($slug)),
            'price' => $price,
            'price_paisa' => (int) round($price * 100),
            'category' => 'other',
            'category_id' => $categoryId,
            'is_active' => $isActive,
        ]);
    }

    private function category(string $collectionSlug, string $categorySlug): ProductCategory
    {
        $collection = CatalogCollection::where('slug', $collectionSlug)->firstOrFail();

        return ProductCategory::firstOrCreate(
            ['collection_id' => $collection->id, 'slug' => $categorySlug],
            ['name' => ucfirst($categorySlug), 'is_active' => true]
        );
    }

    private function campaign(array $overrides = []): Campaign
    {
        $productIds = $overrides['product_ids'] ?? [];
        unset($overrides['product_ids']);

        $campaign = Campaign::create(array_merge([
            'name' => 'Test campaign',
            'type' => 'all_active',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'starts_at' => now()->subMinute(),
            'ends_at' => null,
            'is_active' => true,
        ], $overrides));

        if ($productIds !== []) {
            $campaign->products()->sync($productIds);
        }

        return $campaign;
    }
}
