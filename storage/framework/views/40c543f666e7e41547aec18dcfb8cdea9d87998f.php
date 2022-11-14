<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
	<?php if(View::exists('admin.layout.logo')): ?>
        <?php echo $__env->make('admin.layout.logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a role="button" class="dropdown-toggle nav-link">
                <span>
                    <?php if(Auth::check() && Auth::user()->avatar_thumb_url): ?>
                        <img src="<?php echo e(Auth::user()->avatar_thumb_url); ?>" class="avatar-photo">
                    <?php elseif(Auth::check() && Auth::user()->first_name && Auth::user()->last_name): ?>
                        <span class="avatar-initials"><?php echo e(mb_substr(Auth::user()->first_name, 0, 1)); ?><?php echo e(mb_substr(Auth::user()->last_name, 0, 1)); ?></span>
                    <?php elseif(Auth::check() && Auth::user()->name): ?>
                        <span class="avatar-initials"><?php echo e(mb_substr(Auth::user()->name, 0, 1)); ?></span>
                    <?php elseif(Auth::guard(config('admin-auth.defaults.guard'))->check() && Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name && Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name): ?>
                        <span class="avatar-initials"><?php echo e(mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name, 0, 1)); ?><?php echo e(mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name, 0, 1)); ?></span>
                    <?php else: ?>
                        <span class="avatar-initials"><i class="fa fa-user"></i></span>
                    <?php endif; ?>

                    <?php if(!is_null(config('admin-auth.defaults.guard'))): ?>
                        <span class="hidden-md-down"><?php echo e(Auth::guard(config('admin-auth.defaults.guard'))->check() ? Auth::guard(config('admin-auth.defaults.guard'))->user()->full_name : 'Anonymous'); ?></span>
                    <?php else: ?>
                        <span class="hidden-md-down"><?php echo e(Auth::check() ? Auth::user()->full_name : 'Anonymous'); ?></span>
                    <?php endif; ?>

                </span>
                <span class="caret"></span>
            </a>
            <?php if(View::exists('admin.layout.profile-dropdown')): ?>
                <?php echo $__env->make('admin.layout.profile-dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    </ul>
</header><?php /**PATH D:\xampp\htdocs\bbb-lb\vendor\brackets\admin-ui\src/../resources/views/admin/partials/header.blade.php ENDPATH**/ ?>