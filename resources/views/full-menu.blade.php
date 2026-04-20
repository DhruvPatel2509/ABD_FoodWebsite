@extends('layouts.app')

@section('content')

<!-- Header banner -->
<div class="bg-dark text-white text-center py-5 mb-5 shadow-sm" style="background-color: #1a1a1a !important; border-bottom: 5px solid #fc8019;">
    @php
        $menuTitle = 'OUR FULL MENU';
        $menuSubtitle = 'Explore the complete range of traditional flavors';
        
        if(request('offer') == 'discount') {
            $menuTitle = '50% OFF ZONE';
            $menuSubtitle = 'Special discounts on your favorite items';
        } elseif(request('offer') == 'freedelivery') {
            $menuTitle = 'FREE DELIVERY MENU';
            $menuSubtitle = 'Premium items above ₹499 with zero delivery fee';
        } elseif(request('offer') == 'premium') {
            $menuTitle = 'ABD PREMIUM';
            $menuSubtitle = 'Exclusive exotic dishes for our premium members';
        } elseif(request('offer') == 'express') {
            $menuTitle = 'EXPRESS 20 MINS';
            $menuSubtitle = 'Superfast delivery dishes directly from the chef';
        }
    @endphp
    <h1 class="display-4 fw-bold poppins" style="letter-spacing: 1px;">{{ $menuTitle }}</h1>
    <p class="text-light mb-0" style="opacity: 0.8;">{{ $menuSubtitle }}</p>
</div>

