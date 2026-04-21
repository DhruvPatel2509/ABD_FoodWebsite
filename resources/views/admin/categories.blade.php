@extends('admin.layout')
@section('title', 'Categories')

@section('content')
    <div class="welcome-banner">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="margin: 0; font-size: 26px;">Category Management</h1>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Create, update, and organize your food categories.</p>
            </div>
            <a href="{{ url('/admin/categories/create') }}" class="btn"
                style="background: white; color: var(--sidebar-bg); padding: 10px 20px; border-radius: 10px; font-weight: 700; text-decoration: none;">
                + Add New Category
            </a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <p>TOTAL CATEGORIES</p>
            <h3 style="text-align: left;">{{ $categories->count() }}</h3>
        </div>
        <div class="stat-card" style="background: #ecfdf5; border-color: #a7f3d0;">
            <p style="color: #059669;">ACTIVE</p>
            <h3 style="text-align: left; color: #059669;">{{ $categories->count() }}</h3>
        </div>
        <div class="stat-card" style="background: #fef2f2; border-color: #fecaca;">
            <p style="color: #dc2626;">INACTIVE</p>
            <h3 style="text-align: left; color: #dc2626;">0</h3>
        </div>
    </div>

    <div class="data-card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>IMAGE</th>
                    <th>NAME</th>
                    <th>SLUG</th>
                    <th>STATUS</th>
                    <th style="text-align: right;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset($cat->image_url) }}"
                                style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid #f1f5f9;"
                                onerror="this.src='{{ asset('images/default-cat.jpg') }}'">
                        </td>
                        <td style="font-weight: 600;">{{ $cat->name }}</td>
                        <td style="color: #64748b;">{{ $cat->slug }}</td>
                        <td><span
                                style="background: #ecfdf5; color: #059669; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">Active</span>
                        </td>
                        <td style="text-align: right;">
                            <a href="/admin/categories/show/{{ $cat->id }}" style="color: #64748b; margin-right: 15px;"><i
                                    class="fa-solid fa-eye"></i></a>
                            <a href="{{ url('/admin/categories/edit/' . $cat->id) }}" style="color: #64748b;"><i
                                    class="fa-solid fa-pen"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection