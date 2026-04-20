@extends('admin.layout')

@section('title', 'Products')
@section('header_title', 'Products')

@section('content')
    <div
        class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-white">Product Management</h1>
                <p class="mt-1 text-sm text-slate-200">Manage dishes, pricing, discounts, and stock status.</p>
            </div>
            <a href="{{ url('/admin/products/create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-rose-50">
                + Add Product
            </a>
        </div>
    </div>

    @if(session('success'))
        <div
            class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-700">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Gallery</th>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3 text-center">Discount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse ($products as $product)
                        <tr class="group transition hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>

                            <td class="px-4 py-3">
                                <div class="flex max-w-[160px] flex-wrap gap-1.5">
                                    @forelse($product->images as $img)
                                        {{-- Updated to use our new accessor and added a fallback --}}
                                        <img src="{{ $img->image_url }}"
                                            class="h-10 w-10 rounded border border-slate-200 object-cover shadow-sm transition duration-200 hover:scale-110"
                                            onerror="this.src='https://via.placeholder.com/100x100?text=Food'"
                                            title="{{ $product->name }}">
                                    @empty
                                        <span class="text-xs italic text-slate-400">No images</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                    {{-- Ensuring this matches your Category Model attribute --}}
                                    {{ $product->category->cat_name ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $product->name }}</td>

                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                    {{ $product->category->cat_name ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                @if($product->original_price)
                                    <div class="text-[10px] text-slate-400 line-through">
                                        Rs {{ number_format($product->original_price, 2) }}
                                    </div>
                                @endif
                                <div class="font-bold text-emerald-600">
                                    Rs {{ number_format($product->price, 2) }}
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($product->discount_percent > 0)
                                    <span
                                        class="rounded-full bg-amber-100 px-2 py-1 text-[10px] font-bold uppercase tracking-tight text-amber-700">
                                        {{ $product->discount_percent }}% OFF
                                    </span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <span
                                    class="rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-tight {{ $product->availability === 'available' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ str_replace('_', ' ', $product->availability ?? 'available') }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ url('/admin/products/edit/' . $product->id) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                                        title="Edit Product">
                                        <i data-feather="edit-2" class="h-4 w-4"></i>
                                    </a>

                                    <a href="{{ url('/admin/products/delete/' . $product->id) }}"
                                        onclick="return confirm('Are you sure? This will remove the product and all related images.')"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700"
                                        title="Delete Product">
                                        <i data-feather="trash-2" class="h-4 w-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400">
                                No products found in the database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection