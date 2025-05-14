<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Banner Management</h5>
                    <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus-circle me-1"></i> New Banner
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="ps-4">#</th>
                                    <th scope="col">Video Preview</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Car</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="ps-4"><?php echo e($banner->id); ?></td>
                                    <td>
                                        <?php if($banner->video_url): ?>
                                            <div style="width: 120px; height: 68px; overflow: hidden;">
                                                <video width="120" height="68" controls muted>
                                                    <source src="<?php echo e(Storage::url($banner->video_url)); ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No Video</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(Str::limit($banner->main_content, 50)); ?></td>
                                    <td>
                                        <?php if($banner->car): ?>
                                            <?php echo e($banner->car->name); ?>

                                        <?php else: ?>
                                            <span class="text-muted">No car linked</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($banner->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end">
                                            <a href="<?php echo e(route('admin.banners.edit', $banner->id)); ?>" class="btn btn-sm btn-primary me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.banners.destroy', $banner->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this banner?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-muted mb-0">No banners found</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-end">
                        <?php echo e($banners->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Tu5k\study\php\Carrio-Motors\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>