<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ABD - Food Delivery')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800;900&display=swap');

        body {
            background: #ffffff;
            font-family: 'Inter', sans-serif;
            color: #1a1a1a;
            padding-bottom: 80px;
        }

        .nav-main {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(252, 128, 25, 0.1);
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #e23744;
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .search-bar {
            background: #f4f6f8;
            border-radius: 50px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            width: 400px;
            transition: all 0.3s ease;
        }

        .search-bar:focus-within {
            background: #fff;
            border: 1px solid #fc8019;
            box-shadow: 0 0 0 4px rgba(252, 128, 25, 0.15);
        }

        #search-results {
            position: absolute;
            top: 55px;
            width: 100%;
            background: white;
            border-radius: 12px;
            display: none;
            z-index: 999;
            max-height: 350px;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
        }

        .search-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f9f9f9;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-item:hover {
            background: #fff2eb;
        }

        .search-item-content {
            flex: 1;
            min-width: 0;
        }

        .search-item-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-item-price {
            font-size: 13px;
        }

        .highlight {
            color: #fc8019;
            font-weight: 600;
        }

        .search-bar input::placeholder {
            color: #999;
        }

        .search-bar input:focus {
            outline: none;
        }

        .nav-link-custom {
            font-size: 15px;
            font-weight: 500;
            color: #333;
            text-decoration: none;
        }

        .nav-link-custom:hover {
            color: #e23744;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            color: #1a1a1a;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: #fc8019;
            color: #fff;
            font-size: 11px;
            padding: 3px 7px;
            border-radius: 50%;
        }

        .sticky-cart {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 500px;
            background: #e23744;
            color: #fff;
            padding: 15px 25px;
            border-radius: 50px;
            z-index: 9999;
        }

        #cart-drawer {
            position: fixed;
            top: 0;
            right: -450px;
            width: 400px;
            height: 100%;
            background: #fff;
            z-index: 9999;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
            transition: 0.4s;
            display: flex;
            flex-direction: column;
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="nav-main">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('home') }}" class="logo">ABD</a>
                <a href="{{ route('home') }}" class="nav-link-custom">Home</a>
                <a href="{{ route('full.menu') }}" class="nav-link-custom">Menu</a>
            </div>

            <div class="search-wrapper d-none d-md-block" style="position:relative;">
                <form action="{{ route('full.menu') }}" method="GET" class="search-bar">
                    <i class="fa fa-search text-muted"></i>
                    <input type="text" id="search-input" name="q" placeholder="Search for dishes..." autocomplete="off"
                        style="border:none; outline:none; flex:1; background:transparent; padding:0 10px;">
                    <button type="submit" class="btn btn-sm"
                        style="background:#fc8019; color:white; border-radius:20px; padding:4px 12px;">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </form>
                <div id="search-results"></div>
            </div>

            <div class="d-flex align-items-center gap-4">
                <div onclick="openCart()" class="cart-icon">
                    <i class="fa fa-shopping-cart fs-5"></i>
                    <span class="cart-count">0</span>
                </div>

                @auth
                    <div class="dropdown">
                        <a class="nav-link-custom dropdown-toggle d-flex align-items-center gap-2"
                            data-bs-toggle="dropdown">
                            <img src="{{ Auth::user()->avatar_url }}" class="rounded-circle" width="30" height="30"
                                style="object-fit: cover; border: 1px solid #fc8019;">
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow mt-2">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Settings</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.orders') }}">My Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link-custom">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-warning">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>

    <main class="container py-4">
        @yield('content')
    </main>

    <div id="sticky-cart" style="display:none;" class="sticky-cart">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong id="cart-items-text"></strong> | ₹<span id="cart-total-text"></span>
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-light btn-sm rounded-pill px-4">View Cart</a>
        </div>
    </div>

    <div id="cart-drawer">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="m-0">Your Cart</h5>
            <button onclick="closeCart()" class="btn btn-sm btn-outline-danger">✕</button>
        </div>
        <div id="drawer-items" style="flex:1; overflow-y:auto;"></div>
        <div class="p-3 border-top bg-light">
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Total:</span>
                <span class="fw-bold text-danger">₹<span id="drawer-total">0</span></span>
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-warning w-100">Checkout Now</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Update Sticky Cart & Counts
        function updateCartUI() {
            fetch('{{ url("/cart-data") }}')
                .then(res => res.json())
                .then(data => {
                    const sticky = document.getElementById('sticky-cart');
                    if (data.count > 0) {
                        sticky.style.display = 'block';
                        document.getElementById('cart-items-text').innerText = data.count + ' Items';
                        document.getElementById('cart-total-text').innerText = data.total;
                        document.querySelectorAll('.cart-count').forEach(el => el.innerText = data.count);
                    } else {
                        sticky.style.display = 'none';
                        document.querySelectorAll('.cart-count').forEach(el => el.innerText = '0');
                    }
                });
        }

        // Drawer Functions
        function openCart() {
            document.getElementById('cart-drawer').style.right = '0';
            loadDrawer();
        }
        function closeCart() {
            document.getElementById('cart-drawer').style.right = '-450px';
        }

        function loadDrawer() {
            fetch('{{ url("/cart-items") }}')
                .then(res => res.json())
                .then(cart => {
                    let html = '', total = 0;
                    for (let id in cart) {
                        let i = cart[id];
                        total += i.price * i.quantity;
                        html += `
                        <div class="p-3 border-bottom d-flex gap-3 align-items-center">
                            <img src="${i.image}" class="rounded" style="width:50px;height:50px;object-fit:cover;">
                            <div style="flex:1;">
                                <div class="fw-bold text-truncate" style="max-width:180px;">${i.name}</div>
                                <small class="text-muted">₹${i.price} x ${i.quantity}</small>
                            </div>
                            <div class="fw-bold">₹${i.price * i.quantity}</div>
                        </div>`;
                    }
                    document.getElementById('drawer-items').innerHTML = html || '<div class="p-5 text-center text-muted">Your cart is empty</div>';
                    document.getElementById('drawer-total').innerText = total;
                });
        }

        // Search Logic
        document.addEventListener("DOMContentLoaded", function () {
            updateCartUI();

            let input = document.getElementById('search-input');
            let results = document.getElementById('search-results');

            input.addEventListener('input', function () {
                let q = this.value;
                if (q.length < 2) { results.style.display = 'none'; return; }

                fetch('{{ url("/search-food") }}?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(data => {
                        let html = '';
                        data.forEach(i => {
                            html += `
                            <div class="search-item" onclick="location='/food/${i.slug}'">
                                <img src="${i.image_url}" width="45" height="45" class="rounded">
                                <div class="search-item-content">
                                    <div class="search-item-name fw-bold">${i.name}</div>
                                    <div class="search-item-price text-muted">₹${i.price}</div>
                                </div>
                            </div>`;
                        });
                        results.innerHTML = html || '<div class="p-3 text-center">No results found</div>';
                        results.style.display = 'block';
                    });
            });

            // Hide search results when clicking outside
            document.addEventListener('click', (e) => {
                if (!input.contains(e.target) && !results.contains(e.target)) {
                    results.style.display = 'none';
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>