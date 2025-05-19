<?php $__env->startSection('title', 'Users'); ?>

<?php $__env->startSection('page-heading', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Users</h2>
        <div class="flex items-center gap-2">
            <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search user..." class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded-full border border-blue-500 text-blue-500 bg-white hover:bg-blue-50 transition-all text-sm font-medium">
                    <i class="fas fa-search"></i> Search
                </button>
                <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
                    <i class="fas fa-times"></i> Reset
                </a>
                <?php endif; ?>
            </form>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-50 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-2 text-center"><?php echo e(($users->currentPage() - 1) * $users->perPage() + $index + 1); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($user->username); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($user->email); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                <?php echo e($user->role === 'admin' ? 'bg-purple-100 text-purple-800' :
                                   ($user->role === 'content' ? 'bg-yellow-100 text-yellow-800' :
                                      ($user->role === 'saler' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'))); ?>">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($user->is_active): ?>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            <?php else: ?>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 mr-1" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if(auth()->id() != $user->id): ?>
                                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($users->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\521H0251_NguyenVanKhoa\Aptech\Project_T1\New folder\Carrio-Motors\resources\views/admin/users/index.blade.php ENDPATH**/ ?>