<div class="container my-4">
    <div class="row">
        
        <!-- SIDEBAR (Col 3) -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="background-color: #faf9f6; top: 20px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 text-dark" style="letter-spacing: 1px;">REFINE MENU</h6>
                    
                    <form action="{{ route('full.menu') }}" method="GET">
                        <!-- Search Box -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">SEARCH DISH</label>
                            <input type="text" name="q" class="form-control form-control-sm" placeholder="e.g. Chicken Biryani, Pizza..." value="{{ request('q') }}">
                        </div>

                        <!-- Price Range Filter (Amazon Style) -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted mb-2">PRICE</label>
                            
                            <ul class="list-unstyled mb-3 small" style="line-height: 1.8;">
                                <li class="mb-1">
                                    <a href="javascript:void(0)" onclick="setPriceFilter('', '100')" 
                                       class="text-decoration-none d-flex align-items-center {{ (request('min_price') == '' && request('max_price') == '100') ? 'fw-bold text-dark' : 'text-secondary' }}">
                                       <i class="{{ (request('min_price') == '' && request('max_price') == '100') ? 'fa-solid fa-square-check text-dark' : 'fa-regular fa-square text-muted' }} me-2" style="font-size: 1.1em;"></i>
                                       Under ₹100
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="javascript:void(0)" onclick="setPriceFilter('100', '200')" 
                                       class="text-decoration-none d-flex align-items-center {{ (request('min_price') == '100' && request('max_price') == '200') ? 'fw-bold text-dark' : 'text-secondary' }}">
                                       <i class="{{ (request('min_price') == '100' && request('max_price') == '200') ? 'fa-solid fa-square-check text-dark' : 'fa-regular fa-square text-muted' }} me-2" style="font-size: 1.1em;"></i>
                                       ₹100 - ₹200
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="javascript:void(0)" onclick="setPriceFilter('200', '400')" 
                                       class="text-decoration-none d-flex align-items-center {{ (request('min_price') == '200' && request('max_price') == '400') ? 'fw-bold text-dark' : 'text-secondary' }}">
                                       <i class="{{ (request('min_price') == '200' && request('max_price') == '400') ? 'fa-solid fa-square-check text-dark' : 'fa-regular fa-square text-muted' }} me-2" style="font-size: 1.1em;"></i>
                                       ₹200 - ₹400
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="javascript:void(0)" onclick="setPriceFilter('400', '500')" 
                                       class="text-decoration-none d-flex align-items-center {{ (request('min_price') == '400' && request('max_price') == '500') ? 'fw-bold text-dark' : 'text-secondary' }}">
                                       <i class="{{ (request('min_price') == '400' && request('max_price') == '500') ? 'fa-solid fa-square-check text-dark' : 'fa-regular fa-square text-muted' }} me-2" style="font-size: 1.1em;"></i>
                                       ₹400 - ₹500
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="javascript:void(0)" onclick="setPriceFilter('500', '1000')" 
                                       class="text-decoration-none d-flex align-items-center {{ (request('min_price') == '500' && request('max_price') == '1000') ? 'fw-bold text-dark' : 'text-secondary' }}">
                                       <i class="{{ (request('min_price') == '500' && request('max_price') == '1000') ? 'fa-solid fa-square-check text-dark' : 'fa-regular fa-square text-muted' }} me-2" style="font-size: 1.1em;"></i>
                                       ₹500 - ₹1,000
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="javascript:void(0)" onclick="setPriceFilter('1000', '')" 
                                       class="text-decoration-none d-flex align-items-center {{ (request('min_price') == '1000' && request('max_price') == '') ? 'fw-bold text-dark' : 'text-secondary' }}">
                                       <i class="{{ (request('min_price') == '1000' && request('max_price') == '') ? 'fa-solid fa-square-check text-dark' : 'fa-regular fa-square text-muted' }} me-2" style="font-size: 1.1em;"></i>
                                       Over ₹1,000
                                    </a>
                                </li>
                            </ul>

                            <div class="d-flex align-items-center gap-2">
                                <input type="number" id="min_price_input" name="min_price" class="form-control form-control-sm px-2 shadow-none border" placeholder="₹ Min" value="{{ request('min_price') }}" style="max-width: 75px;">
                                <span class="text-muted small">-</span>
                                <input type="number" id="max_price_input" name="max_price" class="form-control form-control-sm px-2 shadow-none border" placeholder="₹ Max" value="{{ request('max_price') }}" style="max-width: 75px;">
                                <button type="submit" class="btn btn-sm border bg-white shadow-sm text-dark px-3 rounded" style="font-size:0.8rem;">Go</button>
                            </div>
                        </div>

                        <!-- Sort By Price -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">SORT BY PRICE</label>
                            <select name="sort" class="form-select form-select-sm">
                                <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Default</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Low to High</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>High to Low</option>
                            </select>
                        </div>

                        <!-- Quick Categories -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted mb-3">QUICK CATEGORIES</label>
                            @foreach($allCategories as $cat)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category" id="cat_{{ $cat->id }}" value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary small" style="cursor:pointer;" for="cat_{{ $cat->id }}">
                                    {{ $cat->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn text-white fw-bold shadow-sm" style="background-color: #c4996c; border-radius: 4px;">Apply Filters</button>
                            <a href="{{ route('full.menu') }}" class="btn btn-sm text-muted mt-1 text-decoration-none">Clear All</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MAIN MENU GRID (Col 9) -->
        <div class="col-lg-9 col-md-8">
            @forelse($categories as $category)
                @if($category->foodItems->count() > 0)
                
                <div class="mb-5">
                    <!-- CATEGORY TITLE WITH GOLD LINE -->
                    <div class="d-flex align-items-center mb-4">
                        <div style="width: 4px; height: 28px; background-color: #c4996c; margin-right: 12px; border-radius: 2px;"></div>
                        <h4 class="mb-0 fw-bold playfair" style="color: #c4996c; letter-spacing: 1px;">{{ strtoupper($category->name) }}</h4>
                    </div>

                    <div class="row g-4">
                        @foreach($category->foodItems as $food)
                        <div class="col-md-6 col-lg-4">
                            <x-grocery-card :item="$food" />
                        </div>
                        @endforeach
                    </div>
                </div>
                
                @endif
            @empty
            <div class="text-center py-5">
                <i class="fa fa-magnifying-glass fa-3x text-muted mb-3"></i>
                <h3 class="text-muted fw-bold">No dishes found.</h3>
                <p>Try refining your search or selecting a different category from the sidebar.</p>
                <a href="{{ route('full.menu') }}" class="btn mt-3 rounded-1 shadow-sm fw-bold" style="background-color: #c4996c; color: white;">Reset Filters</a>
            </div>
            @endforelse
        </div>
        
    </div>
</div>

@endsection

@push('styles')
<style>
.food-card {
    transition: all 0.3s ease;
}
.food-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}
.playfair { font-family: 'Playfair Display', serif; }
</style>
@endpush

@push('scripts')
<script>
function setPriceFilter(minVal, maxVal) {
    document.getElementById('min_price_input').value = minVal;
    document.getElementById('max_price_input').value = maxVal;
    document.getElementById('min_price_input').closest('form').submit();
}

function addToCart(id, btnElement) {
    let originalHtml = btnElement.innerHTML;
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
        document.querySelectorAll('.cart-count').forEach(el => el.innerText = data.count);
        showToast("Added to cart ✅", "#c4996c");
        
        btnElement.innerHTML = originalHtml;
        btnElement.disabled = false;
    })
    .catch(err => {
        console.error(err);
        btnElement.innerHTML = originalHtml;
        btnElement.disabled = false;
    });
}

function showToast(message, bgColor = "#000") {
    let toast = document.createElement("div");
    toast.innerText = message;
    toast.style.position = "fixed";
    toast.style.bottom = "30px";
    toast.style.right = "30px";
    toast.style.background = bgColor;
    toast.style.color = "#fff";
    toast.style.padding = "12px 24px";
    toast.style.borderRadius = "4px";
    toast.style.fontWeight = "bold";
    toast.style.boxShadow = "0 10px 30px rgba(0,0,0,0.2)";
    toast.style.zIndex = "9999";
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
}
</script>
@endpush
