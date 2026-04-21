@extends('admin.layout')
@section('title', 'Edit Product')

@section('content')
    <div class="product-form-container">
        <div class="form-header-banner">
            <div class="header-content-wrapper">
                <div class="header-text">
                    <h1 class="header-title">Edit Product: {{ $product->name }}</h1>
                    <p class="header-subtitle">Modify pricing, category, or add new images for this dish.</p>
                </div>
                <a href="{{ url('/admin/products') }}" class="btn-back">
                    Back to List
                </a>
            </div>
        </div>

        <div class="form-card-body">
            <form action="{{ url('/admin/products/update/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="form-group span-6">
                        <label class="custom-label">Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="custom-input" required>
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

                    <div class="form-group span-4">
                        <label class="custom-label">Selling Price (Rs)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="custom-input" required>
                    </div>

                    <div class="form-group span-4">
                        <label class="custom-label">Discount %</label>
                        <input type="number" name="discount_percent" value="{{ $product->discount_percent }}"
                            class="custom-input" placeholder="0">
                    </div>

                    <div class="form-group span-4">
                        <label class="custom-label">Status</label>
                        <select name="availability" class="custom-input">
                            <option value="available" {{ $product->availability == 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="out_of_stock" {{ $product->availability == 'out_of_stock' ? 'selected' : '' }}>Out
                                of Stock</option>
                        </select>
                    </div>

                    <div class="form-group span-12">
                        <label class="custom-label">Current Images</label>
                        <div class="current-images-gallery">
                            @foreach($product->images as $img)
                                <div class="image-preview-item">
                                    <img src="{{ asset('images/products/' . $img->image_path) }}" alt="Product Image">
                                </div>
                            @endforeach
                        </div>

                        <label class="custom-label mt-4">Upload New Images</label>
                        <div class="image-upload-box">
                            <input type="file" name="images[]" class="custom-file-input" multiple>
                            <p class="upload-hint">Select one or more files to replace or add to the gallery.</p>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-update">
                        Update Product
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
        /* Layout Container */
        .product-form-container {
            max-width: 1000px;
            margin: 0 auto;
            padding-bottom: 3rem;
        }

        /* Header Banner */
        .form-header-banner {
            background: linear-gradient(135deg, #e11d48 0%, #fb923c 100%);
            padding: 2rem;
            border-radius: 1rem 1rem 0 0;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        /* Card Body */
        .form-card-body {
            background: white;
            padding: 2.5rem;
            border-radius: 0 0 1rem 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            border-top: none;
        }

        /* Grid System */
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

        .span-4 {
            grid-column: span 4;
        }

        @media (max-width: 768px) {

            .span-6,
            .span-4 {
                grid-column: span 12;
            }
        }

        /* Input Elements */
        .custom-label {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            display: block;
            font-size: 0.9rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .custom-input {
            width: 100%;
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .custom-input:focus {
            outline: none;
            border-color: #e11d48;
            box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.1);
        }

        /* Gallery Section */
        .current-images-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
        }

        .image-preview-item {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Upload Box */
        .image-upload-box {
            border: 2px dashed #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            background: #f8fafc;
            text-align: center;
        }

        .upload-hint {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 10px;
        }

        /* Footer Buttons */
        .form-footer {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            gap: 1rem;
        }

        .btn-update {
            background: #e11d48;
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);
            transition: 0.3s;
        }

        .btn-update:hover {
            background: #be123c;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            color: #1e293b;
        }
    </style>
@endpush