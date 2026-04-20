<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ABD - Food Delivery')</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap');

        body {
            background: #ffffff; /* Pure white background */
            font-family: 'Inter', sans-serif;
            color: #1a1a1a; /* Bold dark text */
            padding-bottom: 80px;
        }

        .nav-main {
            background: rgba(255, 255, 255, 0.98); /* Sharp white */
            backdrop-filter: blur(10px);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(252, 128, 25, 0.2);
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #e23744; /* Zomato Red */
            letter-spacing: -0.5px;
            transition: opacity 0.3s ease;
        }
        
        .logo:hover {
            opacity: 0.9;
            color: #e23744;
        }

        .search-wrapper {
            position: relative;
        }

        .search-bar {
            background: #f4f6f8; /* Crisp light grey */
            border-radius: 50px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            width: 400px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .search-bar:focus-within {
            background: #fff;
            border-color: #fc8019;
            box-shadow: 0 0 0 4px rgba(252, 128, 25, 0.15);
        }
        
        .search-bar .fa-search {
            color: #888 !important;
            transition: 0.3s;
        }
        
        .search-bar:focus-within .fa-search {
            color: #fc8019 !important;
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 15px;
            color: #1a1a1a;
        }
        
        .search-bar input::placeholder {
            color: #999;
        }

        .search-bar:focus-within input {
            color: #1a1a1a;
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }

        .search-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f9f9f9;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-item-content {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .search-item-name {
            font-size: 15px;
            font-weight: 500;
            color: #1a1a1a;
            line-height: 1.35;
            word-break: break-word;
        }

        .search-item-price {
            font-size: 14px;
            font-weight: 600;
            color: #444;
        }
        
        .search-item img {
            border-radius: 8px;
            object-fit: cover;
        }

        .search-item:hover {
            background: #fff2eb; /* Light vibrant orange tint */
        }

        .highlight {
            background: transparent;
            color: #fc8019;
            font-weight: 600;
        }

        .nav-link-custom {
            font-size: 15px;
            font-weight: 500;
            color: #333333;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-link-custom:hover {
            color: #e23744;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            color: #1a1a1a;
            transition: transform 0.2s;
        }
        
        .cart-icon:hover {
            transform: scale(1.05);
            color: #e23744;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: #fc8019;
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            border-radius: 50%;
            padding: 3px 7px;
            box-shadow: 0 4px 8px rgba(252, 128, 25, 0.3);
        }

        .sticky-cart {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 500px;
            background: #e23744; /* Zomato bottom cart */
            color: #fff;
            padding: 15px 25px;
            border-radius: 50px;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(226, 55, 68, 0.3);
        }

        .sticky-cart .btn-light {
            color: #e23744;
            font-weight: 600;
            border-radius: 50px;
            padding: 6px 20px;
            border: none;
        }

        /* 🛒 DRAWER */
        #cart-drawer {
            position: fixed;
            top: 0;
            right: -450px;
            width: 400px;
            max-width: 100vw;
            height: 100%;
            background: #fff;
            z-index: 9999;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
            transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
        }
        
        #cart-drawer h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            margin: 0;
            color: #1a1a1a;
        }
        
        .btn-warning {
            background-color: #fc8019;
            border-color: #fc8019;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-warning:hover {
            background-color: #e06c12;
            border-color: #e06c12;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(252, 128, 25, 0.3);
        }
    </style>

    @stack('styles')

</head>

