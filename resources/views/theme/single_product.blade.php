@extends('theme.master')

@section('content')

<div class="mt-4 container-fluid">
    <div class="row">
        <div class="col-md-4 style-img">
            <div class="img-left">
                <img src="{{ asset($product->image) }}" class="img-thumbnail mb-2" alt="{{ $product->title }}" onmouseover="changeImage(this)">
            </div>
            <div id="mainImage" class="img-right" style="background-image: url('{{ asset($product->image) }}');"></div>
        </div>
        <div class="col-md-6">
            <a style="text-decoration: none; color: inherit; font-size:16px;" href="#">{{ $product->brand }}</a>
            <h2 class="product-title text-muted">{{ $product->title }}</h2>
            <p class="rating">
                {{ number_format($product->rating, 1) }}
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= $product->rating ? '⭐' : '☆' }}
                @endfor
                <a style="text-decoration: none; color: inherit; font-size:16px;" href="#" class="ms-4">{{ $product->reviews_count }} ratings</a>
            </p>
            <hr />
            <h6 class="text-muted">Price: <span class="text-danger fs-4">EGP {{ number_format($product->price, 2) }}</span></h6>
            @if($product->old_price)
                <h6 class="ms-5 text-muted">Was: <span class="text-decoration-line-through">EGP {{ number_format($product->old_price, 2) }}</span></h6>
            @endif
            <h6 class="ms-5">All prices include VAT.</h6>
            <div class="d-flex">
                <div class="icons-price">
                    <div>
                        <img src="https://m.media-amazon.com/images/G/42/A2I-Convert/mobile/IconFarm/icon-ePay._CB589360495_.png" alt="" class="icon-img">
                    </div>
                    <div class="icon-content">
                        <a style="text-decoration: none; color: inherit; font-size:16px;" href="#">Electronic Payment Only</a>
                    </div>
                </div>
                <div class="icons-price">
                    <div>
                        <img src="https://m.media-amazon.com/images/G/42/A2I-Convert/mobile/IconFarm/trust_icon_free_shipping_81px._CB590597072_.png" alt="" class="icon-img">
                    </div>
                    <div class="icon-content">
                        <a style="text-decoration: none; color: inherit; font-size:16px;" href="#">Free<br>Delivery</a>
                    </div>
                </div>
                <div class="icons-price">
                    <div>
                        <img src="https://m.media-amazon.com/images/G/42/A2I-Convert/mobile/IconFarm/icon-secure-transaction._CB414468582_.png" alt="" class="icon-img">
                    </div>
                    <div class="icon-content">
                        <a style="text-decoration: none; color: inherit; font-size:16px;" href="#">Secure transaction</a>
                    </div>
                </div>
            </div>
            <hr />
            <div>
                <h6 class="text-muted">Delivery: <span class="text-black">FREE delivery {{ date('D, d M', strtotime($product->delivery_date)) }}</span></h6>
            </div>
            <hr />
            <div>
                <h4>About this item</h4>
                <ul>
                    @foreach(explode("\n", $product->description) as $item)
                        @if(trim($item))
                            <li>{{ trim($item) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-2 buy-box p-3">
            <h4 class="text-danger">EGP {{ number_format($product->price, 2) }}</h4>
            <form action="{{ route('product.addToCart', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning w-100 mb-2 border rounded">Add to Cart</button>
            </form>
            <button class="btn border w-100">Add to List</button>
        </div>
    </div>
</div>

<script>
    var mainImage = document.getElementById("mainImage");
    function changeImage(element) {
        let bigSrc = element.dataset.big ? element.dataset.big : element.src;
        mainImage.style.backgroundImage = `url(${bigSrc})`;
        document.querySelectorAll(".img-left img").forEach(img => {
            img.classList.remove("active");
        });
        element.classList.add("active");
    }
    document.addEventListener("DOMContentLoaded", () => {
        let first = document.querySelector(".img-left img");
        if (first) changeImage(first);
    });
</script>
@endsection

