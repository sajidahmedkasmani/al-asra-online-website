@extends('admin.admin_layout.master')
@section('title', $campaign->exists ? 'Edit Campaign' : 'Create Campaign')

@section('content')
@php
    $selectedType = old('type', $campaign->type ?? 'all_active');
    $selectedDiscountType = old('discount_type', $campaign->discount_type ?? 'percentage');
    $selectedProductIds = old('product_ids', $selectedProductIds);
    $startsAt = old('starts_at', $campaign->starts_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i'));
    $endsAt = old('ends_at', $campaign->ends_at?->format('Y-m-d\TH:i'));
@endphp

<form method="POST" action="{{ $campaign->exists ? route('admin.campaigns.update', $campaign) : route('admin.campaigns.store') }}"
      x-data="{ type: @js($selectedType), discountType: @js($selectedDiscountType) }" class="max-w-4xl">
    @csrf
    @if($campaign->exists) @method('PUT') @endif

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl px-4 py-3 text-sm mb-5">
            <p class="font-medium mb-1">Please fix the following:</p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl soft p-5 md:p-7 space-y-6">
        <label class="block">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Campaign name</span>
            <input name="name" value="{{ old('name', $campaign->name) }}" required maxlength="160" placeholder="e.g. Summer sale"
                   class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-brand-500">
        </label>

        <div>
            <label for="campaign-type" class="text-xs font-semibold uppercase tracking-wider text-gray-500">Apply discount to</label>
            <select id="campaign-type" name="type" x-model="type" required
                    class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-brand-500">
                <option value="all_active">All active products</option>
                <option value="category">A specific category</option>
                <option value="product">Specific products</option>
                <option value="price_range">Products within a price range</option>
            </select>
        </div>

        <div x-cloak x-show="type === 'category'">
            <label for="campaign-category" class="text-xs font-semibold uppercase tracking-wider text-gray-500">Category</label>
            <select id="campaign-category" name="category_id" :required="type === 'category'"
                    class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
                <option value="">Choose category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $campaign->category_id) === (string) $category->id)>
                        {{ $category->collection?->name }} — {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div x-cloak x-show="type === 'product'">
            <label for="campaign-products" class="text-xs font-semibold uppercase tracking-wider text-gray-500">Products</label>
            <select id="campaign-products" name="product_ids[]" multiple :required="type === 'product'"
                    class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm" size="7">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected(in_array((string) $product->id, array_map('strval', $selectedProductIds), true))>
                        {{ $product->name }} — Rs. {{ number_format($product->price > 0 ? $product->price : $product->price_paisa / 100) }}
                    </option>
                @endforeach
            </select>
            <span class="block text-xs text-gray-400 mt-1">Select one or more products. Use Ctrl (Windows) or Command (Mac) to select multiple.</span>
        </div>

        <div x-cloak x-show="type === 'price_range'" class="grid sm:grid-cols-2 gap-4">
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Minimum original price (Rs.) — optional</span>
                <input type="number" name="price_min" min="0" step="0.01"
                       value="{{ old('price_min', $campaign->price_min) }}"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
            </label>
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Maximum original price (Rs.) — optional</span>
                <input type="number" name="price_max" min="0" step="0.01"
                       value="{{ old('price_max', $campaign->price_max) }}"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
            </label>
            <p class="sm:col-span-2 text-xs text-gray-400">Enter a minimum, a maximum, or both. Limits are inclusive and use original prices.</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Discount type</span>
                <select name="discount_type" x-model="discountType" required class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
                    <option value="percentage" @selected($selectedDiscountType === 'percentage')>Percentage (%)</option>
                    <option value="fixed" @selected($selectedDiscountType === 'fixed')>Fixed amount (Rs.)</option>
                </select>
            </label>
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Discount value</span>
                <input type="number" name="discount_value" min="0.01" step="0.01" required
                       :max="discountType === 'percentage' ? 100 : null"
                       value="{{ old('discount_value', $campaign->discount_value) }}"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
                <span class="block text-xs text-gray-400 mt-1">A fixed discount cannot reduce a product below Rs. 0.</span>
            </label>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Starts at</span>
                <input type="datetime-local" name="starts_at" value="{{ $startsAt }}" required
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
            </label>
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Ends at (optional)</span>
                <input type="datetime-local" name="ends_at" value="{{ $endsAt }}"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
                <span class="block text-xs text-gray-400 mt-1">Leave empty for a campaign with no end date.</span>
            </label>
        </div>

        <label class="flex items-center gap-3 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $campaign->exists ? $campaign->is_active : true))
                   class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
            <span>Campaign is enabled</span>
        </label>
    </div>

    <div class="mt-5 bg-sky-50 border border-sky-100 text-sky-800 rounded-2xl px-4 py-3 text-sm">
        If campaigns overlap, the one with the latest start time takes precedence for each product.
    </div>

    <div class="flex flex-wrap gap-3 mt-6">
        <button class="btn-bloom rounded-2xl px-6 py-3 text-sm font-semibold">
            {{ $campaign->exists ? 'Save campaign' : 'Create campaign' }}
        </button>
        <a href="{{ route('admin.campaigns.index') }}" class="rounded-2xl bg-white px-6 py-3 text-sm font-semibold text-gray-600 shadow-sm">Cancel</a>
    </div>
</form>
@endsection
