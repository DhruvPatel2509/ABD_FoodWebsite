@extends('layouts.app')

@section('title', 'Live Order Tracking')

@section('content')

<style>
    .tracking-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        padding: 40px;
        max-width: 800px;
        margin: 50px auto;
        position: relative;
        overflow: hidden;
    }

    .playfair {
        font-family: 'Playfair Display', serif;
    }

    .status-text {
        color: #e23744;
        font-weight: 700;
        margin-top: 10px;
        font-size: 1.5rem;
    }

    /* Progress Bar Pipeline */
    .track-line {
        position: relative;
        height: 6px;
        background: #f1f1f1;
        border-radius: 10px;
        margin: 60px 0 40px 0;
        display: flex;
        justify-content: space-between;
    }

    .track-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: #fc8019;
        width: 0%; /* JS will animate this */
        border-radius: 10px;
        transition: width 1.5s ease-in-out;
    }

    .track-step {
        position: relative;
        top: -15px;
        width: 35px;
        height: 35px;
        background: #fff;
        border: 4px solid #f1f1f1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.5s ease 1s;
        z-index: 2;
    }

    .track-step i {
        font-size: 14px;
        color: #ddd;
        transition: color 0.5s ease 1s;
    }

    /* Active Step Styling */
    .track-step.active {
        border-color: #fc8019;
        background: #fc8019;
        box-shadow: 0 0 15px rgba(244, 162, 97, 0.4);
        transform: scale(1.2);
    }

    .track-step.active i {
        color: #fff;
    }

    .step-labels {
        display: flex;
        justify-content: space-between;
        margin-top: -20px;
        font-weight: 600;
        font-size: 0.85rem;
        color: #888;
    }
    
    .lbl {
        text-align: center;
        width: 80px;
        transition: color 0.5s ease 1s;
    }

    .lbl.active-lbl {
        color: #1a1a1a;
        font-weight: 700;
    }

    .map-simulation {
        height: 250px;
        background: #f9f9f9 url('https://images.unsplash.com/photo-1524661135-423995f22d0b?w=800') center/cover;
        border-radius: 16px;
        margin-top: 30px;
        position: relative;
    }

    .scooter {
        position: absolute;
        top: 40%;
        left: -10%;
        font-size: 40px;
        filter: drop-shadow(0 5px 5px rgba(0,0,0,0.3));
        transition: left 3s cubic-bezier(0.25, 1, 0.5, 1);
        display: none;
    }
</style>

<div class="tracking-container text-center">

    <h2 class="playfair mb-2">Order Tracking</h2>
    <p class="text-muted mb-2">Order ID: <strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
    
    @if($order->items->count() > 0)
    <div class="d-inline-block bg-light rounded-pill px-3 py-1 mb-2 border shadow-sm">
        <span class="small fw-bold text-secondary">Items:</span>
        <span class="small text-muted">
            {{ $order->items->pluck('food_name')->implode(', ') }}
        </span>
    </div>
    @else
    <div class="mb-2"></div>
    @endif

    <div class="mb-4">
        <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-sm border bg-white shadow-sm text-dark px-3 rounded-pill">
            <i class="fa fa-file-invoice text-primary me-1"></i> View Bill / Receipt
        </a>
    </div>

    <!-- Simulated Status -->
    <h3 class="status-text playfair" id="current-status-text">Order Confirmed</h3>
    <p class="text-muted small" id="sub-status-text">We've received your order and are sending it to the kitchen.</p>

    <!-- Track Line -->
    <div class="track-line">
        <div class="track-progress" id="progress-bar"></div>

        <!-- 1. Confirmed -->
        <div class="track-step active" id="step-1">
            <i class="fa fa-receipt"></i>
        </div>
        
        <!-- 2. Preparing -->
        <div class="track-step" id="step-2">
            <i class="fa fa-fire-burner"></i>
        </div>

        <!-- 3. Delivery -->
        <div class="track-step" id="step-3">
            <i class="fa fa-motorcycle"></i>
        </div>

        <!-- 4. Delivered -->
        <div class="track-step" id="step-4">
            <i class="fa fa-house-chimney"></i>
        </div>
    </div>

    <!-- Labels -->
    <div class="step-labels">
        <div class="lbl active-lbl" id="lbl-1">Confirmed</div>
        <div class="lbl" id="lbl-2">Preparing</div>
        <div class="lbl" id="lbl-3">On the Way</div>
        <div class="lbl" id="lbl-4">Delivered</div>
    </div>

    <!-- Map UI Visual -->
    <div class="map-simulation shadow-sm">
        <div class="scooter" id="delivery-scooter">🛵</div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // Simulate real-time progress for wow-factor
    const orderStatus = '{{ strtolower($order->status) }}';
    
    setTimeout(() => {
        // Assume all orders move to Preparing soon after viewing
        document.getElementById('progress-bar').style.width = '33%';
        
        document.getElementById('step-2').classList.add('active');
        document.getElementById('lbl-2').classList.add('active-lbl');

        document.getElementById('current-status-text').innerText = 'Preparing your food 🧑‍🍳';
        document.getElementById('sub-status-text').innerText = 'The chef is tossing the ingredients right now!';
        
    }, 3000);

    setTimeout(() => {
        // Move to Out for Delivery
        document.getElementById('progress-bar').style.width = '66%';
        
        document.getElementById('step-3').classList.add('active');
        document.getElementById('lbl-3').classList.add('active-lbl');

        document.getElementById('current-status-text').innerText = 'Out for Delivery 🛵';
        document.getElementById('sub-status-text').innerText = 'Your rider is navigating the traffic!';

        // Animate scooter across the map
        const scooter = document.getElementById('delivery-scooter');
        scooter.style.display = 'block';
        setTimeout(() => {
            scooter.style.left = '70%'; // Drives across map
        }, 100);

    }, 8000);

});
</script>
@endpush

@endsection
