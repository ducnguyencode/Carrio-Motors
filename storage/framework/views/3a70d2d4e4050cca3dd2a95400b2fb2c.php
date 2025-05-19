<?php $__env->startSection('title', 'Car Colors'); ?>

<?php $__env->startSection('page-heading', 'Car Color Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Car Colors</h2>
        <a href="<?php echo e(route('admin.car_colors.create')); ?>" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
            <i class="fas fa-plus"></i> Add Car Color
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hex Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $carcolors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-2 text-center"><?php echo e(($colors->currentPage() - 1) * $colors->perPage() + $index + 1); ?></td>
                        <td class="px-6 py-4"><?php echo e($color->color_name); ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" style="background-color: <?php echo e($color->hex_code); ?>"><?php echo e($color->hex_code); ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('admin.car_colors.edit', $color)); ?>" class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.car_colors.destroy', $color)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No car colors found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($carcolors->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\Carrio-Motors\resources\views/admin/car_colors/index.blade.php ENDPATH**/ ?>