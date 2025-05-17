<?php $__env->startSection('title', 'Car Makes'); ?>

<?php $__env->startSection('page-heading', 'Car Makes'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Makes</h2>
        <a href="<?php echo e(route('admin.makes.create')); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            <i class="fas fa-plus mr-2"></i> Add New Make
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $makes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($make->id); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($make->logo): ?>
                                <img src="<?php echo e(asset($make->logo)); ?>" alt="<?php echo e($make->name); ?>" class="h-10 w-auto">
                            <?php else: ?>
                                <span class="text-gray-400"><i class="fas fa-image"></i> No logo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($make->name); ?></td>
                        <td class="px-6 py-4"><?php echo e(Str::limit($make->description, 50)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('admin.makes.show', $make)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.makes.edit', $make)); ?>" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.makes.destroy', $make)); ?>" method="POST" class="inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this make?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No makes found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($makes->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\521H0251_NguyenVanKhoa\Aptech\Project_T1\New folder\Carrio-Motors\resources\views/admin/makes/index.blade.php ENDPATH**/ ?>