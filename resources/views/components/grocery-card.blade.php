@props(['item'])

@php
    $mainImage = optional($item->images->first())->image_url ?? $item->image_url;
@endphp

<div class="grocery-card h-100">
    <button onclick="addToCart({{ $item->id }}, this)" class="grocery-add-btn" aria-label="Add to cart">
        <i class="fa-solid fa-plus"></i>
    </button>

    <div class="grocery-img-container">
        @if($item->original_price && $item->original_price > $item->price)
            @php
                $discount = round((($item->original_price - $item->price) / $item->original_price) * 100);
            @endphp
            <div class="grocery-badge">
                {{ $discount }}%<br>OFF
            </div>
        @endif

        <a href="{{ route('food.show', $item->slug) }}" class="d-block h-100 w-100 text-center">
            <img src="{{ $mainImage ?? 'https://via.placeholder.com/300x200?text=No+Image' }}"
                onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'" alt="{{ $item->name }}">
        </a>

        <div class="veg-indicator"></div>
    </div>

    <div class="grocery-details">
        <div class="grocery-title">{{ $item->name }}</div>

        <div class="grocery-subtitle">
            {{ $item->description ? \Illuminate\Support\Str::limit($item->description, 20) : '1 Portion' }}
        </div>

        <div class="grocery-price-row mt-1">
            <span class="grocery-price">Rs {{ $item->price }}</span>

            @if($item->original_price && $item->original_price > $item->price)
                <span class="grocery-original-price">Rs {{ $item->original_price }}</span>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <style>
        .grocery-card {
            background: #fff;
            border-radius: 16px;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .grocery-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .grocery-add-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            border: none;
            color: #333;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .grocery-add-btn:hover {
            background: #fc8019;
            color: white;
        }

        .grocery-img-container {
            position: relative;
            width: 100%;
            height: 140px;
            background: #fff;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            overflow: hidden;
        }

        .grocery-img-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
            transition: transform 0.3s ease;
        }

        .grocery-card:hover .grocery-img-container img {
            transform: scale(1.05);
        }

        .grocery-badge {
            position: absolute;
            top: 0;
            left: 0;
            background: #e23744;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 6px 10px;
            border-bottom-right-radius: 12px;
        }

        .veg-indicator {
            position: absolute;
            bottom: 8px;
            left: 8px;
            width: 16px;
            height: 16px;
            border: 1px solid #28a745;
            background: white;
            border-radius: 3px;
        }

        .veg-indicator::after {
            content: '';
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            display: block;
            margin: 3px auto;
        }

        .grocery-details {
            padding: 12px 14px;
        }

        .grocery-title {
            font-size: 1rem;
            font-weight: 700;
        }

        .grocery-subtitle {
            font-size: 0.8rem;
            color: #888;
        }

        .grocery-price {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .grocery-original-price {
            font-size: 0.85rem;
            color: #999;
            text-decoration: line-through;
            margin-left: 6px;
        }
    </style>
@endpush
