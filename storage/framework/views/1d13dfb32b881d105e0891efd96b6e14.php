<?php $__env->startSection('title', 'Create Car'); ?>

<?php $__env->startSection('page-heading', 'Create New Car'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="<?php echo e(route('admin.cars.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Car Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Car Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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

            <!-- Brand -->
            <div>
                <label for="brand" class="block text-sm font-semibold text-gray-700 mb-1">Brand <span class="text-red-500">*</span></label>
                <input type="text" name="brand" id="brand" value="<?php echo e(old('brand')); ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <?php $__errorArgs = ['brand'];
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

            <!-- Date Manufactured -->
            <div>
                <label for="date_manufactured" class="block text-sm font-semibold text-gray-700 mb-1">Manufactured Date <span class="text-red-500">*</span></label>
                <input type="date" name="date_manufactured" id="date_manufactured" value="<?php echo e(old('date_manufactured')); ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['date_manufactured'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <?php $__errorArgs = ['date_manufactured'];
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

            <!-- Engine -->
            <div>
                <label for="engine_id" class="block text-sm font-semibold text-gray-700 mb-1">Engine <span class="text-red-500">*</span></label>
                <select name="engine_id" id="engine_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['engine_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">Select Engine</option>
                    <?php $__currentLoopData = $engines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $engine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($engine->id); ?>" <?php echo e(old('engine_id') == $engine->id ? 'selected' : ''); ?>><?php echo e($engine->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['engine_id'];
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

            <!-- Model -->
            <div>
                <label for="model_id" class="block text-sm font-semibold text-gray-700 mb-1">Model <span class="text-red-500">*</span></label>
                <select name="model_id" id="model_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['model_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">Select Model</option>
                    <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($model->id); ?>" <?php echo e(old('model_id') == $model->id ? 'selected' : ''); ?>><?php echo e($model->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['model_id'];
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

            <!-- Seat Number -->
            <div>
                <label for="seat_number" class="block text-sm font-semibold text-gray-700 mb-1">Seat Number <span class="text-red-500">*</span></label>
                <input type="number" name="seat_number" id="seat_number" value="<?php echo e(old('seat_number')); ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['seat_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <?php $__errorArgs = ['seat_number'];
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

            <!-- Transmission -->
            <div>
                <label for="transmission" class="block text-sm font-semibold text-gray-700 mb-1">Transmission <span class="text-red-500">*</span></label>
                <select name="transmission" id="transmission" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['transmission'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="manual" <?php echo e(old('transmission') == 'manual' ? 'selected' : ''); ?>>Manual</option>
                    <option value="automatic" <?php echo e(old('transmission') == 'automatic' ? 'selected' : ''); ?>>Automatic</option>
                </select>
                <?php $__errorArgs = ['transmission'];
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

            <!-- Description -->
            <div class="col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
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

            <!-- Is Active -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" <?php echo e(old('is_active') ? 'checked' : ''); ?>>
                <label for="is_active" class="block text-base text-gray-700">Active Car</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="<?php echo e(route('admin.cars.index')); ?>" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">Create Car</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\Carrio-Motors\resources\views/admin/cars/create.blade.php ENDPATH**/ ?>