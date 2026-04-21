@extends('admin.layout')
@section('title', 'Products')

@section('content')
<div class="welcome-banner">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0; font-size: 26px;">Product Management</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Manage dishes, pricing, discounts, and stock status.</p>
        </div>
        <a href="{{ url('/admin/products/create') }}" class="btn" style="background: white; color: var(--sidebar-bg); padding: 10px 20px; border-radius: 10px; font-weight: 700; text-decoration: none;">
            + Add Product
        </a>
    </div>
</div>

<div class="data-card">
    <table class="custom-table">
        <thead>
            <tr>
                <th>#</th>
                <th>GALLERY</th>
                <th>PRODUCT</th>
                <th>CATEGORY</th>
                <th>PRICE</th>
                <th>DISCOUNT</th>
                <th>STATUS</th>
                <th style="text-align: right;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <div style="display: flex; gap: 4px;">
                        @foreach($product->images->take(2) as $img)
                            <img src="{{ asset('images/products/'.$img->image_path) }}" style="width: 35px; height: 35px; border-radius: 4px; object-fit: cover;">
                        @endforeach
                    </div>
                </td>
                <td style="font-weight: 700;">{{ $product->name }}</td>
                <td><span style="background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-size: 12px;">{{ $product->category->name ?? 'N/A' }}</span></td>
                <td>
                    <div style="color: #059669; font-weight: 700;">Rs {{ number_format($product->price, 0) }}</div>
                    @if($product->original_price > $product->price)
                        <small style="text-decoration: line-through; color: #94a3b8;">Rs {{ number_format($product->original_price, 0) }}</small>
                    @endif
                </td>
                <td style="text-align: center;">-</td>
                <td><span style="background: #e11d48; color: white; padding: 3px 8px; border-radius: 5px; font-size: 10px; font-weight: 800;">AVAILABLE</span></td>
                <td style="text-align: right;">
                    <a href="{{ url('/admin/products/edit/'.$product->id) }}" style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; color: #3b82f6; margin-right: 5px;"><i class="fa-solid fa-pen"></i></a>
                    <a href="{{ url('/admin/products/delete/'.$product->id) }}" style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; color: #ef4444;"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection