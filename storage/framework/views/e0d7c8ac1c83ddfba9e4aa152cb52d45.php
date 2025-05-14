<?php $__env->startSection('title', 'Engines'); ?>

<?php $__env->startSection('page-heading', 'Engines'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Engines</h2>
        <a href="<?php echo e(route('admin.engines.create')); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            <i class="fas fa-plus mr-2"></i> Add New Engine
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
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Displacement</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cylinders</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fuel Type</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $engines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $engine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($engine->id); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($engine->name); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($engine->displacement ? $engine->displacement . 'L' : 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($engine->cylinders ?: 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($engine->power ? $engine->power . ' HP' : 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                <?php echo e($engine->fuel_type == 'gasoline' ? 'bg-blue-100 text-blue-800' :
                                   ($engine->fuel_type == 'diesel' ? 'bg-gray-100 text-gray-800' :
                                   ($engine->fuel_type == 'electric' ? 'bg-green-100 text-green-800' :
                                   ($engine->fuel_type == 'hybrid' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800')))); ?>">
                                <?php echo e(ucfirst($engine->fuel_type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('admin.engines.show', $engine)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.engines.edit', $engine)); ?>" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.engines.destroy', $engine)); ?>" method="POST" class="inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this engine?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No engines found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($engines->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/admin/engines/index.blade.php ENDPATH**/ ?>