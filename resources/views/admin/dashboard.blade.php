@extends('admin.layout')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
    <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-white">Welcome back, {{ Auth::user()->name }}</h1>
                <p class="mt-1 text-sm text-slate-200">Here’s a live snapshot of your store, customers, and orders.</p>
            </div>
            <div class="rounded-xl bg-white/10 px-4 py-3 text-sm font-medium text-slate-100">
                Pending orders: <span class="font-semibold">{{ $stats['pending_orders'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="/admin/categories" class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Categories</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-800">{{ $stats['categories'] }}</h2>
            <p class="mt-2 text-sm text-slate-500">Manage your menu sections.</p>
        </a>

        <a href="/admin/products" class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Products</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-800">{{ $stats['products'] }}</h2>
            <p class="mt-2 text-sm text-slate-500">Update dishes, pricing, and stock.</p>
        </a>

        <a href="/admin/orders" class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Orders</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-800">{{ $stats['orders'] }}</h2>
            <p class="mt-2 text-sm text-slate-500">Track every incoming order.</p>
        </a>

        <a href="/admin/users" class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Users</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-800">{{ $stats['users'] }}</h2>
            <p class="mt-2 text-sm text-slate-500">Manage customer and admin access.</p>
        </a>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-md">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-lg font-semibold text-slate-800">Recent Orders</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Order</th>
                            <th class="px-5 py-3">Customer</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-semibold text-slate-800">
                                    <a href="{{ url('/admin/viewOrder/' . $order->id) }}" class="hover:text-rose-600">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right font-semibold text-slate-800">Rs {{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-slate-500">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-md">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Revenue</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-800">Rs {{ number_format($stats['revenue'], 2) }}</h2>
            <p class="mt-2 text-sm text-slate-500">Calculated from all non-cancelled orders.</p>

            <div class="mt-6 space-y-3">
                <a href="/admin/categories/create" class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-rose-200 hover:bg-rose-50">
                    <span>Add a new category</span>
                    <span>+</span>
                </a>
                <a href="/admin/products/create" class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-rose-200 hover:bg-rose-50">
                    <span>Create a new product</span>
                    <span>+</span>
                </a>
                <a href="/admin/users" class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-rose-200 hover:bg-rose-50">
                    <span>Review user roles</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
@endsection
