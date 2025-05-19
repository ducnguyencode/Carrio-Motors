<?php $__env->startSection('title', 'Create Model'); ?>

<?php $__env->startSection('page-heading', 'Create New Model'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="<?php echo e(route('models.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Model Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                    Model Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name"
                       value="<?php echo e(old('name')); ?>"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Make -->
            <div>
                <label for="make_id" class="block text-sm font-semibold text-gray-700 mb-1">
                    Make <span class="text-red-500">*</span>
                </label>
                <select name="make_id" id="make_id"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400">
                    <option value="">Select Make</option>
                    <?php $__currentLoopData = $makes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($make->id); ?>"><?php echo e($make->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['make_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Active Status -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="isActive" id="isActive"
                       class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" <?php echo e(old('isActive') ? 'checked' : ''); ?>>
                <label for="isActive" class="ml-2 text-gray-700">Active Model</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="<?php echo e(route('models.index')); ?>" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Create Model</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\Carrio-Motors\resources\views/admin/models/create.blade.php ENDPATH**/ ?>