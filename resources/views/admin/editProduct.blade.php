@extends('admin.layout')
@section('title', 'Edit Product')

@section('content')
    <div class="product-form-container">
        <div class="form-header-banner">
            <div class="header-content-wrapper">
                <div class="header-text">
                    <h1 class="header-title">Edit Product: {{ $product->name }}</h1>
                    <p class="header-subtitle">Update pricing, category, and manage product images.</p>
                </div>
                <a href="{{ url('/admin/products') }}" class="btn-back">
                    Back to List
                </a>
            </div>
        </div>

        <div class="form-card-body">
            @if ($errors->any())
                <div
                    style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #fecaca;">
                    <ul style="margin: 0; font-size: 14px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/admin/products/update/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="form-group span-12">
                        <label class="custom-label">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="custom-input"
                            required>
                    </div>

                    <div class="form-group span-6">
                        <label class="custom-label">Category</label>
                        <select name="category_id" class="custom-input" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group span-6" style="display: flex; align-items: center; padding-top: 25px;">
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                            <span class="custom-label" style="margin:0;">Show in Featured Section</span>
                        </label>
                    </div>

                    <div class="form-group span-6">
                        <label class="custom-label">Original Price (MRP)</label>
                        <input type="number" step="0.01" name="original_price"
                            value="{{ old('original_price', $product->original_price) }}" class="custom-input" required>
                        <small style="color: #64748b;">The price before discount (striked out).</small>
                    </div>

                    <div class="form-group span-6">
                        <label class="custom-label">Selling Price (Discounted)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                            class="custom-input" required>
                        <small style="color: #64748b;">The price the customer actually pays.</small>
                    </div>

                    <div class="form-group span-12">
                        <label class="custom-label">Product Description</label>
                        <textarea name="description" class="custom-input" rows="4"
                            placeholder="Enter ingredients or dish details...">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-group span-12">
                        <label class="custom-label">Current Gallery</label>
                        <div class="current-images-gallery">
                            @forelse($product->images as $img)
                                <div class="image-preview-item">
                                    <img src="{{ asset('images/products/' . $img->image_path) }}" alt="Product Image">
                                </div>
                            @empty
                                <p style="font-size: 13px; color: #94a3b8; padding: 10px;">No images uploaded yet.</p>
                            @endforelse
                        </div>

                        <label class="custom-label mt-4">Add More Images</label>
                        <div class="image-upload-box">
                            <input type="file" name="images[]" class="custom-file-input" multiple>
                            <p class="upload-hint">You can select multiple images to add to the gallery.</p>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-update">
                        Save Changes
                    </button>
                    <a href="{{ url('/admin/products') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .product-form-container {
            max-width: 900px;
            margin: 2rem auto;
        }

        .form-header-banner {
            background: linear-gradient(135deg, #e11d48 0%, #fb923c 100%);
            padding: 2rem;
            border-radius: 1rem 1rem 0 0;
            color: white;
        }

        .header-content-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .btn-back {
            background: white;
            color: #e11d48;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.8rem;
        }

        .form-card-body {
            background: white;
            padding: 2.5rem;
            border-radius: 0 0 1rem 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
        }

        .span-12 {
            grid-column: span 12;
        }

        .span-6 {
            grid-column: span 6;
        }

        .custom-label {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            display: block;
            font-size: 0.9rem;
        }

        .custom-input {
            width: 100%;
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            box-sizing: border-box;
        }

        .custom-input:focus {
            outline: none;
            border-color: #e11d48;
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
        }

        .current-images-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #f1f5f9;
        }

        .image-preview-item {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid #fff;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-upload-box {
            border: 2px dashed #e2e8f0;
            padding: 15px;
            border-radius: 10px;
            background: #fcfcfc;
            text-align: center;
        }

        .upload-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 5px;
        }

        .form-footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            gap: 1rem;
        }

        .btn-update {
            background: #e11d48;
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-update:hover {
            background: #be123c;
            transform: translateY(-1px);
        }

        .btn-cancel {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }
    </style>
@endpush