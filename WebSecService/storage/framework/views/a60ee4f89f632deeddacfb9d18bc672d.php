<?php $__env->startSection('title', 'Register'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-center">
  <div class="card m-4 col-sm-6">
    <div class="card-body">
      <form action="<?php echo e(route('do_register')); ?>" method="post">
      <?php echo e(csrf_field()); ?>

      <div class="form-group">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-danger">
          <strong>Error!</strong> <?php echo e($error); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <div class="form-group mb-2">
        <label for="code" class="form-label">Name:</label>
        <input type="text" class="form-control" placeholder="name" name="name" required>
      </div>
      <div class="form-group mb-2">
        <label for="model" class="form-label">Email:</label>
        <input type="email" class="form-control" placeholder="email" name="email" required>
      </div>
      <div class="form-group mb-2">
        <label for="model" class="form-label">Password:</label>
        <input type="password" class="form-control" placeholder="password" name="password" required>
      </div>
      <div class="form-group mb-2">
        <label for="model" class="form-label">Password Confirmation:</label>
        <input type="password" class="form-control" placeholder="Confirmation" name="password_confirmation" required>
      </div>
      <div class="form-group mb-2">
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/s/websec/WebSecService/resources/views/users/register.blade.php ENDPATH**/ ?>