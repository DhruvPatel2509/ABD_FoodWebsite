@extends('layouts.app')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <h1 class="playfair display-4 fw-bold text-dark">Order History</h1>
        <p class="text-muted">Review your past premium meals from ABD.</p>
    </div>
</div>

<div class="container my-5">
    @forelse($orders as $order)
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <div>
                    <span class="fw-bold">Order #{{ $order->id }}</span>
                    <span class="text-muted ms-3">{{ $order->created_at->format('d M, Y') }}</span>
                </div>
                <span class="badge rounded-pill {{ $order->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                    {{ strtoupper($order->status) }}
                </span>
            </div>
            <div class="card-body">
                @if($order->items->count() > 0)
                <div class="mb-3">
                    <h6 class="fw-bold mb-2 border-bottom pb-1 text-secondary">Order Items:</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach($order->items as $item)
                        <li class="mb-1"><i class="fa-solid fa-check text-success me-2" style="font-size:12px;"></i> {{ $item->quantity }}x <strong>{{ $item->food_name }}</strong> <span class="text-muted small ms-1">(₹{{ $item->price }})</span></li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row bg-light p-3 rounded mx-0">
                    <div class="col-md-7">
                        <p class="mb-1 small"><strong>Delivery Details:</strong><br>{!! nl2br(e($order->address)) !!}</p>
                        <p class="mb-0 small"><strong>Contact:</strong> {{ $order->phone }}</p>
                    </div>
                    <div class="col-md-5 text-md-end border-start">
                        <p class="mb-1 small">
                            <strong>Payment:</strong> 
                            <span class="badge bg-secondary">{{ strtoupper($order->payment_method) }}</span>
                        </p>
                        @if($order->payment_method === 'upi' && $order->payment_transaction_id)
                        <p class="mb-1 small text-muted"><strong>Txn ID:</strong> {{ $order->payment_transaction_id }}</p>
                        @endif
                        <h4 class="playfair text-success fw-bold mt-2">Total: ₹{{ $order->total_amount }}</h4>
                        <div class="mt-2 d-flex justify-content-md-end gap-2">
                            <a href="{{ route('order.track', $order->id) }}" class="btn btn-sm btn-primary-custom shadow-sm flex-grow-1 flex-md-grow-0 text-center">
                                <i class="fa fa-location-arrow me-1"></i> Track Live
                            </a>
                            <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-sm border bg-white text-dark shadow-sm flex-grow-1 flex-md-grow-0 text-center" title="View Bill/Receipt">
                                <i class="fa fa-file-invoice me-1"></i> Bill
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fa fa-shopping-basket fa-3x text-muted mb-3"></i>
            <h3>No orders found.</h3>
            <p>You haven't placed any orders with ABD yet.</p>
            <a href="{{ url('/') }}" class="btn btn-primary-custom mt-3">ORDER SOMETHING NOW</a>
        </div>
    @endforelse
</div>
@endsection