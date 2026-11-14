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
        $campaigns = Campaign::with(['category', 'product'])
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
        Campaign::create($this->targetFields($data));
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
        $campaign->update($this->targetFields($data));
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

        return view('admin.campaigns.form', compact('campaign', 'categories', 'products'));
    }

    private function validated(Request $request): array
    {
        $discountValueRules = $request->input('discount_type') === 'percentage'
            ? ['required', 'numeric', 'gt:0', 'lte:100']
            : ['required', 'numeric', 'gt:0'];

        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'type' => ['required', 'in:all_active,category,product,price_range'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => $discountValueRules,
            'category_id' => ['nullable', 'required_if:type,category', 'integer', 'exists:product_categories,id'],
            'product_id' => ['nullable', 'required_if:type,product', 'integer', 'exists:products,id'],
            'price_min' => ['nullable', 'required_if:type,price_range', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'required_if:type,price_range', 'numeric', 'gte:price_min'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function targetFields(array $data): array
    {
        $type = $data['type'];

        $data['category_id'] = $type === 'category' ? ($data['category_id'] ?? null) : null;
        $data['product_id'] = $type === 'product' ? ($data['product_id'] ?? null) : null;
        $data['price_min'] = $type === 'price_range' ? ($data['price_min'] ?? null) : null;
        $data['price_max'] = $type === 'price_range' ? ($data['price_max'] ?? null) : null;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        return $data;
    }
}
