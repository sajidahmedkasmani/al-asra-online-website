<?php $__env->startSection('title', setting('store_brand_name', 'Al-Asra Store').' | Shop'); ?>

<?php $__env->startPush('head'); ?>
<style>
.shop-hero{position:relative;overflow:hidden;padding:clamp(42px,7vw,88px) 5vw;background:linear-gradient(120deg,#fff8f1 0%,#fff 58%,#ffe8da 100%)}
.shop-hero:after{content:"";position:absolute;width:420px;height:420px;right:-130px;top:-210px;border-radius:50%;background:#f24c0010}
.shop-hero-inner,.shop-content{width:min(1320px,100%);margin:0 auto}
.shop-breadcrumb{display:flex;gap:9px;align-items:center;margin-bottom:20px;color:#765c62;font-size:12px}
.shop-breadcrumb a:hover{color:var(--orange)}
.shop-heading-row{display:flex;align-items:flex-end;justify-content:space-between;gap:30px;position:relative;z-index:1}
.shop-heading h1{font-size:clamp(30px,5vw,58px);line-height:1.08;color:var(--plum)}
.shop-heading p{margin-top:12px;color:#6b5960;font-size:14px}
.shop-search{display:flex;align-items:center;gap:8px;width:min(380px,100%);padding:6px 7px 6px 16px;background:#fff;border:1px solid #5a102422;border-radius:999px;box-shadow:0 12px 30px -20px #5a102466}
.shop-search input{flex:1;min-width:0;border:0;outline:0;background:transparent;padding:9px 0;font:inherit;font-size:13px}
.shop-search button{border:0;border-radius:99px;background:var(--plum);color:#fff;padding:11px 20px;font:700 12px 'DM Sans';cursor:pointer}
.shop-search button:hover{background:var(--orange)}
.shop-filters{background:#fff;border-bottom:1px solid var(--line);box-shadow:0 8px 20px -20px #1e0a14}
.shop-filter-inner{width:min(1320px,100%);margin:0 auto;padding:16px 5vw;display:grid;gap:12px}
.shop-filter-row{display:flex;align-items:center;gap:8px;overflow-x:auto;scrollbar-width:none}
.shop-filter-row::-webkit-scrollbar{display:none}
.shop-chip{flex:none;display:inline-flex;align-items:center;min-height:38px;padding:8px 16px;border:1px solid #5a102425;border-radius:99px;color:var(--ink);font-size:12px;transition:background .2s,color .2s,border-color .2s}
.shop-chip:hover,.shop-chip.active{background:var(--plum);border-color:var(--plum);color:#fff}
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
.shop-page:hover,.shop-page.active{background:var(--plum);border-color:var(--plum);color:#fff}
.shop-page.disabled{opacity:.4}
.shop-empty{text-align:center;padding:60px 20px 70px}
.shop-empty h2{font-size:clamp(24px,4vw,36px);margin-bottom:10px}
.shop-empty p{max-width:440px;margin:0 auto 22px;color:#765c62;font-size:14px;line-height:1.6}
.shop-empty .btn{font-size:13px;padding:12px 22px}
@media(max-width:980px){.shop-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}}
@media(max-width:700px){.shop-heading-row{align-items:stretch;flex-direction:column;gap:22px}.shop-search{width:100%}.shop-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.shop-content{padding:30px 5vw 48px}.shop-grid .pcard{padding:8px;border-radius:14px}.shop-grid .pic{border-radius:11px}.shop-grid .pic img{padding:8px}.shop-grid .pcard .prow{align-items:flex-start;flex-direction:column}.shop-grid .pcard .addbag{width:100%}.shop-toolbar{align-items:flex-start;flex-direction:column}.shop-sort{width:100%;justify-content:space-between}.shop-sort select{flex:1}.shop-page{min-width:36px;height:36px;padding:0 11px}.shop-pagination{gap:5px;margin-top:30px}}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
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
?>

<section class="shop-hero">
    <div class="shop-hero-inner">
        <nav class="shop-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo e(route('home')); ?>">Home</a><span aria-hidden="true">/</span>
            <a href="<?php echo e(route('shop')); ?>">Shop</a>
            <?php if($selectedCollection): ?><span aria-hidden="true">/</span><span><?php echo e($selectedCollection->name); ?></span><?php endif; ?>
            <?php if($selectedCategory): ?><span aria-hidden="true">/</span><span><?php echo e($selectedCategory->name); ?></span><?php endif; ?>
        </nav>
        <div class="shop-heading-row">
            <div class="shop-heading">
                <span class="kick">Explore Al-Asra</span>
                <h1><?php echo e($heading); ?></h1>
                <p><?php echo e(number_format($total)); ?> <?php echo e(\Illuminate\Support\Str::plural('product', $total)); ?><?php echo e($searchTerm ? ' matching “'.$searchTerm.'”' : ' to discover'); ?></p>
            </div>
            <form method="GET" action="<?php echo e(route('shop')); ?>" class="shop-search" role="search">
                <?php if($categorySlug): ?><input type="hidden" name="category" value="<?php echo e($categorySlug); ?>"><?php endif; ?>
                <?php if($collectionSlug): ?><input type="hidden" name="collection" value="<?php echo e($collectionSlug); ?>"><?php endif; ?>
                <?php if($sort !== 'newest'): ?><input type="hidden" name="sort" value="<?php echo e($sort); ?>"><?php endif; ?>
                <input type="search" name="q" value="<?php echo e($searchTerm); ?>" placeholder="Search products..." aria-label="Search products">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</section>

<section class="shop-filters" aria-label="Shop filters">
    <div class="shop-filter-inner">
        <div class="shop-filter-row" aria-label="Collections">
            <a href="<?php echo e($filterUrl(['collection' => null, 'category' => null])); ?>" class="shop-chip <?php echo e(!$collectionSlug && !$categorySlug ? 'active' : ''); ?>">All products</a>
            <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($filterUrl(['collection' => $collection->slug, 'category' => null])); ?>" class="shop-chip <?php echo e($collectionSlug === $collection->slug ? 'active' : ''); ?>"><?php echo e($collection->name); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($visibleCategories->isNotEmpty()): ?>
            <div class="shop-filter-row shop-subfilters" aria-label="Categories">
                <?php if($collectionSlug): ?>
                    <a href="<?php echo e($filterUrl(['category' => null])); ?>" class="shop-chip sub <?php echo e(!$categorySlug ? 'active' : ''); ?>">All in <?php echo e($selectedCollection?->name ?? 'collection'); ?></a>
                <?php endif; ?>
                <?php $__currentLoopData = $visibleCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($filterUrl(['category' => $category->slug])); ?>" class="shop-chip sub <?php echo e($categorySlug === $category->slug ? 'active' : ''); ?>"><?php echo e($category->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <div class="shop-toolbar">
            <span class="shop-count">Showing <?php echo e($products->firstItem() ?? 0); ?>–<?php echo e($products->lastItem() ?? 0); ?> of <?php echo e(number_format($total)); ?> products</span>
            <form method="GET" action="<?php echo e(route('shop')); ?>" class="shop-sort">
                <?php if($categorySlug): ?><input type="hidden" name="category" value="<?php echo e($categorySlug); ?>"><?php endif; ?>
                <?php if($collectionSlug): ?><input type="hidden" name="collection" value="<?php echo e($collectionSlug); ?>"><?php endif; ?>
                <?php if($searchTerm): ?><input type="hidden" name="q" value="<?php echo e($searchTerm); ?>"><?php endif; ?>
                <label for="shop-sort">Sort by</label>
                <select id="shop-sort" name="sort" onchange="this.form.submit()">
                    <option value="newest" <?php echo e($sort === 'newest' ? 'selected' : ''); ?>>Newest</option>
                    <option value="price_asc" <?php echo e($sort === 'price_asc' ? 'selected' : ''); ?>>Price: low to high</option>
                    <option value="price_desc" <?php echo e($sort === 'price_desc' ? 'selected' : ''); ?>>Price: high to low</option>
                </select>
            </form>
        </div>
    </div>
</section>

<section class="shop-content">
    <?php if($products->count()): ?>
        <div class="pgrid shop-grid">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $image = $product->display_image ?? '/logo.png';
                    $cartItem = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => (float) $product->display_price,
                        'original_price' => (float) $product->original_price,
                        'image' => $image,
                    ];
                ?>
                <article class="pcard">
                    <a class="pic" href="<?php echo e($product->product_url); ?>">
                        <img src="<?php echo e($image); ?>" alt="<?php echo e($product->name); ?>" loading="lazy">
                    </a>
                    <small><?php echo e($product->productCategory?->name ?? $product->category ?? 'Al-Asra'); ?></small>
                    <h3><a href="<?php echo e($product->product_url); ?>"><?php echo e($product->name); ?></a></h3>
                    <div class="prow">
                        <b>
                            <?php if($product->has_discount): ?>
                                <del class="text-gray-400 font-normal mr-1">PKR <?php echo e(number_format($product->original_price)); ?></del>
                            <?php endif; ?>
                            PKR <?php echo e(number_format((float) $product->display_price)); ?>

                        </b>
                        <button class="addbag" type="button" onclick='AlAsraCart.add(<?php echo json_encode($cartItem, 15, 512) ?>)'>Add to bag</button>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($products->hasPages()): ?>
            <nav class="shop-pagination" aria-label="Pagination">
                <?php if($products->onFirstPage()): ?>
                    <span class="shop-page disabled" aria-disabled="true">←</span>
                <?php else: ?>
                    <a class="shop-page" href="<?php echo e($products->previousPageUrl()); ?>" aria-label="Previous page">←</a>
                <?php endif; ?>

                <?php for($page = max(1, $currentPage - 1); $page <= min($lastPage, $currentPage + 1); $page++): ?>
                    <a class="shop-page <?php echo e($page === $currentPage ? 'active' : ''); ?>" href="<?php echo e($products->url($page)); ?>" <?php if($page === $currentPage): ?> aria-current="page" <?php endif; ?>><?php echo e($page); ?></a>
                <?php endfor; ?>

                <?php if($products->hasMorePages()): ?>
                    <a class="shop-page" href="<?php echo e($products->nextPageUrl()); ?>" aria-label="Next page">→</a>
                <?php else: ?>
                    <span class="shop-page disabled" aria-disabled="true">→</span>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="shop-empty">
            <h2>No products found</h2>
            <p><?php echo e($searchTerm ? 'We could not find a match for “'.$searchTerm.'”. Try another search or clear your filters.' : 'There are no products in this selection right now. Browse all products to keep exploring.'); ?></p>
            <a class="btn" href="<?php echo e(route('shop')); ?>">View all products</a>
        </div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('storefront.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\al-asra-online-website\resources\views/frontend/shop/shop.blade.php ENDPATH**/ ?>