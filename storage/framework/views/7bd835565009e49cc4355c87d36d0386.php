<?php $__env->startSection('title', 'Campaigns'); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-sm text-gray-500">Schedule discounts and choose which products they apply to.</p>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products.create')): ?>
            <a href="<?php echo e(route('admin.campaigns.create')); ?>" class="btn-bloom rounded-2xl px-5 py-3 text-sm font-semibold text-center">
                Create campaign
            </a>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-3xl soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Campaign</th>
                        <th class="px-5 py-4 font-semibold">Target</th>
                        <th class="px-5 py-4 font-semibold">Discount</th>
                        <th class="px-5 py-4 font-semibold">Schedule <span class="text-[10px]">PKT</span></th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $target = match ($campaign->type) {
                                'category' => $campaign->category?->name ?? 'Category removed',
                                'product' => $campaign->products->pluck('name')->join(', ') ?: 'No products selected',
                                'price_range' => ($campaign->price_min !== null ? 'Rs. '.number_format($campaign->price_min) : 'Any price')
                                    .' – '.($campaign->price_max !== null ? 'Rs. '.number_format($campaign->price_max) : 'No upper limit'),
                                default => 'All active products',
                            };
                            $status = !$campaign->is_active
                                ? 'Off'
                                : ($campaign->starts_at->isFuture()
                                    ? 'Scheduled'
                                    : ($campaign->ends_at && $campaign->ends_at->isPast() ? 'Ended' : 'Active'));
                            $statusClass = match ($status) {
                                'Active' => 'bg-emerald-50 text-emerald-700',
                                'Scheduled' => 'bg-sky-50 text-sky-700',
                                default => 'bg-gray-100 text-gray-600',
                            };
                        ?>
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-ink"><?php echo e($campaign->name); ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?php echo e(str_replace('_', ' ', ucfirst($campaign->type))); ?></p>
                            </td>
                            <td class="px-5 py-4 text-gray-600"><?php echo e($target); ?></td>
                            <td class="px-5 py-4 font-medium whitespace-nowrap">
                                <?php echo e(number_format((float) $campaign->discount_value, 2)); ?>

                                <?php echo e($campaign->discount_type === 'percentage' ? '%' : 'Rs.'); ?>

                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-gray-600">
                                <p><?php echo e($campaign->starts_at->timezone('Asia/Karachi')->format('M j, Y H:i')); ?></p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Until <?php echo e($campaign->ends_at?->timezone('Asia/Karachi')->format('M j, Y H:i') ?? 'No end date'); ?>

                                </p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($statusClass); ?>"><?php echo e($status); ?></span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end items-center gap-2">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products.edit')): ?>
                                        <a href="<?php echo e(route('admin.campaigns.edit', $campaign)); ?>" class="rounded-xl bg-gray-100 px-3 py-2 text-xs font-medium hover:bg-gray-200">Edit</a>
                                        <form method="POST" action="<?php echo e(route('admin.campaigns.toggle', $campaign)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button class="rounded-xl px-3 py-2 text-xs font-medium <?php echo e($campaign->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'); ?>">
                                                <?php echo e($campaign->is_active ? 'Turn off' : 'Turn on'); ?>

                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products.delete')): ?>
                                        <form method="POST" action="<?php echo e(route('admin.campaigns.destroy', $campaign)); ?>" onsubmit="return confirm('Delete this campaign?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700 hover:bg-rose-100">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-gray-500">
                                No campaigns yet. Create one to schedule your first discount.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($campaigns->hasPages()): ?>
            <div class="border-t border-gray-100 px-5 py-4"><?php echo e($campaigns->links()); ?></div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\al-asra-online-website\resources\views/admin/campaigns/index.blade.php ENDPATH**/ ?>