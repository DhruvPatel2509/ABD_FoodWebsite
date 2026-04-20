@extends('layouts.app')

@section('content')
<style>
    .category-header { background: #1a1a1a; color: white; padding: 80px 0; }
    .food-item-card { border: none; border-radius: 0; transition: 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .food-item-card:hover { transform: scale(1.02); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .btn-buy { background: #C49A6C; color: white; border-radius: 0; width: 100%; transition: 0.3s; }
    .btn-buy:hover { background: #000; color: #fff; }
</style>

<div class="category-header text-center">
    <div class="container">
        <h1 class="kudil-font display-4">{{ $category->name }}</h1>
        <p class="text-gold" style="color: #C49A6C;">Discover our finest selection of {{ strtolower($category->name) }} items</p>
    </div>
</div>

<div class="container my-5 py-5">
    <div class="row g-4">
        @forelse($foodItems as $item)
        <div class="col-md-4">
            <x-grocery-card :item="$item" />
        </div>
        @empty
        <div class="col-12 text-center">
            <h3>Coming Soon!</h3>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
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
        if (typeof updateStickyCart === "function") updateStickyCart();
        showToast("Added to cart ✅");
        
        btnElement.innerHTML = originalHtml;
        btnElement.disabled = false;
    })
    .catch(err => {
        console.error(err);
        btnElement.innerHTML = originalHtml;
        btnElement.disabled = false;
    });
}

function showToast(message) {
    let toast = document.createElement("div");
    toast.innerText = message;
    toast.style.position = "fixed";
    toast.style.bottom = "20px";
    toast.style.right = "20px";
    toast.style.background = "#fc8019";
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
