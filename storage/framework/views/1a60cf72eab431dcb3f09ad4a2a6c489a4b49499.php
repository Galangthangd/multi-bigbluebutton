<?php $__env->startSection('header'); ?>
    <link href="<?php echo e(asset('css/index-page.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div id="logo" class="row">
            <div class="col-4">
                <img class="moodle-logo" src="<?php echo e(asset('assets/images/moodle-logo.png')); ?>" alt="Moodle Logo">
            </div>
            <div class="col-4">
                <img class="hou-logo" src="<?php echo e(asset('assets/images/videa-logo.png')); ?>" alt="HOU Logo">
            </div>
            <div class="col-4">
                <img class="bbb-logo" src="<?php echo e(asset('assets/images/bbb-logo.png')); ?>" alt="BBB Logo">
            </div>
        </div>



        <h1>Welcome to Big Blue Button Load Balance System Management</h1>
        <br>
        <h2>Please <a href="<?php echo e(url('/admin/login')); ?>">Login</a> to continue...</h2>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\bbb-lb\resources\views/pages/index.blade.php ENDPATH**/ ?>
