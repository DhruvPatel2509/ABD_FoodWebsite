@extends('admin.layout')
@section('title', 'Order Details')

@section('content')
    <div class="order-details-wrapper">
        <div class="order-banner">
            <div class="banner-content">
                <div class="header-text">
                    <h1 class="order-id-title">Order #{{ $order->id }}</h1>
                    <p class="order-meta">
                        <span class="meta-label">Customer:</span> {{ $order->user->name ?? 'Guest' }}
                        <span class="meta-divider">|</span>
                        <span class="status-indicator-text">{{ strtoupper($order->status) }}</span>
                    </p>
                </div>
                <a href="{{ url('/admin/orders') }}" class="btn-back-light">
                    Back to Orders
                </a>
            </div>
        </div>

        <div class="order-grid">
            <div class="order-items-column">
                <div class="detail-card">
                    <div class="card-header">
                        Items Ordered
                    </div>
                    <div class="table-responsive">
                        <table class="order-items-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="item-name">{{ $item->food_name }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">Rs {{ number_format($item->price, 2) }}</td>
                                        <td class="text-right item-total">Rs
                                            {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="order-summary-column">
                <div class="detail-card summary-padding">
                    <h5 class="summary-title">Order Summary</h5>

                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">Rs {{ number_format($order->total_amount, 2) }}</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="status-update-section">
                        <label class="update-label">Update Status</label>
                        <form action="{{ url('/admin/updateOrderStatus/' . $order->id) }}" method="POST">
                            @csrf
                            <select name="status" class="custom-select-field">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                            <button type="submit" class="btn-update-status">
                                Update Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Main Layout */
        .order-details-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 3rem;
        }

        /* Gradient Banner */
        .order-banner {
            background: linear-gradient(135deg, #e11d48 0%, #fb923c 100%);
            padding: 2rem;
            border-radius: 1rem 1rem 0 0;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .banner-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-id-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .order-meta {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .meta-divider {
            margin: 0 10px;
            opacity: 0.5;
        }

        .status-indicator-text {
            font-weight: 800;
            text-decoration: underline;
        }

        .btn-back-light {
            background: white;
            color: #e11d48;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        /* Grid Layout */
        .order-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-top: -1px;
            /* Align with border of banner */
        }

        @media (max-width: 992px) {
            .order-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .detail-card {
            background: white;
            border-radius: 0 0 1rem 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 700;
            color: #1e293b;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .order-items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-items-table th {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.025em;
        }

        .order-items-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.9rem;
        }

        .item-name {
            font-weight: 600;
            color: #1e293b;
        }

        .item-total {
            font-weight: 700;
            color: #0f172a;
        }

        /* Summary Sidebar */
        .summary-padding {
            padding: 1.5rem;
            border-radius: 0 0 1rem 1rem !important;
        }

        .summary-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1e293b;
            font-size: 1.1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .summary-label {
            color: #64748b;
        }

        .summary-value {
            font-weight: 700;
            color: #0f172a;
        }

        .summary-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 1.5rem 0;
        }

        /* Status Form */
        .update-label {
            font-weight: 700;
            display: block;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            color: #1e293b;
        }

        .custom-select-field {
            width: 100%;
            border-radius: 10px;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            outline: none;
        }

        .custom-select-field:focus {
            border-color: #e11d48;
        }

        .btn-update-status {
            width: 100%;
            background: #e11d48;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-update-status:hover {
            background: #be123c;
            transform: translateY(-1px);
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
@endpush