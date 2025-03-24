@extends('layouts.master')
@section('title', 'Purchase History')
@section('content')
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
                @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase['created_at'] }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($purchase['product']->photo)
                            <img src="{{ asset("images/{$purchase['product']->photo}") }}" 
                                 alt="{{ $purchase['product']->name }}" 
                                 class="me-2"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $purchase['product']->name }}</h6>
                                <small class="text-muted">{{ $purchase['product']->model }}</small>
                            </div>
                        </div>
                    </td>
                    <td>${{ number_format($purchase['price_paid'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
