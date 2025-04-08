<?php $__env->startSection('title', 'Test Page'); ?>
<?php $__env->startSection('content'); ?>
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>
    <div class="col col-2">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_products')): ?>
        <a href="<?php echo e(route('products_edit')); ?>" class="btn btn-success form-control">Add Product</a>
        <?php endif; ?>
    </div>
</div>
<form>
    <div class="row">
        <div class="col col-sm-2">
            <input name="keywords" type="text"  class="form-control" placeholder="Search Keywords" value="<?php echo e(request()->keywords); ?>" />
        </div>
        <div class="col col-sm-2">
            <input name="min_price" type="numeric"  class="form-control" placeholder="Min Price" value="<?php echo e(request()->min_price); ?>"/>
        </div>
        <div class="col col-sm-2">
            <input name="max_price" type="numeric"  class="form-control" placeholder="Max Price" value="<?php echo e(request()->max_price); ?>"/>
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" <?php echo e(request()->order_by==""?"selected":""); ?> disabled>Order By</option>
                <option value="name" <?php echo e(request()->order_by=="name"?"selected":""); ?>>Name</option>
                <option value="price" <?php echo e(request()->order_by=="price"?"selected":""); ?>>Price</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <select name="order_direction" class="form-select">
                <option value="" <?php echo e(request()->order_direction==""?"selected":""); ?> disabled>Order Direction</option>
                <option value="ASC" <?php echo e(request()->order_direction=="ASC"?"selected":""); ?>>ASC</option>
                <option value="DESC" <?php echo e(request()->order_direction=="DESC"?"selected":""); ?>>DESC</option>
            </select>
        </div>
        <div class="col col-sm-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col col-sm-1">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
</form>


