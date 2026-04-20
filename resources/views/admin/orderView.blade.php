@extends('admin.layout')

@section('title', 'Order Details')
@section('header_title', 'Order Details')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-white">Order #{{ $order->id }} Details</h2>
                    <p class="mt-1 text-sm text-slate-200">Review customer information, order items, and current status.</p>
                </div>
                <a href="{{ url('/admin/orders') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-rose-50">
                    Back to Orders
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md">
            <div class="grid gap-4 text-sm text-slate-700 md:grid-cols-2">
                <p>
                    <span class="font-semibold text-slate-500">Customer:</span>
                    {{ $order->user->name ?? 'Guest' }}
                </p>

                <p>
                    <span class="font-semibold text-slate-500">Email:</span>
                    {{ $order->user->email ?? 'N/A' }}
                </p>

                <p>
                    <span class="font-semibold text-slate-500">Phone:</span>
                    {{ $order->phone }}
                </p>

                <p>
                    <span class="font-semibold text-slate-500">Date:</span>
                    {{ optional($order->created_at)->format('d M Y, h:i A') ?? 'N/A' }}
                </p>

                <p class="md:col-span-2">
                    <span class="font-semibold text-slate-500">Address:</span>
                    {{ $order->address }}
                </p>

                <p>
                    <span class="font-semibold text-slate-500">Payment:</span>
                    {{ strtoupper($order->payment_method ?? 'cod') }}
                </p>

                <p>
                    <span class="font-semibold text-slate-500">Status:</span>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                        {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $order->status === 'processing' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-700">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Image</th>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Qty</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @php $grandTotal = 0; @endphp

                        @foreach($order->items as $item)
                            @php
                                $subtotal = $item->quantity * $item->price;
                                $grandTotal += $subtotal;
                                $product = $item->foodItem;
                                $previewImage = optional($product?->images->first())->image_url ?? $product?->image_url;
                            @endphp

                            <tr class="transition hover:bg-slate-50">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    @if($previewImage)
                                        <img src="{{ $previewImage }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200">
                                    @else
                                        <span class="text-xs text-slate-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">
                                        {{ $item->food_name }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        Category: {{ $product?->category?->cat_name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">Rs {{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-800">
                                    Rs {{ number_format($subtotal, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="bg-slate-50 text-base font-bold">
                            <td colspan="5" class="px-4 py-3 text-right text-slate-700">Grand Total:</td>
                            <td class="px-4 py-3 text-right text-emerald-600">
                                Rs {{ number_format($grandTotal, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-md">
            <form action="{{ url('/admin/orders/update-status/' . $order->id) }}" method="POST" class="flex flex-col items-start gap-3 md:flex-row md:items-center">
                @csrf

                <label class="font-semibold text-slate-700">Update Status:</label>

                <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                    Update
                </button>
            </form>
        </div>
    </div>
@endsection
