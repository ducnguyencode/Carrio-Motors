<?php $__env->startSection('title', 'User Details'); ?>

<?php $__env->startSection('page-heading', 'User Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">User Information</h2>
        <div class="flex gap-2">
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <?php if(auth()->id() != $user->id): ?>
                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Username</h3>
                <p class="mt-1 text-base text-gray-900"><?php echo e($user->username); ?></p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Full Name</h3>
                <p class="mt-1 text-base text-gray-900"><?php echo e($user->fullname); ?></p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                <p class="mt-1 text-base text-gray-900"><?php echo e($user->email); ?></p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                <p class="mt-1 text-base text-gray-900"><?php echo e($user->phone ?: 'N/A'); ?></p>
            </div>
        </div>
        <div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Address</h3>
                <p class="mt-1 text-base text-gray-900"><?php echo e($user->address ?: 'N/A'); ?></p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Role</h3>
                <p class="mt-1">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                        <?php echo e($user->role == 'admin' ? 'bg-purple-100 text-purple-800' :
                           ($user->role == 'saler' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')); ?>">
                        <?php echo e(ucfirst($user->role)); ?>

                    </span>
                </p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <p class="mt-1">
                    <?php if($user->is_active): ?>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    <?php else: ?>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="mt-1 text-base text-gray-900"><?php echo e($user->created_at->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/admin/users/show.blade.php ENDPATH**/ ?>