<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Shopping Cart</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    body { background:#eaeded; }
    .right-col { position: sticky; top: 1rem; }
    .mini-thumb { width:84px; height:84px; object-fit:contain; background:#fff; border:1px solid #e5e7eb; border-radius:.5rem; }
    .price { font-weight:700; }
    .qty-chip { border:1px solid #d1d5db; border-radius:999px; overflow:hidden; }
    .card-flat { border:1px solid #e5e7eb; border-radius:.75rem; }
    .cart-title { font-weight:600; }
    .item-row { border-top:1px solid #e5e7eb; }
    .action-link { color:#007185; text-decoration:none; }
  </style>
</head>
<body>
<main class="container my-4">
  @if(session('success'))
    <div class="alert alert-success small">{{ session('success') }}</div>
  @endif

  <div class="row g-4">
    <!-- LEFT -->
    <div class="col-lg-9">

      @if(!$cartItems->count())
        <div id="cart-empty">
          <div class="card card-flat bg-white mb-3">
            <div class="card-body text-center">
              <h3 class="mb-2">Your cart is empty</h3>
              <p class="text-muted">Add some products to get started!</p>
            </div>
          </div>
        </div>
      @endif

      @if($cartItems->count())
        <div id="cart-filled">
          <div class="card card-flat bg-white mb-3">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h3 class="mb-0 cart-title">Shopping Cart</h3>

        
                <form action="{{ route('cart.clear-all') }}" method="POST" class="m-0">
                  @csrf
                  <button class="btn btn-link p-0 small text-decoration-none">Clear all</button>
                </form>
              </div>

              @foreach($cartItems as $item)
                <div class="row align-items-start py-3 item-row">
                  <div class="col-sm-2">
                    <img
                      src="{{ $item->product->image ?? 'https://via.placeholder.com/100x100?text=No+Image' }}"
                      class="img-fluid rounded border"
                      alt="{{ $item->product->name }}"
                    >
                  </div>

                  <div class="col">
                    <div class="d-flex justify-content-between">
                      <div>
                        <a class="fw-semibold text-decoration-none" href="#">{{ $item->product->name }}</a>
                        <p class="small text-muted mb-1">{{ $item->product->description ?? '' }}</p>
                      </div>
                      <div class="price">EGP {{ number_format($item->price, 2) }}</div>
                    </div>

                    <div class="text-success small">In stock</div>

                    <div class="d-flex align-items-center gap-3 mt-2">
            
                      <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                        <button class="btn btn-sm btn-outline-secondary" type="submit" aria-label="Decrease quantity">−</button>
                      </form>

                   
                      <span class="btn btn-sm btn-light disabled">{{ $item->quantity }}</span>

                  
                      <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                        <button class="btn btn-sm btn-outline-secondary" type="submit" aria-label="Increase quantity">+</button>
                      </form>

                     
                      <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="small action-link btn btn-link p-0" type="submit">Delete</button>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach

              <div class="text-end mt-2 h6">
                Subtotal ({{ $cartItems->sum('quantity') }} item):
                <strong>EGP {{ number_format($total, 2) }}</strong>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>

    <!-- RIGHT -->
    <aside class="col-lg-3">
      <div class="right-col">
      
        @if($cartItems->count())
          <div id="summaryBox" class="card card-flat bg-white mb-3">
            <div class="card-body">
              <div class="small fw-semibold">
                Subtotal ({{ $cartItems->sum('quantity') }} item):
                <span class="price">EGP {{ number_format($total, 2) }}</span>
              </div>
              <a href="#" class="btn btn-warning w-100 mt-3">Proceed to Buy</a>
            </div>
          </div>
        @endif

   
        <div class="card card-flat bg-white">
          <div class="card-body">
            <h6 class="mb-3">Recommended Products</h6>

            @foreach($products as $product)
              <div class="product-item py-2 d-flex gap-3 align-items-start">
                <img class="mini-thumb" src="{{ $product->image ?? 'https://via.placeholder.com/84x84?text=No+Image' }}" alt="{{ $product->name }}"/>
                <div class="flex-grow-1">
                  <a href="#" class="text-decoration-none">{{ $product->name }}</a>
                  <p class="small text-muted mb-1">{{ $product->description ?? '' }}</p>
                  <div class="price">EGP {{ number_format($product->price, 2) }}</div>

           
                  <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-1">
                    @csrf
                    <button class="btn btn-sm btn-warning">Add to cart</button>
                  </form>
                </div>
              </div>
            @endforeach

          </div>
        </div>
      </div>
    </aside>
  </div>
</main>
</body>
</html>