<body>

    <!-- NAVBAR -->

    <div class="nav-main shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('home') }}" class="logo text-decoration-none">ABD</a>
                <a href="{{ route('home') }}" class="nav-link-custom">Home</a>
                <a href="{{ route('full.menu') }}" class="nav-link-custom">Menu</a>
                <a href="{{ route('about') }}" class="nav-link-custom">About</a>
            </div>

            <!-- SEARCH -->
            <div class="search-wrapper d-none d-md-block">
                <div class="search-bar">
                    <i class="fa fa-search me-2"></i>
                    <input type="text" id="search-input" placeholder="Search for restaurant, cuisine, or a dish...">
                </div>
                <div id="search-results"></div>
            </div>

            <!-- RIGHT -->
            <div class="d-flex align-items-center gap-4">

                <!-- 🛒 OPEN DRAWER -->
                <div onclick="openCart()" class="cart-icon text-dark">
                    <i class="fa fa-shopping-cart fs-5"></i>
                    <span class="cart-count">0</span>
                </div>

                @auth
                    <div class="dropdown">
                        <a class="nav-link-custom dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown" style="cursor: pointer;">
                            @if(Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle" width="30" height="30" style="object-fit: cover; border: 1px solid #fc8019;">
                            @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center fw-bold shadow-sm text-white" style="width: 30px; height: 30px; font-size: 12px; background-color: #fc8019;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            @endif
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fa fa-user me-2 text-muted"></i>Profile Settings</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('user.orders') }}"><i class="fa fa-box me-2 text-muted"></i>My Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item py-2 text-danger"><i class="fa fa-sign-out-alt me-2"></i>Logout</button>
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

    <!-- MAIN -->

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- FOOTER -->

    <footer class="text-center py-3">
        <h5>ABD Food Delivery</h5>
        <p>Fast delivery. Fresh food. Great taste.</p>
    </footer>

    <!-- 🛒 STICKY CART -->

    <div id="sticky-cart" style="display:none;" class="sticky-cart">
        <div class="container d-flex justify-content-between">
            <div>
                <strong id="cart-items"></strong>
                ₹<span id="cart-total"></span>
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-light btn-sm">View Cart</a>
        </div>
    </div>

    <!-- 🛒 DRAWER -->

    <div id="cart-drawer">
        <div class="p-3 border-bottom d-flex justify-content-between">
            <h5>Your Cart</h5>
            <button onclick="closeCart()" class="btn btn-sm btn-danger">✕</button>
        </div>

        <div id="drawer-items" style="flex:1; overflow:auto;"></div>

        <div class="p-3 border-top">
            <h5>Total: ₹<span id="drawer-total">0</span></h5>
        </div>

    </div>

    <!-- JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // CART UPDATE
        function updateStickyCart() {
            fetch('{{ url("/cart-data") }}')
                .then(res => res.json())
                .then(data => {
                    if (data.count > 0) {
                        document.getElementById('sticky-cart').style.display = 'block';
                        document.getElementById('cart-items').innerText = data.count + ' items';
                        document.getElementById('cart-total').innerText = data.total;
                        document.querySelectorAll('.cart-count').forEach(el => el.innerText = data.count);
                    }
                });
        }

        // DRAWER
        function openCart() {
            document.getElementById('cart-drawer').style.right = '0';
            loadDrawer();
        }
        function closeCart() {
            document.getElementById('cart-drawer').style.right = '-450px';
        }

        function loadDrawer() {
            let baseImagePath = "{{ asset('images/products') }}/";
            fetch('{{ url("/cart-items") }}')
                .then(res => res.json())
                .then(cart => {
                    let html = '', total = 0;

                    for (let id in cart) {
                        let i = cart[id];
                        total += i.price * i.quantity;

                        html += `
            <div class="p-2 border-bottom d-flex gap-2">
            <img src="${baseImagePath + i.image}" style="width:50px;height:50px;">
                <div>
                    <div>${i.name}</div>
                    <small>₹${i.price} x ${i.quantity}</small>
                </div>
            </div>`;
                    }

                    document.getElementById('drawer-items').innerHTML = html || "Cart empty";
                    document.getElementById('drawer-total').innerText = total;
                });
        }

        // SEARCH
        document.addEventListener("DOMContentLoaded", function () {
            updateStickyCart();

            let input = document.getElementById('search-input');
            let results = document.getElementById('search-results');

            function escapeHtml(value) {
                return value
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function escapeRegExp(value) {
                return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            function highlightMatch(value, query) {
                const escapedValue = escapeHtml(value);
                const pattern = new RegExp(`(${escapeRegExp(query)})`, 'gi');

                return escapedValue.replace(pattern, '<span class="highlight">$1</span>');
            }

            input.addEventListener('keyup', function () {
                let q = this.value;

                if (q.length < 2) { results.style.display = 'none'; return; }

                results.style.display = 'block';
                results.innerHTML = 'Searching...';

                fetch('{{ url("/search-food") }}?q=' + q)
                    .then(r => r.json())
                    .then(data => {
                        let html = '';

                        data.forEach(i => {
                            let name = highlightMatch(i.name, q);

                            html += `
                <div class="search-item" onclick="location='/food/${i.slug}'">
                    <img src="${i.image}" width="40" height="40" alt="${escapeHtml(i.name)}">
                    <div class="search-item-content">
                        <div class="search-item-name">${name}</div>
                        <div class="search-item-price">&#8377;${i.price}</div>
                    </div>
                </div>`;
                        });

                        results.innerHTML = html || "No result";
            });
        });
        });
    </script>

    @stack('scripts')

</body>

</html>

