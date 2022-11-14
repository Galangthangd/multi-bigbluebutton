<?php $__env->startSection('body'); ?>

    <div class="welcome-quote">

	    <blockquote>
		    <?php echo e(explode(" - ", $inspiration)[0]); ?>

		    <cite>
			    <?php echo e(explode(" - ", $inspiration)[1]); ?>

		    </cite>
	    </blockquote>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('brackets/admin-ui::admin.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\bbb-lb\vendor\brackets\admin-auth\src/../resources/views/admin/homepage/index.blade.php ENDPATH**/ ?>