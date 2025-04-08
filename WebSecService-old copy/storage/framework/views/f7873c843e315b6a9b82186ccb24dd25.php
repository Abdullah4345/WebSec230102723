<?php $__env->startSection('title', 'Purchase History'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Purchase History</h1>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Price Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($purchase['created_at']); ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if($purchase['product']->photo): ?>
                            <img src="<?php echo e(asset("images/{$purchase['product']->photo}")); ?>" 
                                 alt="<?php echo e($purchase['product']->name); ?>" 
                                 class="me-2"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <?php endif; ?>
                            <div>
                                <h6 class="mb-0"><?php echo e($purchase['product']->name); ?></h6>
                                <small class="text-muted"><?php echo e($purchase['product']->model); ?></small>
                            </div>
                        </div>
                    </td>
                    <td>$<?php echo e(number_format($purchase['price_paid'], 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/WebSec230102723/WebSecService/resources/views/products/purchases.blade.php ENDPATH**/ ?>