<?php $__env->startSection('title', 'Prime Numbers'); ?>
<?php $__env->startSection('content'); ?>
  <div class="card m-4">
    <div class="card-header">Prime Numbers</div>
    <div class="card-body">
      <?php $__currentLoopData = range(1, 100); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isPrime($i)): ?>
          <span class="badge bg-primary"><?php echo e($i); ?></span>  
        <?php else: ?>
          <span class="badge bg-secondary"><?php echo e($i); ?></span>  
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/s/websec/WebSecService/resources/views/prime.blade.php ENDPATH**/ ?>