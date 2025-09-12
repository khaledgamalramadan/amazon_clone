<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root { --amazon-gold:#f3a847; --amazon-blue:#131921; --amazon-light-blue:#232f3e; }
        body { background:#eaeded; }
        .right-col { position: sticky; top: 1rem; }
        .mini-thumb { width:84px; height:84px; object-fit:contain; background:#fff; border:1px solid #e5e7eb; border-radius:.5rem; }
        .price { font-weight:700; }
        .qty-chip { border:1px solid #d1d5db; border-radius:999px; overflow:hidden; }
        .qty-chip .btn { border:0; }
        .card-flat { border:1px solid #e5e7eb; border-radius:.75rem; }
        .cart-title { font-weight:600; }
        .item-row { border-top:1px solid #e5e7eb; }
        .action-link { color:#007185; text-decoration:none; }
    </style>
</head>
<body>
<main class="container my-4">
    <div class="row g-4">
        <!-- LEFT -->
        <div class="col-lg-9">
            <div id="cart-empty" class="{{ $cartItems->count() > 0 ? 'd-none' : '' }}">
                <div class="card card-flat bg-white mb-3">
                    <div class="card-body text-center">
                        <h3 class="mb-2">Your cart is empty</h3>
                        <p class="text-muted">Add some products to get started!</p>
                    </div>
                </div>
            </div>

            <div id="cart-filled" class="{{ $cartItems->count() > 0 ? '' : 'd-none' }}">
                <div class="card card-flat bg-white mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h3 class="mb-0 cart-title">Shopping Cart</h3>
                            <small><a href="#" class="text-decoration-none" id="clearCart">Clear all</a></small>
                        </div>
                        
                        @if($cartItems->count() > 0)
                            @foreach($cartItems as $index => $item)
                                <div class="row align-items-start py-3 item-row">
                                    <div class="col-sm-2">
                                        <img src="{{ $item->product->image ?? 'https://via.placeholder.com/100x100?text=No+Image' }}" 
                                             class="img-fluid rounded border" alt="{{ $item->product->name }}">
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
                                            <div class="qty-chip btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-secondary" data-dec="{{ $index }}" onclick="decreaseQuantity({{ $index }})">−</button>
                                                <button class="btn btn-sm btn-light" disabled id="qty-{{ $index }}">{{ $item->quantity }}</button>
                                                <button class="btn btn-sm btn-outline-secondary" data-inc="{{ $index }}" onclick="increaseQuantity({{ $index }})">+</button>
                                            </div>
                                            <a href="#" class="small action-link" data-del="{{ $index }}" onclick="deleteItem({{ $index }})">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                        <div class="text-end mt-2 h6">
                            Subtotal (<span id="subtotalCount">{{ $cartItems->sum('quantity') }}</span> item):
                            <strong>EGP <span id="subtotal">{{ number_format($total, 2) }}</span></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <aside class="col-lg-3">
            <div class="right-col summary-sticky">
                <div id="summaryBox" class="card card-flat bg-white mb-3 d-none">
                    <div class="card-body">
                        <div class="small fw-semibold">
                            Subtotal (<span id="sumCount">0</span> item):
                            <span class="price">EGP <span id="sumSubtotal">0.00</span></span>
                        </div>
                        <button class="btn btn-warning w-100 mt-3">Proceed to Buy</button>
                    </div>
                </div>

                <!-- Recommendations -->
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
                                    <button class="btn btn-sm btn-warning mt-1" data-add='{{ json_encode($product) }}'>Add to cart</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>
    </div>
</main>

<script>
    const $ = (s)=>document.querySelector(s);
    const $$=(s)=>Array.from(document.querySelectorAll(s));
    const egp = (n)=> n.toFixed(2);

    // Laravel data (products from DB)
    const products = @json($products);

    // Laravel cart data from DB
    const cartData = @json($cartItems);

    // Convert cart data to JavaScript format
    let cart = cartData.map(item => ({
        id: item.id, // Cart item ID for database operations
        productId: item.product.id, // Product ID
        name: item.product.name,
        description: item.product.description,
        price: parseFloat(item.price),
        image: item.product.image,
        qty: item.quantity
    }));

    // Initialize cart state based on current data
    const hasCartItems = {{ $cartItems->count() > 0 ? 'true' : 'false' }};

    function renderState(){
        const empty = cart.length === 0;
        $('#cart-empty').classList.toggle('d-none', !empty);
        $('#cart-filled').classList.toggle('d-none', empty);
        $('#summaryBox').classList.toggle('d-none', empty);
        
        // Update subtotal display
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const count = cart.reduce((sum, item) => sum + item.qty, 0);
        
        $('#subtotal').textContent = egp(subtotal);
        $('#subtotalCount').textContent = count;
        $('#sumSubtotal').textContent = egp(subtotal);
        $('#sumCount').textContent = count;
    }

    function renderFilled(){
        const list = $('#filledItems');
        list.innerHTML = '';
        let subtotal=0, count=0;
        cart.forEach((item, idx)=>{
            subtotal += item.price * item.qty; count += item.qty;
            const row = document.createElement('div');
            row.className = 'row align-items-start py-3 item-row';
            row.innerHTML = `
          <div class="col-sm-2"><img src="${item.image ?? ''}" class="img-fluid rounded border" alt="${item.name}"></div>
          <div class="col">
            <div class="d-flex justify-content-between">
              <div>
                <a class="fw-semibold text-decoration-none" href="#">${item.name}</a>
                <p class="small text-muted mb-1">${item.description ?? ''}</p>
              </div>
              <div class="price">EGP ${egp(item.price)}</div>
            </div>
            <div class="text-success small">In stock</div>
            <div class="d-flex align-items-center gap-3 mt-2">
              <div class="qty-chip btn-group" role="group">
                <button class="btn btn-sm btn-outline-secondary" data-dec="${idx}">−</button>
                <button class="btn btn-sm btn-light" disabled>${item.qty}</button>
                <button class="btn btn-sm btn-outline-secondary" data-inc="${idx}">+</button>
              </div>
              <a href="#" class="small action-link" data-del="${idx}">Delete</a>
            </div>
          </div>`;
            list.appendChild(row);
        });

        $('#subtotal').textContent = egp(subtotal);
        $('#subtotalCount').textContent = count;
        $('#sumSubtotal').textContent = egp(subtotal);
        $('#sumCount').textContent = count;

        $$('[data-inc]').forEach(b=>b.onclick=()=>{
            const idx = b.dataset.inc;
            if(cart[idx]) {
                cart[idx].qty++; 
                updateCartItem(cart[idx].id, cart[idx].qty).then(() => {
                    // Update the display
                    b.nextElementSibling.textContent = cart[idx].qty;
                    renderState();
                });
            }
        });
        $$('[data-dec]').forEach(b=>b.onclick=()=>{
            const idx = b.dataset.dec; 
            if(cart[idx]) {
                cart[idx].qty = Math.max(1, cart[idx].qty-1); 
                updateCartItem(cart[idx].id, cart[idx].qty).then(() => {
                    // Update the display
                    b.nextElementSibling.textContent = cart[idx].qty;
                    renderState();
                });
            }
        });
        $$('[data-del]').forEach(a=>a.onclick=(e)=>{
            e.preventDefault(); 
            const idx = a.dataset.del;
            if(cart[idx]) {
                removeCartItem(cart[idx].id).then(() => {
                    // Reload page to reflect changes
                    location.reload();
                });
            }
        });
    }

    function renderRecommendations(){
        const rec = $('#recommendations');
        rec.innerHTML = '';
        products.forEach(p=>{
            const div = document.createElement('div');
            div.className = "product-item py-2 d-flex gap-3 align-items-start";
            div.innerHTML = `
          <img class="mini-thumb" src="${p.image ?? ''}" alt="${p.name}"/>
          <div class="flex-grow-1">
            <a href="#" class="text-decoration-none">${p.name}</a>
            <p class="small text-muted mb-1">${p.description ?? ''}</p>
            <div class="price">EGP ${egp(p.price)}</div>
            <button class="btn btn-sm btn-warning mt-1" data-add='${JSON.stringify(p)}'>Add to cart</button>
          </div>`;
            rec.appendChild(div);
        });

        wireAdd();
    }

    function wireAdd(){
        $$('[data-add]').forEach(btn=>{
            btn.addEventListener('click', (e)=>{
                e.preventDefault();
                const data = JSON.parse(btn.getAttribute('data-add'));
                
                // Send AJAX request to add product to cart
                addToCart(data.id).then(() => {
                    // Reload page to show updated cart
                    location.reload();
                });
            });
        });
    }

    // AJAX functions to update database
    function updateCartItem(cartItemId, quantity) {
        return fetch(`/cart/update/${cartItemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            // Quantity updated successfully
        }).catch(error => {
            // Handle error silently
        });
    }

    function removeCartItem(cartItemId) {
        return fetch(`/cart/remove/${cartItemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            // Item removed successfully
        }).catch(error => {
            // Handle error silently
        });
    }

    function addToCart(productId) {
        return fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            // Product added successfully
        }).catch(error => {
            // Handle error silently
        });
    }

    $('#clearCart').onclick = (e)=>{ 
        e.preventDefault(); 
        // Clear all cart items from database
        fetch('/cart/clear-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(() => {
            location.reload();
        });
    };

    // Direct functions for quantity buttons
    function increaseQuantity(index) {
        if(cart[index]) {
            cart[index].qty++; 
            updateCartItem(cart[index].id, cart[index].qty).then(() => {
                document.getElementById(`qty-${index}`).textContent = cart[index].qty;
                renderState();
            });
        }
    }

    function decreaseQuantity(index) {
        if(cart[index]) {
            cart[index].qty = Math.max(1, cart[index].qty-1); 
            updateCartItem(cart[index].id, cart[index].qty).then(() => {
                document.getElementById(`qty-${index}`).textContent = cart[index].qty;
                renderState();
            });
        }
    }

    function deleteItem(index) {
        if(cart[index]) {
            removeCartItem(cart[index].id).then(() => {
                location.reload();
            });
        }
    }

    // Initialize the page
    renderState();
    wireAdd();
</script>
</body>
</html>

