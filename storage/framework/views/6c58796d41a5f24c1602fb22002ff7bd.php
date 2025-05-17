<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg mt-5">
                <div class="card-body p-0">
                    <div class="row">
                        <!-- Left side - Image -->
                        <div class="col-md-5 d-none d-md-block">
                            <div class="bg-image h-100" style="background-image: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1400&q=80'); background-size: cover; background-position: center; border-radius: 5px 0 0 5px;">
                                <div class="h-100 d-flex align-items-end p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">
                                    <div class="text-white text-center w-100">
                                        <h2 class="fw-bold mb-3">Carrio Motors</h2>
                                        <p class="mb-4">Your premium destination for luxury and performance vehicles.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right side - Form -->
                        <div class="col-md-7 p-5">
                            <h2 class="fw-bold mb-1">Welcome back</h2>
                            <p class="text-muted mb-4">Sign in to your account</p>

                            <?php if(session('error')): ?>
                                <div class="alert alert-danger mb-4">
                                    <strong>Error!</strong>
                                    <p class="mb-0"><?php echo e(session('error')); ?></p>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?php echo e(url('/admin')); ?>">
                                <?php echo csrf_field(); ?>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username or Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input id="username" name="username" type="text" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('username')); ?>" required placeholder="Enter your username or email">
                                    </div>
                                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input id="password" name="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required placeholder="Enter your password">
                                        <span class="input-group-text bg-white" style="border-left: 0;" id="togglePassword">
                                            <i class="fas fa-eye-slash text-muted" id="toggleIcon"></i>
                                        </span>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="d-flex justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none">Forgot password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 mb-4" style="background: linear-gradient(to right, #4f46e5, #0ea5e9); border: none;">
                                    Sign in
                                </button>

                                <div class="text-center">
                                    <p class="mb-0">
                                        Don't have an account?
                                        <a href="<?php echo e(url('/register')); ?>" class="text-decoration-none">Register now</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary:hover {
        background: linear-gradient(to right, #4338ca, #0284c7) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.2s;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .input-group-text {
        border-right: 0;
    }

    .form-control {
        border-left: 0;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function() {
            // Thay đổi kiểu input giữa password và text
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Thay đổi biểu tượng dựa trên trạng thái hiện tại
            if (type === 'password') {
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/Carrio-Motors/resources/views/auth/login.blade.php ENDPATH**/ ?>