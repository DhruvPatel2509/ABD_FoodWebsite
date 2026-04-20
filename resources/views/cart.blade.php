@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <h2 class="kudil-font mb-4">Your Shopping Cart</h2>

    <table class="table align-middle">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @php $total = 0 @endphp

            @if(session('cart'))
                @foreach(session('cart') as $id => $details)

                            @php $subtotal = $details['price'] * $details['quantity'];
                    $total += $subtotal; @endphp

                            <tr id="row-{{ $id }}">

                                <!-- PRODUCT -->
                                <td>
                                    {{-- Use this cleaner version --}}
                                    <img src="{{ $details['image'] ?? 'https://via.placeholder.com/50x50?text=No+Image' }}" width="50" height="50"
                                        class="rounded me-2" style="object-cover">
                                </td>

                                <!-- PRICE -->
                                <td>
                                    ₹<span id="price-{{ $id }}">{{ $details['price'] }}</span>
                                </td>

                                <!-- QUANTITY -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">

                                        <button class="btn btn-sm btn-outline-secondary"
                                                onclick="updateCart('{{ $id }}', -1, this)">−</button>

                                        <span id="qty-{{ $id }}">{{ $details['quantity'] }}</span>

                                        <button class="btn btn-sm btn-outline-secondary"
                                                onclick="updateCart('{{ $id }}', 1, this)">+</button>

                                    </div>
                                </td>

                                <!-- SUBTOTAL -->
                                <td>
                                    ₹<span id="subtotal-{{ $id }}">{{ $subtotal }}</span>
                                </td>

                                <!-- REMOVE -->
                                <td>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>

                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">Your cart is empty</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="text-end mt-4">
        <h3>Total: ₹<span id="cart-total">{{ $total }}</span></h3>

        <a href="{{ url('/') }}" class="btn btn-outline-dark">Continue Shopping</a>

        @if(session('cart'))
            <a href="{{ route('checkout') }}" class="btn btn-kudil">Proceed to Checkout</a>
        @endif
    </div>

    </div>
@endsection

@push('scripts')

<script>
function updateCart(id, delta, btnElement) {
    let originalHtml = btnElement.innerHTML;
    btnElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btnElement.disabled = true;

    fetch(`{{ url('/cart/update') }}/${id}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ delta: delta })
    })
    .then(res => res.json())
    .then(data => {

        let qtyEl = document.getElementById('qty-' + id);
        let priceEl = document.getElementById('price-' + id);
        let subtotalEl = document.getElementById('subtotal-' + id);

        let qty = parseInt(qtyEl.innerText) + delta;

        // Remove row if quantity 0
        if (qty <= 0) {
            document.getElementById('row-' + id).remove();
            updateCartTotal();
            return;
        }

        qtyEl.innerText = qty;

        let price = parseInt(priceEl.innerText);
        subtotalEl.innerText = price * qty;

        updateCartTotal();

        btnElement.innerHTML = originalHtml;
        btnElement.disabled = false;
    })
    .catch(err => {
        console.error(err);
        btnElement.innerHTML = originalHtml;
        btnElement.disabled = false;
    });
}

function updateCartTotal() {
    let total = 0;

    document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
        total += parseInt(el.innerText);
    });

    document.getElementById('cart-total').innerText = total;

    // Update navbar cart count
    let count = document.querySelectorAll('[id^="qty-"]').length;

    document.querySelectorAll('.cart-count').forEach(el => {
        el.innerText = count;
    });
}
</script>

@endpush
