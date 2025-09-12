<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce Store')</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffc107;
        }

        .cart-icon {
            position: relative;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ffc107;
            color: #333;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .main-content {
            padding: 2rem 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 1rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .product-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 0.5rem;
        }

        .product-stock {
            color: #666;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #007bff;
            color: #007bff;
        }

        .btn-outline:hover {
            background: #007bff;
            color: white;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-group .btn {
            flex: 1;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #666;
        }

        .search-box {
            width: 100%;
            max-width: 400px;
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 25px;
            font-size: 1rem;
            margin: 1rem 0;
        }

        .search-box:focus {
            outline: none;
            border-color: #007bff;
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 0.5rem;
            margin: 2rem 0;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            color: #007bff;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .active a {
            background-color: #007bff;
            color: white;
        }

        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .single-product {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin: 2rem 0;
        }

        .product-image-large {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-details h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .product-details .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 1rem;
        }

        .product-details .description {
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .breadcrumb {
            display: flex;
            list-style: none;
            margin-bottom: 2rem;
        }

        .breadcrumb li {
            margin-right: 0.5rem;
        }

        .breadcrumb li:after {
            content: '>';
            margin-left: 0.5rem;
            color: #666;
        }

        .breadcrumb li:last-child:after {
            content: '';
        }

        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .navbar .container {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-nav {
                gap: 1rem;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .single-product {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('product.index') }}" class="navbar-brand">
                🛍️ E-Commerce Store
            </a>
            
            <ul class="navbar-nav">
                <li><a href="{{ route('product.index') }}" class="nav-link">Home</a></li>
                <li><a href="{{ route('product.index') }}" class="nav-link">Products</a></li>
                <li>
                    <a href="{{ route('cart.index') }}" class="cart-icon">
                        🛒 Cart
                        <span class="cart-badge" id="cart-count">{{ count(session('cart', [])) }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} E-Commerce Store. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Update cart count
        function updateCartCount() {
            fetch('{{ route("cart.index") }}')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const cartItems = doc.querySelectorAll('.product-item');
                    document.getElementById('cart-count').textContent = cartItems.length;
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Add to cart with AJAX
        function addToCart(productId) {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch(`/product/${productId}/add-to-cart`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success';
                alert.innerHTML = '✅ Product added to cart successfully!';
                document.querySelector('.main-content .container').insertBefore(alert, document.querySelector('.main-content .container').firstChild);
                
                // Update cart count
                updateCartCount();
                
                // Auto-hide alert after 3 seconds
                setTimeout(() => {
                    alert.remove();
                }, 3000);
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert('Error adding product to cart');
            });
        }

        // Handle add to cart button clicks
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-add-cart')) {
                    const button = e.target.closest('.btn-add-cart');
                    const productId = button.getAttribute('data-product-id');
                    if (productId) {
                        addToCart(productId);
                    }
                }
            });
        });

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success')) {
                    alert.remove();
                }
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>
</html>