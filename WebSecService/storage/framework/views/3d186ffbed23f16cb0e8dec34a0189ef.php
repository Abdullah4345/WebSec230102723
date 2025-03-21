<?php $__env->startSection('title', 'Prime Numbers'); ?>
<?php $__env->startSection('content'); ?>
<div class="card m-4 col-sm-3">	
  <div class="card-header">Multiplication Table of <?php echo e($j); ?></div>
  <div class="card-body">
    <table>
      <?php $__currentLoopData = range(1, 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr><td><?php echo e($i); ?> * <?php echo e($j); ?></td><td> = <?php echo e($i * $j); ?></td></li>    
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/s/websec/WebSecService/resources/views/multable.blade.php ENDPATH**/ ?>