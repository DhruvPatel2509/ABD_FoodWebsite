@extends('admin.layout')
@section('title', 'Add Product')

@section('content')
    <div class="product-form-container">
        <div class="form-header-banner">
            <div class="header-content-wrapper">
                <div class="header-text">
                    <h1 class="header-title">Add New Product</h1>
                    <p class="header-subtitle">Fill in the details to add a new dish to your menu.</p>
                </div>
                <a href="{{ url('/admin/products') }}" class="btn-back">
                    Back to List
                </a>
            </div>
        </div>

        <div class="form-card-body">
            <form action="{{ url('/admin/products/store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="form-group span-6">
                        <label class="custom-label">Product Name</label>
                        <input type="text" name="name" class="custom-input" placeholder="e.g. Paneer Tikka" required>
                    </div>

                    <div class="form-group span-6">
                        <label class="custom-label">Category</label>
                        <select name="category_id" class="custom-input" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group span-4">
                        <label class="custom-label">Selling Price (Rs)</label>
                        <input type="number" name="price" class="custom-input" placeholder="0.00" required>
                    </div>

                    <div class="form-group span-4">
                        <label class="custom-label">Original Price (Rs)</label>
                        <input type="number" name="original_price" class="custom-input" placeholder="0.00">
                    </div>

                    <div class="form-group span-4">
                        <label class="custom-label">Status</label>
                        <select name="availability" class="custom-input">
                            <option value="available">Available</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                    </div>

                    <div class="form-group span-12">
                        <label class="custom-label">Description</label>
                        <textarea name="description" class="custom-input" rows="4"
                            placeholder="Describe the dish..."></textarea>
                    </div>

                    <div class="form-group span-12">
                        <label class="custom-label">Product Images (Multiple)</label>
                        <div class="image-upload-box">
                            <input type="file" name="images[]" class="custom-file-input" multiple>
                            <p class="upload-hint">You can select multiple images at once.</p>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-submit">
                        Save Product
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

        /* Gradient Header Section */
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

        .btn-back:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        /* Form Card Body */
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

        .form-group {
            display: flex;
            flex-direction: column;
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

        /* Input Styling */
        .custom-label {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .custom-input {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #fff;
        }

        .custom-input:focus {
            outline: none;
            border-color: #e11d48;
            box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.1);
        }

        /* File Upload Area */
        .image-upload-box {
            border: 2px dashed #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            background: #f8fafc;
            text-align: center;
        }

        .custom-file-input {
            width: 100%;
        }

        .upload-hint {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 10px;
        }

        /* Action Buttons */
        .form-footer {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            gap: 1rem;
        }

        .btn-submit {
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

        .btn-submit:hover {
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