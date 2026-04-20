@extends('layouts.app')

@section('content')

    <style>
        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1200');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 55vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;

            /* Make it a perfect floating card */
            border-radius: 30px;
            margin-top: 20px;
            margin-bottom: 50px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .cat-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .cat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .cat-card:hover img {
            transform: scale(1.05);
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            position: relative;
            padding-bottom: 15px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: #fc8019;
            /* Swiggy orange accent */
            border-radius: 2px;
        }

        .food-card {
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            background: #fff;
        }

        .food-card img {
            transition: transform 0.5s ease;
        }

        .food-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08) !important;
        }

        .food-card:hover img {
            transform: scale(1.05);
        }

        .poppins {
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary-custom {
            background: #fc8019;
            /* Swiggy vibrant orange */
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 6px 16px;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background: #e06c12;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(252, 128, 25, 0.3);
        }
    </style>

    <!-- HERO -->

    <section class="hero-banner text-center">
        <div class="container">
            <h1 class="display-3 fw-bolder poppins mb-3 text-white"
                style="text-shadow: 2px 2px 10px rgba(0,0,0,0.5); letter-spacing: -1px;">ABD Fine Dining</h1>
            <p class="lead text-light poppins"
                style="font-size: 1.3rem; text-shadow: 1px 1px 5px rgba(0,0,0,0.5); font-weight: 500;">Select a category to
                explore our extreme menu</p>
        </div>
    </section>

    <!-- CATEGORIES -->

    <section class="container my-5 py-5">
        <h2 class="text-center section-title mb-5">Our Categories</h2>
        <div class="row g-4 justify-content-center">
            @foreach($categories as $cat)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('category.show', $cat->slug) }}" class="text-decoration-none p-0">
                        <div class="card cat-card border-0 shadow-sm h-100 rounded-4 overflow-hidden position-relative">
                            @if($cat->image)
                                <img src="{{ asset('images/categories/' . $cat->image) }}" class="card-img-top w-100"
                                    style="height: 180px; object-fit: cover; transition: 0.3s;" alt="{{ $cat->name }}">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fa fa-utensils fa-3x text-white opacity-50"></i>
                                </div>
                            @endif

                            <!-- Gradient Overlay -->
                            <div class="position-absolute bottom-0 w-100 d-flex flex-column justify-content-end p-3"
                                style="height: 100px; background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                <h5 class="poppins fw-bolder mb-0 text-white" style="letter-spacing: 0px;">
                                    {{ strtoupper($cat->name) }}</h5>
                                <small class="text-light" style="opacity: 0.9;">Explore <i class="fa fa-arrow-right ms-1"
                                        style="font-size: 10px;"></i></small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- FEATURED -->

    <section class="container mb-5">
        <h2 class="text-center section-title mb-5">Chef's Recommendations</h2>

        <div class="row">
            @foreach($featured as $item)
                <div class="col-md-3 mb-4">
                    <x-grocery-card :item="$item" />
                </div>
            @endforeach
        </div>

    </section>

@endsection

@push('scripts')

    <script>
        function addToCart(id, btnElement) {
            let originalText = btnElement.innerHTML;
            btnElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btnElement.disabled = true;

            fetch(`{{ url('/add-to-cart') }}/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
                .then(res => res.json())
                .then(data => {
                    // ✅ Update navbar cart count
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.innerText = data.count;
                    });

                    // ✅ UPDATE STICKY CART (VERY IMPORTANT 🔥)
                    if (typeof updateStickyCart === "function") {
                        updateStickyCart();
                    }

                    showToast("Added to cart 🛒");

                    btnElement.innerHTML = originalText;
                    btnElement.disabled = false;
                })
                .catch(err => {
                    console.error(err);
                    btnElement.innerHTML = originalText;
                    btnElement.disabled = false;
                });
        }


        // 🔔 Toast Notification
        function showToast(message) {
            let toast = document.createElement("div");
            toast.innerText = message;

            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.right = "20px";
            toast.style.background = "#000";
            toast.style.color = "#fff";
            toast.style.padding = "10px 15px";
            toast.style.borderRadius = "5px";
            toast.style.zIndex = "9999";
            toast.style.opacity = "0";
            toast.style.transition = "0.3s";

            document.body.appendChild(toast);

            setTimeout(() => toast.style.opacity = "1", 100);

            setTimeout(() => {
                toast.style.opacity = "0";
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }
    </script>

@endpush