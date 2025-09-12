@extends('theme.master')

@section('content')
<div class="container">
  <div class="container">
    <!-- title page -->
    <div class="row">
      <div class="section-title">
        <h2>Products</h2>
        <p>There are many variations of passages of Lorem Ipsum available,<br>
          but the majority have suffered alteration in some form.</p>
      </div>
    </div>

    <!-- product cards wrapper -->
    <div class="product-wrapper">
      @forelse($products as $product)
      <!-- single product card -->
      <div class="product-card">
        <img src="{{ asset($product->image) }}" alt="{{ $product->title }}">  <!-- صورة من public/products/ -->
        <div class="product-info">
          <h4>{{ $product->brand }}</h4>
          <a href="{{ route('product.show', $product->id) }}">  <!-- رابط للمنتج الفردي -->
            <p>{{ $product->title }}</p>
          </a>
          <div class="stars">
            @for($i = 1; $i <= 5; $i++)
              {{ $i <= $product->rating ? '⭐' : '☆' }}
            @endfor
            <span style="font-size:12px; color:#555;">{{ $product->reviews_count }}</span>
          </div>
          <div class="price">EGP {{ number_format($product->price, 0) }} <small>EGP {{ number_format($product->old_price, 2) }}</small></div>
          <div class="delivery">FREE delivery <b>{{ date('D, d M', strtotime($product->delivery_date)) }}</b></div>
          <form action="{{ route('product.addToCart', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn">Add to cart</button>
          </form>
        </div>
      </div>
      @empty
      <div class="alert alert-info">لا توجد منتجات حاليًا. أضف بعضًا من <a href="{{ route('dashboard') }}">لوحة التحكم</a>.</div>
      @endforelse
    </div>

    <!-- Pagination -->
    {{ $products->links() }}
  </div>
</div>
@endsection
