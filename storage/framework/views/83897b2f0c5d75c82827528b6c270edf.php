<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('page-heading', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<!-- Add Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        background: white;
        margin: 0 auto;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    canvas#revenueChart {
        width: 100% !important;
        height: 100% !important;
        display: block;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php if(isset($error)): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="block sm:inline"><?php echo e($error); ?></span>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Users -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Users</p>
                <p class="text-2xl font-semibold"><?php echo e(number_format($totalUsers)); ?></p>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Cars -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-car text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Cars</p>
                <p class="text-2xl font-semibold"><?php echo e(number_format($totalCars)); ?></p>
            </div>
        </div>
    </div>

    <!-- Card 3: New Orders -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">New Orders (Today)</p>
                <p class="text-2xl font-semibold"><?php echo e(number_format($newOrdersToday)); ?></p>
            </div>
        </div>
    </div>

    <!-- Card 4: Monthly Revenue -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-dollar-sign text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Monthly Revenue</p>
                <p class="text-2xl font-semibold">$<?php echo e(number_format($revenueThisMonth, 2)); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Revenue Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-2">Monthly Revenue</h2>
        <p class="text-gray-600 mb-4">Revenue statistics for <?php echo e(date('Y')); ?></p>
        <p class="text-lg font-semibold mb-4">Total Revenue This Month: $<?php echo e(number_format($revenueThisMonth, 2)); ?></p>
        <div class="chart-container" style="height: 300px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Recent Orders</h2>
            <a href="<?php echo e(route('admin.invoices.index')); ?>" class="text-blue-500 hover:text-blue-700">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">Customer</th>
                        <th class="text-left py-2">Date</th>
                        <th class="text-left py-2">Status</th>
                        <th class="text-right py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-t">
                        <td class="py-2">#<?php echo e($invoice->id); ?></td>
                        <td class="py-2"><?php echo e($invoice->customer_name); ?></td>
                        <td class="py-2"><?php echo e($invoice->created_at->format('d/m/Y')); ?></td>
                        <td class="py-2">
                            <?php
                                $statusColors = [
                                    'pending' => 'yellow',
                                    'processing' => 'blue',
                                    'completed' => 'green',
                                    'cancelled' => 'red'
                                ];
                                $color = $statusColors[$invoice->status] ?? 'gray';
                            ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-<?php echo e($color); ?>-100 text-<?php echo e($color); ?>-800">
                                <?php echo e(ucfirst($invoice->status)); ?>

                            </span>
                        </td>
                        <td class="py-2 text-right">$<?php echo e(number_format($invoice->total_price, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartElement = document.getElementById('revenueChart');

    if (!chartElement) {
        console.error('Chart element not found');
        return;
    }

    try {
        const chartData = {
            labels: <?php echo json_encode($chartData['labels']); ?>,
            data: <?php echo json_encode($chartData['data']); ?>

        };

        new Chart(chartElement, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: chartData.data,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: $' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        console.log('Chart data:', chartData);
    } catch (error) {
        console.error('Error creating chart:', error);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors-clone\Carrio-Motors\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>