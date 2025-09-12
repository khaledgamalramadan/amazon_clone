@extends('theme.master')

@section('title', $product->name . ' - E-Commerce Store')

@section('content')
<div class="breadcrumb">
    <li><a href="{{ route('product.index') }}">Products</a></li>
    <li>{{ $product->name }}</li>
</div>

<div class="single-product">
    <div>
        <img src="{{ asset($product->image) }}" class="product-image-large" alt="{{ $product->name }}">
    </div>
    <div class="product-details">
        <h1>{{ $product->name }}</h1>
        <div class="price">${{ number_format($product->price, 2) }}</div>
        
        <div class="product-stock" style="margin-bottom: 2rem;">
            📦 Stock: {{ $product->stock ?? 'Available' }}
        </div>
        
        <div class="description">
            <h3>Description</h3>
            <p>{{ $product->description }}</p>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <button type="button" class="btn btn-primary btn-add-cart" data-product-id="{{ $product->id }}">
                🛒 Add to Cart
            </button>
            <a href="{{ route('product.index') }}" class="btn btn-secondary">
                ← Back to Products
            </a>
        </div>
    </div>
</div>
@endsection