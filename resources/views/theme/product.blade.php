@extends('theme.master')

@section('title', 'Products - E-Commerce Store')

@section('content')
<div class="page-header">
    <h1 class="page-title">Our Products</h1>
    <p class="page-subtitle">Discover our amazing collection of products</p>
    <input type="text" class="search-box" placeholder="Search products...">
</div>

@if($products->count() > 0)
    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                <div class="product-info">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <p class="product-description">
                        {{ \Illuminate\Support\Str::limit($product->description, 100) }}
                    </p>
                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                    <div class="product-stock">
                        📦 Stock: {{ $product->stock ?? 'Available' }}
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline">
                            👁️ View Details
                        </a>
                        <button type="button" class="btn btn-primary btn-add-cart" data-product-id="{{ $product->id }}">
                            🛒 Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
@else
    <div style="text-align: center; padding: 3rem; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3>📦 No Products Found</h3>
        <p>We're working on adding more products. Check back soon!</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="margin-top: 1rem;">Add Products</a>
    </div>
@endif
@endsection