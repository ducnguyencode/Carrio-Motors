<?php $__env->startSection('title', 'Create Car Color'); ?>

<?php $__env->startSection('page-heading', 'Create New Car Color'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="<?php echo e(route('admin.car_colors.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Color Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                    Color Name <span class="text-red-500">*</span>
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

            <!-- Hex Code -->
            <div>
                <label for="hex_code" class="block text-sm font-semibold text-gray-700 mb-1">
                    Hex Code <span class="text-red-500">*</span>
                </label>
                <input type="text" name="hex_code" id="hex_code"
                       value="<?php echo e(old('hex_code')); ?>"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none <?php $__errorArgs = ['hex_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       required>
                <?php $__errorArgs = ['hex_code'];
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

            <!-- Status -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_active" id="is_active"
                       class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" <?php echo e(old('is_active') ? 'checked' : ''); ?>>
                <label for="is_active" class="ml-2 text-gray-700">Active</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="<?php echo e(route('admin.car_colors.index')); ?>" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">Create Car Color</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\Carrio-Motors\resources\views/admin/car_colors/create.blade.php ENDPATH**/ ?>