@extends('layouts.app')

@section('title', 'Order Receipt - #' . $order->id)

@section('content')
<style>
    body {
        background: #f4f7f6;
    }
    .receipt-container {
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        padding: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-top: 5px solid #fc8019;
    }
    .receipt-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #f1f1f1;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .receipt-logo h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        color: #e23744;
        margin: 0;
    }
    .receipt-meta {
        text-align: right;
    }
    .receipt-meta h3 {
        margin: 0;
        font-weight: 700;
        color: #333;
    }
    .receipt-meta p {
        margin: 0;
        color: #777;
    }
    .billing-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
    }
    .billing-box h5 {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }
    .table th {
        background: #fdfdfd;
        color: #555;
        font-weight: 600;
        border-bottom: 2px solid #ddd;
    }
    .table td {
        vertical-align: middle;
    }
    .total-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 1.1rem;
        margin-bottom: 10px;
    }
    .total-row.grand-total {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        border-top: 2px solid #eee;
        padding-top: 15px;
    }
    .action-buttons {
        margin-top: 40px;
        text-align: center;
    }
    
    @media print {
        body { background: #fff; }
        .receipt-container { box-shadow: none; margin: 0; padding: 0; max-width: 100%; border: none; }
        .action-buttons, nav, footer, .navbar, .sticky-cart { display: none !important; }
        .total-section { break-inside: avoid; }
    }
</style>

<div class="container">
    <div class="receipt-container" id="receipt">
        
        <!-- Header -->
        <div class="receipt-header">
            <div class="receipt-logo">
                <h1>ABD.</h1>
                <p class="text-muted small">Premium Food Delivery</p>
            </div>
            <div class="receipt-meta">
                <h3>RECEIPT / INVOICE</h3>
                <p>Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p>Date: {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <!-- Billing Info -->
        <div class="billing-details">
            <div class="billing-box w-50 pe-4">
                <h5>Billed To:</h5>
                <p class="mb-1"><strong>{{ auth()->user()->name }}</strong></p>
                <p class="mb-1"><i class="fa fa-phone small text-muted"></i> {{ $order->phone }}</p>
                <p class="mb-0 text-muted small"><i class="fa text-muted fa-map-marker-alt"></i> {!! nl2br(e($order->address)) !!}</p>
            </div>
            <div class="billing-box text-end w-50">
                <h5>Payment Details:</h5>
                <p class="mb-1">Method: <strong>{{ strtoupper($order->payment_method) }}</strong>
                    @if($order->payment_method == 'cod')
                        (Cash on Delivery)
                    @endif
                </p>
                @if($order->payment_transaction_id)
                <p class="mb-1">Txn ID: <strong>{{ $order->payment_transaction_id }}</strong></p>
                @endif
                <span class="badge {{ $order->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                    Status: {{ strtoupper($order->status) }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th width="50%">Item</th>
                        <th class="text-center" width="15%">Qty</th>
                        <th class="text-end" width="15%">Price</th>
                        <th class="text-end" width="20%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->food_name }}</strong>
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-end fw-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="row w-100 mx-0">
                <div class="col-md-6 offset-md-6 px-0 px-md-3">
                    @php
                        $subtotal = 0;
                        foreach($order->items as $item) {
                            $subtotal += ($item->price * $item->quantity);
                        }
                    @endphp

                    <div class="total-row text-muted">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if($order->discount_amount > 0)
                    <div class="total-row text-success">
                        <span>Discount @if($order->coupon_code) ({{ $order->coupon_code }}) @endif</span>
                        <span>- ₹{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif

                    <div class="total-row grand-total">
                        <span>Grand Total</span>
                        <span>₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-5 text-center text-muted small">
                <p>Thank you for ordering with ABD. We hope you enjoy your meal!</p>
                <p>For any queries, please contact support@abd.com</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="action-buttons mb-5">
        <button onclick="window.print()" class="btn btn-primary-custom px-4 py-2 me-3 shadow-sm">
            <i class="fa fa-print me-2"></i> Print / Download PDF
        </button>
        <a href="{{ route('order.track', $order->id) }}" class="btn border px-4 py-2 bg-white text-dark shadow-sm">
            Back to Tracking
        </a>
    </div>

</div>
@endsection
