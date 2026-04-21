@extends('admin.layout')
@section('title', 'Create Category')

@section('content')
    <div class="container-fluid" style="max-width: 800px; margin: 0 auto;">
        <div class="welcome-banner mb-0"
            style="background: linear-gradient(135deg, #e11d48 0%, #fb923c 100%); border-radius: 15px 15px 0 0; padding: 30px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0; font-size: 28px; font-weight: 700;">Create Category</h1>
                    <p style="margin: 5px 0 0 0; opacity: 0.9; font-size: 14px;">Add a new category with name and image for
                        your menu.</p>
                </div>
                <a href="{{ url('/admin/categories') }}" class="btn"
                    style="background: white; color: #e11d48; padding: 8px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    Back to Categories
                </a>
            </div>
        </div>

        <div class="data-card"
            style="background: white; padding: 40px; border-radius: 0 0 15px 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; border-top: none;">
            <form action="{{ url('/admin/categories/store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="form-label-custom">Category Name</label>
                    <input type="text" name="name" class="form-control-custom" placeholder="e.g. Punjabi" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-custom">Category Image</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="image" class="form-control-custom" required>
                    </div>
                    <small style="color: #64748b; margin-top: 8px; display: block;">Upload a high-quality image for the menu
                        card.</small>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn-save">
                        Save Category
                    </button>
                    <a href="{{ url('/admin/categories') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            .form-label-custom {
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 8px;
                display: block;
                font-size: 15px;
            }

            .form-control-custom {
                width: 100%;
                border-radius: 10px;
                padding: 12px 15px;
                border: 1px solid #e2e8f0;
                background-color: #fff;
                transition: all 0.2s;
                font-size: 15px;
            }

            .form-control-custom:focus {
                outline: none;
                border-color: #e11d48;
                box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
            }

            .btn-save {
                background: #e11d48;
                color: white;
                border: none;
                padding: 12px 30px;
                border-radius: 10px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-save:hover {
                background: #be123c;
                transform: translateY(-1px);
            }

            .btn-cancel {
                background: white;
                color: #64748b;
                border: 1px solid #e2e8f0;
                padding: 12px 30px;
                border-radius: 10px;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                transition: all 0.2s;
            }

            .btn-cancel:hover {
                background: #f8fafc;
                color: #1e293b;
            }

            /* File input styling */
            input[type="file"]::file-selector-button {
                background: #f1f5f9;
                color: #475569;
                border: none;
                padding: 5px 15px;
                border-radius: 5px;
                margin-right: 15px;
                cursor: pointer;
                font-weight: 600;
            }
        </style>
    @endpush
@endsection