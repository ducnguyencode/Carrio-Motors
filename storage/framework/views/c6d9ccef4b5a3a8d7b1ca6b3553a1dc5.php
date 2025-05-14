<?php $__env->startSection('title', 'Activity Logs'); ?>

<?php $__env->startSection('page-heading', 'Activity Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Filter Logs</h2>
        <form action="<?php echo e(route('activity-logs.index')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select name="user_id" id="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Users</option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>" <?php echo e(request('user_id') == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="action" class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                <select name="action" id="action" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Actions</option>
                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($action); ?>" <?php echo e(request('action') == $action ? 'selected' : ''); ?>><?php echo e(ucfirst($action)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="module" class="block text-sm font-medium text-gray-700 mb-1">Module</label>
                <select name="module" id="module" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Modules</option>
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($module); ?>" <?php echo e(request('module') == $module ? 'selected' : ''); ?>><?php echo e(ucfirst($module)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 lg:col-span-4 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
                <a href="<?php echo e(route('activity-logs.index')); ?>" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($log->created_at->format('Y-m-d H:i:s')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($log->user_name ?? 'System'); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e(ucfirst($log->user_role ?? 'N/A')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                <?php echo e($log->action == 'create' ? 'bg-green-100 text-green-800' :
                                   ($log->action == 'update' ? 'bg-blue-100 text-blue-800' :
                                      ($log->action == 'delete' ? 'bg-red-100 text-red-800' :
                                         ($log->action == 'login' ? 'bg-purple-100 text-purple-800' :
                                            ($log->action == 'logout' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'))))); ?>">
                                <?php echo e(ucfirst($log->action)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e(ucfirst($log->module)); ?>

                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('activity-logs.show', $log)); ?>" class="text-indigo-600 hover:text-indigo-900">
                                View Details
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">No activity logs found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($logs->withQueryString()->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/admin/activity-logs/index.blade.php ENDPATH**/ ?>