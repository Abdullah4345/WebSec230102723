@extends('layouts.master')
@section('title', 'Test Page')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>
    <div class="col col-2">
        @can('add_products')
        <a href="{{route('products_edit')}}" class="btn btn-success form-control">Add Product</a>
        @endcan
    </div>
</div>
<form>
    <div class="row">
        <div class="col col-sm-2">
            <input name="keywords" type="text"  class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-2">
            <input name="min_price" type="numeric"  class="form-control" placeholder="Min Price" value="{{ request()->min_price }}"/>
        </div>
        <div class="col col-sm-2">
            <input name="max_price" type="numeric"  class="form-control" placeholder="Max Price" value="{{ request()->max_price }}"/>
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <select name="order_direction" class="form-select">
                <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
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


@foreach($products as $product)
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-12 col-lg-4">
                    <img src="{{asset("images/$product->photo")}}" class="img-thumbnail" alt="{{$product->name}}" width="100%">
                </div>
                <div class="col col-sm-12 col-lg-8 mt-3">
                    <div class="row mb-2">
					    <div class="col-8">
					        <h3>{{$product->name}}</h3>
					    </div>
					    <div class="col col-2">
                            @can('edit_products')
					        <a href="{{route('products_edit', $product->id)}}" class="btn btn-success form-control">Edit</a>
                            @endcan
					    </div>
					    <div class="col col-2">
                            @can('delete_products')
					        <a href="{{route('products_delete', $product->id)}}" class="btn btn-danger form-control">Delete</a>
                            @endcan
					    </div>
					</div>

                    <table class="table table-striped">
                        <tr><th width="20%">Name</th><td>{{$product->name}}</td></tr>
                        <tr><th>Model</th><td>{{$product->model}}</td></tr>
                        <tr><th>Code</th><td>{{$product->code}}</td></tr>
                        <tr><th>Price</th><td>${{number_format($product->price, 2)}}</td></tr>
                        <tr><th>Quantity</th>
                            <td>
                                @can('edit_products')
                                <input type="number" class="form-control quantity-input" 
                                    data-product-id="{{$product->id}}"
                                    value="{{$product->quantity}}"
                                    min="0">
                                @else
                                <span data-quantity-display="{{$product->id}}">{{$product->quantity}}</span>
                                <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock_status }}
                                </span>
                                @endcan
                            </td>
                        </tr>
                        <tr><th>Description</th><td>{{$product->description}}</td></tr>
                        @auth
                        <tr>
                            <th>Actions</th>
                            <td>
                                <button class="btn btn-primary btn-buy" 
                                        data-product-id="{{$product->id}}"
                                        {{$product->quantity < 1 ? 'disabled' : ''}}>
                                    Buy
                                </button>
                                @can('edit_products')
                                <button class="btn btn-success btn-add-stock"
                                        data-product-id="{{$product->id}}">
                                    Add Stock
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @endauth
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach

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

@push('scripts')
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
            url: `{{ url('/api/products') }}/${productId}/quantity`,
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
            url: `{{ url('/api/products') }}/${selectedProductId}/buy`,
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
            url: `{{ url('/api/products') }}/${selectedProductId}/quantity`,
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
@endpush
@endsection