<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-12 col-lg-4">
                    <img src="<?php echo e(asset("images/$product->photo")); ?>" class="img-thumbnail" alt="<?php echo e($product->name); ?>" width="100%">
                </div>
                <div class="col col-sm-12 col-lg-8 mt-3">
                    <div class="row mb-2">
					    <div class="col-8">
					        <h3><?php echo e($product->name); ?></h3>
					    </div>
					    <div class="col col-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_products')): ?>
					        <a href="<?php echo e(route('products_edit', $product->id)); ?>" class="btn btn-success form-control">Edit</a>
                            <?php endif; ?>
					    </div>
					    <div class="col col-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_products')): ?>
					        <a href="<?php echo e(route('products_delete', $product->id)); ?>" class="btn btn-danger form-control">Delete</a>
                            <?php endif; ?>
					    </div>
					</div>

                    <table class="table table-striped">
                        <tr><th width="20%">Name</th><td><?php echo e($product->name); ?></td></tr>
                        <tr><th>Model</th><td><?php echo e($product->model); ?></td></tr>
                        <tr><th>Code</th><td><?php echo e($product->code); ?></td></tr>
                        <tr><th>Price</th><td>$<?php echo e(number_format($product->price, 2)); ?></td></tr>
                        <tr><th>Quantity</th>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_products')): ?>
                                <input type="number" class="form-control quantity-input" 
                                    data-product-id="<?php echo e($product->id); ?>"
                                    value="<?php echo e($product->quantity); ?>"
                                    min="0">
                                <?php else: ?>
                                <span data-quantity-display="<?php echo e($product->id); ?>"><?php echo e($product->quantity); ?></span>
                                <span class="badge bg-<?php echo e($product->quantity > 0 ? 'success' : 'danger'); ?>">
                                    <?php echo e($product->stock_status); ?>

                                </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr><th>Description</th><td><?php echo e($product->description); ?></td></tr>
                        <?php if(auth()->guard()->check()): ?>
                        <tr>
                            <th>Actions</th>
                            <td>
                                <button class="btn btn-primary btn-buy" 
                                        data-product-id="<?php echo e($product->id); ?>"
                                        <?php echo e($product->quantity < 1 ? 'disabled' : ''); ?>>
                                    Buy
                                </button>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_products')): ?>
                                <button class="btn btn-success btn-add-stock"
                                        data-product-id="<?php echo e($product->id); ?>">
                                    Add Stock
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Credit Card Modal -->
<div class="modal fade" id="creditCardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="creditCardForm">
                    <div class="mb-3">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" maxlength="19" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expiry (MM/YY)</label>
                        <input type="text" class="form-control" id="cardExpiry" maxlength="5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cardCvv" maxlength="3" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmPurchase">Confirm Purchase</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addStockForm">
                    <div class="mb-3">
                        <label class="form-label">Quantity to Add</label>
                        <input type="number" class="form-control" id="stockQuantity" min="1" value="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddStock">Add</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    let selectedProductId = null;
    // Initialize Bootstrap modals
    const creditCardModal = new bootstrap.Modal(document.getElementById('creditCardModal'));
    const addStockModal = new bootstrap.Modal(document.getElementById('addStockModal'));

    // Handle quantity changes
    $('.quantity-input').change(function() {
        const productId = $(this).data('product-id');
        const quantity = $(this).val();
        $.ajax({
            url: `<?php echo e(url('/api/products')); ?>/${productId}/quantity`,
            method: 'POST',
            data: { quantity: quantity },
            success: function(response) {
                const buyBtn = $(`.btn-buy[data-product-id="${productId}"]`);
                buyBtn.prop('disabled', quantity < 1);
                alert('Quantity updated successfully');
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.error || 'Failed to update quantity');
            }
        });
    }).each(function() {
        $(this).data('original-value', $(this).val());
    });

    // Handle buy button clicks
    $('.btn-buy').click(function(e) {
        e.preventDefault();
        selectedProductId = $(this).data('product-id');
        creditCardModal.show();
    });

    // Handle add stock button clicks
    $('.btn-add-stock').click(function(e) {
        e.preventDefault();
        selectedProductId = $(this).data('product-id');
        addStockModal.show();
    });

    // Handle purchase confirmation
    $('#confirmPurchase').click(function() {
        const cardData = {
            number: $('#cardNumber').val().replace(/\s/g, ''),
            expiry: $('#cardExpiry').val(),
            cvv: $('#cardCvv').val()
        };

        if (!/^\d{16}$/.test(cardData.number)) {
            alert('Please enter a valid 16-digit card number');
            return;
        }
        if (!/^\d{2}\/\d{2}$/.test(cardData.expiry)) {
            alert('Please enter expiry date in MM/YY format');
            return;
        }
        if (!/^\d{3}$/.test(cardData.cvv)) {
            alert('Please enter a valid 3-digit CVV');
            return;
        }

        $(this).prop('disabled', true).text('Processing...');

        $.ajax({
            url: `<?php echo e(url('/api/products')); ?>/${selectedProductId}/buy`,
            method: 'POST',
            data: { card: cardData },
            success: function(response) {
                creditCardModal.hide();
                const quantityDisplay = $(`.quantity-input[data-product-id="${selectedProductId}"], [data-quantity-display="${selectedProductId}"]`);
                const newQuantity = parseInt(quantityDisplay.val() || quantityDisplay.text()) - 1;
                quantityDisplay.each(function() {
                    if (this.tagName === 'INPUT') {
                        $(this).val(newQuantity);
                    } else {
                        $(this).text(newQuantity);
                    }
                });
                if (newQuantity < 1) {
                    $(`.btn-buy[data-product-id="${selectedProductId}"]`).prop('disabled', true);
                }
                $('#creditCardForm')[0].reset();
                alert('Purchase successful!');
            },
            error: function(xhr) {
                console.error('Purchase failed:', xhr.responseJSON); // Add debug logging
                alert(xhr.responseJSON?.error || 'Purchase failed - please try again');
            },
            complete: function() {
                $('#confirmPurchase').prop('disabled', false).text('Confirm Purchase');
            }
        });
    });

    // Format credit card number as user types
    $('#cardNumber').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, '').replace(/(\d{4})/g, '$1 ').trim());
    });

    // Format expiry date as user types
    $('#cardExpiry').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 2) {
            value = value.substr(0, 2) + '/' + value.substr(2, 2);
        }
        $(this).val(value);
    });

    // Add stock functionality
    $('#confirmAddStock').click(function() {
        const quantity = parseInt($('#stockQuantity').val());
        if (quantity < 1) {
            alert('Please enter a valid quantity');
            return;
        }

        $(this).prop('disabled', true).text('Adding...');
        const currentQuantity = parseInt($(`.quantity-input[data-product-id="${selectedProductId}"]`).val());
        const newQuantity = currentQuantity + quantity;

        $.ajax({
            url: `<?php echo e(url('/api/products')); ?>/${selectedProductId}/quantity`,
            method: 'POST',
            data: { quantity: newQuantity },
            success: function(response) {
                addStockModal.hide();
                $(`.quantity-input[data-product-id="${selectedProductId}"]`).val(newQuantity);
                $(`.btn-buy[data-product-id="${selectedProductId}"]`).prop('disabled', false);
                $('#addStockForm')[0].reset();
                alert('Stock added successfully!');
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.error || 'Failed to add stock');
            },
            complete: function() {
                $('#confirmAddStock').prop('disabled', false).text('Add');
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/WebSec230102723/WebSecService/resources/views/products/list.blade.php ENDPATH**/ ?>