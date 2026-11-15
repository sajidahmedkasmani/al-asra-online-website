<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_sync_uses_current_product_data_and_saves_the_session_cart(): void
    {
        $product = Product::create([
            'external_id' => 101,
            'slug' => 'everyday-product',
            'name' => 'Everyday product',
            'price' => 0,
            'price_paisa' => 125000,
            'image_url' => '/images/everyday-product.png',
            'category' => 'everyday-essentials',
            'is_active' => true,
        ]);

        $this->postJson(route('cart.sync'), [
            'items' => [['id' => $product->id, 'qty' => 2]],
        ])
            ->assertOk()
            ->assertJsonPath("cart.{$product->id}.name", $product->name)
            ->assertJsonPath("cart.{$product->id}.price", 1250)
            ->assertJsonPath("cart.{$product->id}.quantity", 2)
            ->assertJsonPath('summary.subtotal', 2500);

        $this->assertSame(2, session("cart.{$product->id}.quantity"));
    }

    public function test_cart_sync_rejects_inactive_products(): void
    {
        $product = Product::create([
            'external_id' => 102,
            'slug' => 'inactive-product',
            'name' => 'Inactive product',
            'price' => 0,
            'price_paisa' => 100000,
            'category' => 'everyday-essentials',
            'is_active' => false,
        ]);

        $this->postJson(route('cart.sync'), [
            'items' => [['id' => $product->id, 'qty' => 1]],
        ])
            ->assertUnprocessable()
            ->assertJsonPath('message', 'One or more products are no longer available. Please update your cart.');

        $this->assertEmpty(session('cart', []));
    }
}
