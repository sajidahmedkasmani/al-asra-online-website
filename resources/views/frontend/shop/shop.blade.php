@extends('storefront.layout')
@section('title', setting('store_brand_name', 'Al-Asra Store').' | Shop')

@push('head')
<style>
.shop-hero{position:relative;overflow:hidden;padding:clamp(42px,7vw,88px) 5vw;background:linear-gradient(120deg,#fff8f1 0%,#fff 58%,#ffe8da 100%)}
.shop-hero:after{content:"";position:absolute;width:420px;height:420px;right:-130px;top:-210px;border-radius:50%;background:#f24c0010}
.shop-hero-inner,.shop-content{width:min(1320px,100%);margin:0 auto}
.shop-breadcrumb{display:flex;gap:9px;align-items:center;margin-bottom:20px;color:#765c62;font-size:12px}
.shop-breadcrumb a:hover{color:var(--orange)}
.shop-heading-row{display:flex;align-items:flex-end;justify-content:space-between;gap:30px;position:relative;z-index:1}
.shop-heading h1{font-size:clamp(30px,5vw,58px);line-height:1.08;color:var(--maroon)}
.shop-heading p{margin-top:12px;color:#6b5960;font-size:14px}
.shop-search{display:flex;align-items:center;gap:8px;width:min(380px,100%);padding:6px 7px 6px 16px;background:#fff;border:1px solid #5a102422;border-radius:999px;box-shadow:0 12px 30px -20px #5a102466}
.shop-search input{flex:1;min-width:0;border:0;outline:0;background:transparent;padding:9px 0;font:inherit;font-size:13px}
.shop-search button{border:0;border-radius:99px;background:var(--maroon);color:#fff;padding:11px 20px;font:700 12px 'DM Sans';cursor:pointer}
.shop-search button:hover{background:var(--orange)}
.shop-filters{background:#fff;border-bottom:1px solid var(--line);box-shadow:0 8px 20px -20px #1e0a14}
.shop-filter-inner{width:min(1320px,100%);margin:0 auto;padding:16px 5vw;display:grid;gap:12px}
.shop-filter-row{display:flex;align-items:center;gap:8px;overflow-x:auto;scrollbar-width:none}
.shop-filter-row::-webkit-scrollbar{display:none}
.shop-chip{flex:none;display:inline-flex;align-items:center;min-height:38px;padding:8px 16px;border:1px solid #5a102425;border-radius:99px;color:var(--ink);font-size:12px;transition:background .2s,color .2s,border-color .2s}
.shop-chip:hover,.shop-chip.active{background:var(--maroon);border-color:var(--maroon);color:#fff}
.shop-chip.sub{min-height:32px;padding:6px 13px;font-size:11px}
.shop-subfilters{padding-left:12px}
.shop-toolbar{display:flex;align-items:center;justify-content:space-between;gap:16px}
.shop-count{font-size:13px;color:#745e64}
.shop-sort{display:flex;align-items:center;gap:8px;font-size:12px;color:#745e64}
.shop-sort select{border:1px solid var(--line);border-radius:99px;background:#fff;padding:9px 34px 9px 14px;color:var(--ink);font:inherit;cursor:pointer}
.shop-content{padding:42px 5vw 68px}
.shop-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:22px}
.shop-grid .pcard{min-width:0}
.shop-grid .pic{aspect-ratio:1;background:#f7f4f0;border-radius:16px}
.shop-grid .pic img{object-fit:contain;padding:16px}
.shop-grid .pcard small{margin-top:4px;text-transform:uppercase;letter-spacing:.07em;font-size:10px}
.shop-grid .pcard h3{min-height:2.6em}
.shop-pagination{display:flex;justify-content:center;align-items:center;gap:8px;margin-top:42px}
.shop-page{min-width:40px;height:40px;display:inline-flex;align-items:center;justify-content:center;padding:0 14px;border:1px solid var(--line);border-radius:99px;font-size:12px}
.shop-page:hover,.shop-page.active{background:var(--maroon);border-color:var(--maroon);color:#fff}
.shop-page.disabled{opacity:.4}
.shop-empty{text-align:center;padding:60px 20px 70px}
.shop-empty h2{font-size:clamp(24px,4vw,36px);margin-bottom:10px}
.shop-empty p{max-width:440px;margin:0 auto 22px;color:#765c62;font-size:14px;line-height:1.6}
.shop-empty .btn{font-size:13px;padding:12px 22px}
@media(max-width:980px){.shop-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}}
@media(max-width:700px){.shop-heading-row{align-items:stretch;flex-direction:column;gap:22px}.shop-search{width:100%}.shop-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.shop-content{padding:30px 5vw 48px}.shop-grid .pcard{padding:8px;border-radius:14px}.shop-grid .pic{border-radius:11px}.shop-grid .pic img{padding:8px}.shop-grid .pcard .prow{align-items:flex-start;flex-direction:column}.shop-grid .pcard .addbag{width:100%}.shop-toolbar{align-items:flex-start;flex-direction:column}.shop-sort{width:100%;justify-content:space-between}.shop-sort select{flex:1}.shop-page{min-width:36px;height:36px;padding:0 11px}.shop-pagination{gap:5px;margin-top:30px}}
</style>
@endpush

@section('content')
@php
    $categorySlug = request('category');
    $collectionSlug = request('collection');
    $searchTerm = trim((string) request('q'));
    $sort = request('sort', 'newest');
    $total = $products->total();
    $selectedCategory = $categories->firstWhere('slug', $categorySlug);
    $selectedCollection = $collections->firstWhere('slug', $collectionSlug);
    $heading = $selectedCategory?->name ?? $selectedCollection?->name ?? 'Shop all products';
    $visibleCategories = $collectionSlug
        ? $categories->filter(fn ($category) => $category->collection?->slug === $collectionSlug)
        : $categories;
    $filterUrl = function (array $overrides = []) use ($categorySlug, $collectionSlug, $searchTerm, $sort) {
        $filters = array_merge([
            'category' => $categorySlug,
            'collection' => $collectionSlug,
            'q' => $searchTerm,
            'sort' => $sort,
        ], $overrides);

        return route('shop', array_filter($filters, fn ($value) => $value !== null && $value !== ''));
    };
    $currentPage = $products->currentPage();
    $lastPage = $products->lastPage();
@endphp

<section class="shop-hero">
    <div class="shop-hero-inner">
        <nav class="shop-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
            <a href="{{ route('shop') }}">Shop</a>
            @if($selectedCollection)<span aria-hidden="true">/</span><span>{{ $selectedCollection->name }}</span>@endif
            @if($selectedCategory)<span aria-hidden="true">/</span><span>{{ $selectedCategory->name }}</span>@endif
        </nav>
        <div class="shop-heading-row">
            <div class="shop-heading">
                <span class="kick">Explore Al-Asra</span>
                <h1>{{ $heading }}</h1>
                <p>{{ number_format($total) }} {{ \Illuminate\Support\Str::plural('product', $total) }}{{ $searchTerm ? ' matching “'.$searchTerm.'”' : ' to discover' }}</p>
            </div>
            <form method="GET" action="{{ route('shop') }}" class="shop-search" role="search">
                @if($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                @if($collectionSlug)<input type="hidden" name="collection" value="{{ $collectionSlug }}">@endif
                @if($sort !== 'newest')<input type="hidden" name="sort" value="{{ $sort }}">@endif
                <input type="search" name="q" value="{{ $searchTerm }}" placeholder="Search products..." aria-label="Search products">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</section>

<section class="shop-filters" aria-label="Shop filters">
    <div class="shop-filter-inner">
        <div class="shop-filter-row" aria-label="Collections">
            <a href="{{ $filterUrl(['collection' => null, 'category' => null]) }}" class="shop-chip {{ !$collectionSlug && !$categorySlug ? 'active' : '' }}">All products</a>
            @foreach($collections as $collection)
                <a href="{{ $filterUrl(['collection' => $collection->slug, 'category' => null]) }}" class="shop-chip {{ $collectionSlug === $collection->slug ? 'active' : '' }}">{{ $collection->name }}</a>
            @endforeach
        </div>

        @if($visibleCategories->isNotEmpty())
            <div class="shop-filter-row shop-subfilters" aria-label="Categories">
                @if($collectionSlug)
                    <a href="{{ $filterUrl(['category' => null]) }}" class="shop-chip sub {{ !$categorySlug ? 'active' : '' }}">All in {{ $selectedCollection?->name ?? 'collection' }}</a>
                @endif
                @foreach($visibleCategories as $category)
                    <a href="{{ $filterUrl(['category' => $category->slug]) }}" class="shop-chip sub {{ $categorySlug === $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="shop-toolbar">
            <span class="shop-count">Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ number_format($total) }} products</span>
            <form method="GET" action="{{ route('shop') }}" class="shop-sort">
                @if($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                @if($collectionSlug)<input type="hidden" name="collection" value="{{ $collectionSlug }}">@endif
                @if($searchTerm)<input type="hidden" name="q" value="{{ $searchTerm }}">@endif
                <label for="shop-sort">Sort by</label>
                <select id="shop-sort" name="sort" onchange="this.form.submit()">
                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: low to high</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: high to low</option>
                </select>
            </form>
        </div>
    </div>
</section>

<section class="shop-content">
    @if($products->count())
        <div class="pgrid shop-grid">
            @foreach($products as $product)
                @php
                    $image = $product->display_image ?? '/logo.png';
                    $cartItem = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => (float) $product->display_price,
                        'image' => $image,
                    ];
                @endphp
                <article class="pcard">
                    <a class="pic" href="{{ $product->product_url }}">
                        <img src="{{ $image }}" alt="{{ $product->name }}" loading="lazy">
                    </a>
                    <small>{{ $product->productCategory?->name ?? $product->category ?? 'Al-Asra' }}</small>
                    <h3><a href="{{ $product->product_url }}">{{ $product->name }}</a></h3>
                    <div class="prow">
                        <b>PKR {{ number_format((float) $product->display_price) }}</b>
                        <button class="addbag" type="button" onclick='AlAsraCart.add(@json($cartItem))'>Add to bag</button>
                    </div>
                </article>
            @endforeach
        </div>

        @if($products->hasPages())
            <nav class="shop-pagination" aria-label="Pagination">
                @if($products->onFirstPage())
                    <span class="shop-page disabled" aria-disabled="true">←</span>
                @else
                    <a class="shop-page" href="{{ $products->previousPageUrl() }}" aria-label="Previous page">←</a>
                @endif

                @for($page = max(1, $currentPage - 1); $page <= min($lastPage, $currentPage + 1); $page++)
                    <a class="shop-page {{ $page === $currentPage ? 'active' : '' }}" href="{{ $products->url($page) }}" @if($page === $currentPage) aria-current="page" @endif>{{ $page }}</a>
                @endfor

                @if($products->hasMorePages())
                    <a class="shop-page" href="{{ $products->nextPageUrl() }}" aria-label="Next page">→</a>
                @else
                    <span class="shop-page disabled" aria-disabled="true">→</span>
                @endif
            </nav>
        @endif
    @else
        <div class="shop-empty">
            <h2>No products found</h2>
            <p>{{ $searchTerm ? 'We could not find a match for “'.$searchTerm.'”. Try another search or clear your filters.' : 'There are no products in this selection right now. Browse all products to keep exploring.' }}</p>
            <a class="btn" href="{{ route('shop') }}">View all products</a>
        </div>
    @endif
</section>
@endsection
