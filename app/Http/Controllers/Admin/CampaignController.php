<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\CampaignPriceSynchronizer;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with(['category', 'products'])
            ->latest()
            ->paginate(15);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return $this->form(new Campaign());
    }

    public function store(Request $request, CampaignPriceSynchronizer $synchronizer)
    {
        $data = $this->validated($request);
        $productIds = $this->targetFields($data);
        $campaign = Campaign::create($data);
        $campaign->products()->sync($productIds);
        $synchronizer->sync();

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created.');
    }

    public function edit(Campaign $campaign)
    {
        return $this->form($campaign);
    }

    public function update(Request $request, Campaign $campaign, CampaignPriceSynchronizer $synchronizer)
    {
        $data = $this->validated($request);
        $productIds = $this->targetFields($data);
        $campaign->update($data);
        $campaign->products()->sync($productIds);
        $synchronizer->sync();

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated.');
    }

    public function toggle(Campaign $campaign, CampaignPriceSynchronizer $synchronizer)
    {
        $campaign->update(['is_active' => !$campaign->is_active]);
        $synchronizer->sync();

        return back()->with('success', 'Campaign status updated.');
    }

    public function destroy(Campaign $campaign, CampaignPriceSynchronizer $synchronizer)
    {
        $campaign->delete();
        $synchronizer->sync();

        return back()->with('success', 'Campaign deleted.');
    }

    private function form(Campaign $campaign)
    {
        $categories = ProductCategory::with('collection')->orderBy('name')->get();
        $products = Product::orderBy('name')->get(['id', 'name', 'price', 'price_paisa']);
        $selectedProductIds = $campaign->exists ? $campaign->products()->pluck('products.id')->all() : [];

        return view('admin.campaigns.form', compact('campaign', 'categories', 'products', 'selectedProductIds'));
    }

    private function validated(Request $request): array
    {
        $discountValueRules = $request->input('discount_type') === 'percentage'
            ? ['required', 'numeric', 'gt:0', 'lte:100']
            : ['required', 'numeric', 'gt:0'];

        $priceMinRules = ['nullable', 'numeric', 'min:0'];
        $priceMaxRules = ['nullable', 'numeric', 'min:0'];
        if ($request->input('type') === 'price_range') {
            $priceMinRules[] = 'required_without:price_max';
            $priceMaxRules[] = 'required_without:price_min';
            if ($request->filled('price_min')) {
                $priceMaxRules[] = 'gte:price_min';
            }
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'type' => ['required', 'in:all_active,category,product,price_range'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => $discountValueRules,
            'category_id' => ['nullable', 'required_if:type,category', 'integer', 'exists:product_categories,id'],
            'product_ids' => ['nullable', 'required_if:type,product', 'array', 'min:1'],
            'product_ids.*' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'price_min' => $priceMinRules,
            'price_max' => $priceMaxRules,
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function targetFields(array &$data): array
    {
        $type = $data['type'];
        $productIds = $type === 'product' ? ($data['product_ids'] ?? []) : [];

        $data['category_id'] = $type === 'category' ? ($data['category_id'] ?? null) : null;
        $data['price_min'] = $type === 'price_range' ? ($data['price_min'] ?? null) : null;
        $data['price_max'] = $type === 'price_range' ? ($data['price_max'] ?? null) : null;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        unset($data['product_ids']);

        return $productIds;
    }
}
