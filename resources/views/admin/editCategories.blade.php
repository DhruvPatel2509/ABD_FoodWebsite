@extends('admin.layout')
@section('title', 'Edit Category')

@section('content')
    <div class="welcome-banner">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="margin: 0; font-size: 26px;">Edit Category</h1>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Update category details, image, and current status.</p>
            </div>
            <a href="{{ url('/admin/categories') }}" class="btn"
                style="background: white; color: var(--sidebar-bg); padding: 10px 20px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 14px;">
                Back to Categories
            </a>
        </div>
    </div>

    <div class="data-card" style="padding: 40px; max-width: 900px; margin: 0 auto;">
        <form action="{{ url('/admin/categories/update/' . $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 25px;">
                <label style="font-weight: 700; color: var(--text-dark); display: block; margin-bottom: 10px;">Category
                    Name</label>
                <input type="text" name="cat_name" value="{{ old('cat_name', $category->name) }}"
                    style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; font-size: 14px;"
                    required>
                @error('cat_name')
                    <span style="color: #e11d48; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-weight: 700; color: var(--text-dark); display: block; margin-bottom: 10px;">Current
                    Image</label>
                <div
                    style="width: 150px; height: 150px; border-radius: 15px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    <img src="{{ asset($category->image_url) }}" style="width: 100%; height: 100%; object-fit: cover;"
                        onerror="this.src='{{ asset('images/default-cat.jpg') }}'">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-weight: 700; color: var(--text-dark); display: block; margin-bottom: 10px;">Replace Image
                    (Optional)</label>
                <div style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; background: #fcfcfc;">
                    <input type="file" name="image" style="font-size: 14px; color: var(--text-muted);">
                </div>
                <small style="color: var(--text-muted); display: block; margin-top: 8px;">Leave empty if you do not want to
                    change the image.</small>
            </div>

            <div style="margin-bottom: 35px;">
                <label
                    style="font-weight: 700; color: var(--text-dark); display: block; margin-bottom: 10px;">Status</label>
                <select name="status"
                    style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; background: white; font-size: 14px;">
                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit"
                    style="background: #e11d48; color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 14px;">
                    Update Category
                </button>
                <a href="{{ url('/admin/categories') }}"
                    style="background: white; color: var(--text-dark); border: 1px solid #e2e8f0; padding: 12px 30px; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 14px; text-align: center;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection