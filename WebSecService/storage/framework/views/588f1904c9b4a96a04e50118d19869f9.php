<?php $__env->startSection('title', 'Prime Numbers'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card m-4">
        <div class="card-header">Even Numbers</div>
        <div class="card-body">
            <table>
                <?php $__currentLoopData = range(1, 100); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($i%2==0): ?>
                        <span class="badge bg-primary m-1"><?php echo e($i); ?>&nbsp;</span>
                    <?php else: ?>
                        <span class="badge bg-secondary m-1"><?php echo e($i); ?>&nbsp;</span>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/s/websec/WebSecService/resources/views/even.blade.php ENDPATH**/ ?>