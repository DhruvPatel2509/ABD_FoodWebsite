@extends('layouts.app')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <h1 class="kudil-font display-4">Secure Checkout</h1>
        <p class="text-muted">Finalize your order and enjoy the ABD experience.</p>
    </div>
</div>

<div class="container my-5">
    @php
        $totalAmt = 0;
        if(session('cart')){
            foreach(session('cart') as $details){
                $totalAmt += $details['price'] * $details['quantity'];
            }
        }
    @endphp
    <div class="row g-5">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4 rounded-0">
                <h3 class="kudil-font mb-4 border-bottom pb-2">Delivery Details</h3>
                <form action="{{ route('order.place') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control rounded-0" placeholder="e.g. +91 9876543210" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Full Delivery Address</label>
                        <textarea name="address" class="form-control rounded-0" rows="4" placeholder="House No, Street, Landmark, City" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Payment Method</label>
                        <div class="d-flex flex-column gap-2">
                            <label class="form-check border p-3 rounded cursor-pointer" id="cod_label">
                                <input class="form-check-input me-2" type="radio" name="payment_method" value="cod" id="payment_cod" checked onchange="togglePayment()">
                                <span class="fw-bold"><i class="fas fa-money-bill-wave mx-2 text-success"></i> Cash on Delivery (COD)</span>
                            </label>
                            
                            <label class="form-check border p-3 rounded cursor-pointer" id="upi_label">
                                <input class="form-check-input me-2" type="radio" name="payment_method" value="upi" id="payment_upi" onchange="togglePayment()">
                                <span class="fw-bold"><i class="fas fa-qrcode mx-2 text-primary"></i> QR / UPI Payment</span>
                            </label>
                        </div>
                    </div>

                    <!-- UPI QR Section -->
                    <div id="upi_section" class="text-center p-4 border rounded mb-4" style="display: none; background: #f8f9fa;">
                        <h5 class="fw-bold mb-1">Scan to pay with any UPI App</h5>
                        <p class="text-muted small mb-3">GPay, PhonePe, Paytm, WhatsApp, etc.</p>
                        
                        <img src="https://quickchart.io/qr?text=upi%3A%2F%2Fpay%3Fpa%3Dayushgajjar712-1%40oksbi%26pn%3DAyush%26am%3D{{ $totalAmt ?? 0 }}&size=200&margin=1" alt="UPI QR Code" class="img-fluid rounded shadow-sm mb-3 border bg-white p-2" style="width: 180px; height: 180px;">
                        
                        <p class="mb-3 fw-bold text-dark">UPI ID: ayushgajjar712-1@oksbi</p>

                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-receipt text-muted"></i></span>
                            <input type="text" name="upi_transaction_id" class="form-control" placeholder="Enter 12-digit UPI Reference No. (Optional)">
                        </div>
                    </div>

                    <!-- Removed hardcoded COD info -->

                    <button type="submit" class="btn btn-kudil w-100 py-3 fw-bold fs-5" id="place-order-btn">
                        CONFIRM & PLACE ORDER
                    </button>
                </form>
            </div>
        </div>
        
        <div class="col-md-5">
            <!-- Alert Messages for Coupon -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm p-4 bg-white rounded-0">
                <h4 class="kudil-font mb-4 border-bottom pb-2">Order Summary</h4>
                
                @if(session('cart'))
                    @php 
                        $total = 0; 
                        $discount = 0;
                    @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                <small class="text-muted">Quantity: {{ $details['quantity'] }}</small>
                            </div>
                            <span class="fw-bold">₹{{ $details['price'] * $details['quantity'] }}</span>
                        </div>
                    @endforeach
                    
                    <hr class="my-4">
                    
                    <!-- Coupon Form -->
                    @if(!session('coupon'))
                        <form action="{{ route('coupon.apply') }}" method="POST" class="mb-4">
                            @csrf
                            <label class="form-label fw-bold">Have a promo code?</label>
                            <div class="input-group">
                                <input type="text" name="coupon_code" class="form-control rounded-0" placeholder="Enter code here" required>
                                <button class="btn btn-outline-dark rounded-0" type="submit">Apply</button>
                            </div>
                        </form>
                    @else
                        @php
                            if (session('coupon.type') === 'percent') {
                                $discount = ($total * session('coupon.value')) / 100;
                            } else {
                                $discount = session('coupon.value');
                            }
                        @endphp
                        <div class="mb-4 p-3 bg-light border border-success rounded d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success text-white mb-1"><i class="fas fa-tag"></i> {{ session('coupon.code') }} Applied</span>
                                <div class="text-success small fw-bold">You saved ₹{{ $discount }}!</div>
                            </div>
                            <form action="{{ route('coupon.remove') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i> Remove</button>
                            </form>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>₹{{ $total }}</span>
                    </div>
                    
                    @if($discount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount (Promo)</span>
                        <span>-₹{{ max(0, $discount) }}</span>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Delivery Fee</span>
                        <span>FREE</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4 border-top pt-3">
                        <h4 class="kudil-font fw-bold">Total Amount</h4>
                        <h4 class="kudil-font fw-bold text-success">₹{{ max(0, $total - $discount) }}</h4>
                    </div>
                @else
                    <p class="text-center text-muted">No items found in cart.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function togglePayment() {
    const isUpi = document.getElementById('payment_upi').checked;
    document.getElementById('upi_section').style.display = isUpi ? 'block' : 'none';
    
    // UI Styling improvements
    const codLabel = document.getElementById('cod_label');
    const upiLabel = document.getElementById('upi_label');
    
    if (isUpi) {
        upiLabel.classList.add('border-warning', 'bg-light');
        codLabel.classList.remove('border-warning', 'bg-light');
    } else {
        codLabel.classList.add('border-warning', 'bg-light');
        upiLabel.classList.remove('border-warning', 'bg-light');
    }
}
// Init State
document.addEventListener('DOMContentLoaded', function() {
    togglePayment();

    const checkoutForm = document.getElementById('checkout-form');
    if(checkoutForm) {
        checkoutForm.addEventListener('submit', function() {
            const btn = document.getElementById('place-order-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> PROCESSING...';
            btn.disabled = true;
        });
    }
});
</script>
@endsection