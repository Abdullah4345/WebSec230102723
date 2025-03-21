<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./even">Even Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./prime">Prime Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./multable">Multiplication Table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('products_list')); ?>">Products</a>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_users')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('users')); ?>">Users</a>
            </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav">
            <?php if(auth()->guard()->check()): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('profile')); ?>"><?php echo e(auth()->user()->name); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('do_logout')); ?>">Logout</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/s/websec/WebSecService/resources/views/layouts/menu.blade.php ENDPATH**/ ?>