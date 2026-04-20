@extends('layouts.app')

@section('content')
    @php
        $mainImage = optional($product->images->first())->image_url ?? $product->image_url;
    @endphp

    <style>
        .product-container {
            padding: 100px 0;
            background: #fafafa;
        }

        .main-img-holder {
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .main-img-holder img {
            width: 100%;
            transition: 0.5s;
        }

        .main-img-holder:hover img {
            transform: scale(1.05);
        }

        .angle-thumb {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: 0.3s;
            border-radius: 10px;
        }

        .angle-thumb:hover,
        .angle-thumb.active {
            border-color: #C49A6C;
            transform: translateY(-5px);
        }

        .food-info-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .badge-premium {
            background: #C49A6C;
            color: #fff;
            padding: 5px 15px;
            font-size: 12px;
            letter-spacing: 2px;
        }
    </style>

    <div class="product-container">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="main-img-holder mb-4">
                        <img src="{{ $mainImage ?? 'https://via.placeholder.com/500' }}" id="mainView" alt="{{ $product->name }}">
                    </div>

                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @foreach($product->images as $index => $img)
                            <img src="{{ $img->image_url }}"
                                class="angle-thumb {{ $index == 0 ? 'active' : '' }}" onclick="
                                    document.getElementById('mainView').src=this.src;
                                    document.querySelectorAll('.angle-thumb').forEach(el=>el.classList.remove('active'));
                                    this.classList.add('active');
                                ">
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="food-info-card">
                        <span class="badge badge-premium mb-3">EXECUTIVE SELECTION</span>

                        <h1 class="kudil-font display-4 fw-bold">{{ $product->name }}</h1>

                        <p class="my-4 fs-5 text-muted">{{ $product->description }}</p>

                        <div class="mb-5 d-flex align-items-center">
                            <span class="me-3 fs-1 fw-bold text-success">
                                Rs {{ number_format($product->price, 2) }}
                            </span>
                            @if($product->original_price)
                                <span class="text-decoration-line-through text-muted">
                                    Rs {{ number_format($product->original_price, 2) }}
                                </span>
                            @endif
                        </div>

                        <div class="d-grid gap-3">
                            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-kudil btn-lg w-100 py-3 fs-5">
                                    <i class="fa fa-shopping-bag me-2"></i> ADD TO PREMIUM CART
                                </button>
                            </form>

                            <button class="btn btn-outline-dark btn-lg py-3">
                                <i class="fa fa-heart me-2"></i> SAVE FOR LATER
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
