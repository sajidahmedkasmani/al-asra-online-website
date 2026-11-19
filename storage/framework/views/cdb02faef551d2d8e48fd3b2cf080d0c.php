<?php $__env->startSection('title', $campaign->exists ? 'Edit Campaign' : 'Create Campaign'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $selectedType = old('type', $campaign->type ?? 'all_active');
    $selectedDiscountType = old('discount_type', $campaign->discount_type ?? 'percentage');
    $selectedProductIds = old('product_ids', $selectedProductIds);
    $startsAt = old('starts_at', $campaign->starts_at?->timezone('Asia/Karachi')->format('Y-m-d\TH:i') ?? now('Asia/Karachi')->format('Y-m-d\TH:i'));
    $endsAt = old('ends_at', $campaign->ends_at?->timezone('Asia/Karachi')->format('Y-m-d\TH:i'));
?>

<form method="POST" action="<?php echo e($campaign->exists ? route('admin.campaigns.update', $campaign) : route('admin.campaigns.store')); ?>"
      x-data="{ type: <?php echo \Illuminate\Support\Js::from($selectedType)->toHtml() ?>, discountType: <?php echo \Illuminate\Support\Js::from($selectedDiscountType)->toHtml() ?> }" class="max-w-4xl">
    <?php echo csrf_field(); ?>
    <?php if($campaign->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl px-4 py-3 text-sm mb-5">
            <p class="font-medium mb-1">Please fix the following:</p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl soft p-5 md:p-7 space-y-6">
        <label class="block">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Campaign name</span>
            <input name="name" value="<?php echo e(old('name', $campaign->name)); ?>" required maxlength="160" placeholder="e.g. Summer sale"
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
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if((string) old('category_id', $campaign->category_id) === (string) $category->id): echo 'selected'; endif; ?>>
                        <?php echo e($category->collection?->name); ?> — <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div x-cloak x-show="type === 'product'">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Products</span>
            <div id="campaign-products" class="mt-2 max-h-72 overflow-y-auto rounded-2xl border border-gray-200 divide-y divide-gray-100">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-gray-50">
                        <input type="checkbox" name="product_ids[]" value="<?php echo e($product->id); ?>"
                               <?php if(in_array((string) $product->id, array_map('strval', $selectedProductIds), true)): echo 'checked'; endif; ?>
                               class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                        <span><?php echo e($product->name); ?> <span class="text-gray-500">— Rs. <?php echo e(number_format($product->price > 0 ? $product->price : $product->price_paisa / 100)); ?></span></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <span class="block text-xs text-gray-400 mt-1">Tick one or more products.</span>
        </div>

        <div x-cloak x-show="type === 'price_range'" class="grid sm:grid-cols-2 gap-4">
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Minimum original price (Rs.) — optional</span>
                <input type="number" name="price_min" min="0" step="0.01"
                       value="<?php echo e(old('price_min', $campaign->price_min)); ?>"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
            </label>
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Maximum original price (Rs.) — optional</span>
                <input type="number" name="price_max" min="0" step="0.01"
                       value="<?php echo e(old('price_max', $campaign->price_max)); ?>"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
            </label>
            <p class="sm:col-span-2 text-xs text-gray-400">Enter a minimum, a maximum, or both. Limits are inclusive and use original prices.</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Discount type</span>
                <select name="discount_type" x-model="discountType" required class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
                    <option value="percentage" <?php if($selectedDiscountType === 'percentage'): echo 'selected'; endif; ?>>Percentage (%)</option>
                    <option value="fixed" <?php if($selectedDiscountType === 'fixed'): echo 'selected'; endif; ?>>Fixed amount (Rs.)</option>
                </select>
            </label>
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Discount value</span>
                <input type="number" name="discount_value" min="0.01" step="0.01" required
                       :max="discountType === 'percentage' ? 100 : null"
                       value="<?php echo e(old('discount_value', $campaign->discount_value)); ?>"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
                <span class="block text-xs text-gray-400 mt-1">A fixed discount cannot reduce a product below Rs. 0.</span>
            </label>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Starts at <span class="ml-1 text-[10px] font-bold text-brand-600">PKT</span></span>
                <input type="datetime-local" name="starts_at" value="<?php echo e($startsAt); ?>" required
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
            </label>
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Ends at (optional) <span class="ml-1 text-[10px] font-bold text-brand-600">PKT</span></span>
                <input type="datetime-local" name="ends_at" value="<?php echo e($endsAt); ?>"
                       class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm">
                <span class="block text-xs text-gray-400 mt-1">Leave empty for a campaign with no end date.</span>
            </label>
        </div>

        <label class="flex items-center gap-3 text-sm">
            <input type="checkbox" name="is_active" value="1" <?php if(old('is_active', $campaign->exists ? $campaign->is_active : true)): echo 'checked'; endif; ?>
                   class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
            <span>Campaign is enabled</span>
        </label>
    </div>

    <div class="mt-5 bg-sky-50 border border-sky-100 text-sky-800 rounded-2xl px-4 py-3 text-sm">
        If campaigns overlap, the one with the latest start time takes precedence for each product.
    </div>

    <div class="flex flex-wrap gap-3 mt-6">
        <button class="btn-bloom rounded-2xl px-6 py-3 text-sm font-semibold">
            <?php echo e($campaign->exists ? 'Save campaign' : 'Create campaign'); ?>

        </button>
        <a href="<?php echo e(route('admin.campaigns.index')); ?>" class="rounded-2xl bg-white px-6 py-3 text-sm font-semibold text-gray-600 shadow-sm">Cancel</a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\al-asra-online-website\resources\views/admin/campaigns/form.blade.php ENDPATH**/ ?>