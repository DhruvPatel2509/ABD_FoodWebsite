@extends('admin.layout')
@section('title', 'Orders')

@section('content')
    <div class="order-index-container">
        <div class="order-header-banner">
            <div class="header-text">
                <h1 class="header-title">Order Management</h1>
                <p class="header-subtitle">Track customer orders and update fulfillment status.</p>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="custom-admin-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="order-id">#{{ $order->id }}</td>
                                <td>
                                    <div class="customer-name">{{ $order->user->name ?? 'Guest' }}</div>
                                    <div class="customer-phone">{{ $order->phone }}</div>
                                </td>
                                <td class="order-amount">Rs {{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="order-date">{{ $order->created_at->format('d M, h:i A') }}</td>
                                <td class="text-right">
                                    <a href="{{ url('/admin/viewOrder/' . $order->id) }}" class="btn-view">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <div class="empty-icon">🛒</div>
                                    <p>No orders found in the database.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Container Styling */
        .order-index-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 3rem;
        }

        /* Gradient Header */
        .order-header-banner {
            background: linear-gradient(135deg, #e11d48 0%, #fb923c 100%);
            padding: 2rem;
            border-radius: 1rem 1rem 0 0;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-subtitle {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        /* Table Card Styling */
        .table-card {
            background: white;
            border-radius: 0 0 1rem 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            border-top: none;
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .custom-admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-admin-table thead th {
            background-color: #f8fafc;
            padding: 1rem 1.5rem;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            border-bottom: 1px solid #e2e8f0;
        }

        .custom-admin-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s;
        }

        .custom-admin-table tbody tr:hover {
            background-color: #fcfcfc;
        }

        .custom-admin-table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        /* Specific Column Styles */
        .order-id {
            font-weight: 700;
            color: #1e293b;
        }

        .customer-name {
            font-weight: 700;
            color: #1e293b;
        }

        .customer-phone {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .order-amount {
            font-weight: 700;
            color: #0f172a;
        }

        .order-date {
            color: #64748b;
        }

        .text-right {
            text-align: right;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Action Button */
        .btn-view {
            background-color: #1e293b;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-view:hover {
            background-color: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Empty State */
        .empty-state {
            padding: 5rem 0 !important;
            text-align: center;
            color: #94a3b8;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.4;
        }
    </style>
@endpush