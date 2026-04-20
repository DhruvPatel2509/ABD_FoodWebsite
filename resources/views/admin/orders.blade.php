@extends('admin.layout')

@section('title', 'Orders')
@section('header_title', 'Orders')

@section('content')
    <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-white">Orders</h1>
                <p class="mt-1 text-sm text-slate-200">Track customer orders and update fulfillment status.</p>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-rose-50">
                Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Order ID</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($orders as $order)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-800">#{{ $order->id }}</td>
                            <td class="px-4 py-3">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-4 py-3 font-semibold text-emerald-600">Rs {{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : '' }}
                                    {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $order->status === 'processing' ? 'bg-orange-100 text-orange-700' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ optional($order->created_at)->format('d M Y') ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ url('/admin/viewOrder/' . $order->id) }}"
                                    class="inline-flex items-center rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-400">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
