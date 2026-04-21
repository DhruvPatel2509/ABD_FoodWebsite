@extends('admin.layout')

@section('content')
    <div class="category-details-container">
        <div class="category-header">
            <div class="header-content-wrapper">
                <div class="header-text">
                    <h1 class="header-title">Category Details</h1>
                    <p class="header-subtitle">View full information</p>
                </div>
                <a href="{{ url('/admin/categories') }}" class="btn-back">
                    Back to Categories
                </a>
            </div>
        </div>

        <div class="details-card">
            <div class="details-grid">
                <div class="image-column">
                    <div class="image-wrapper">
                        <img src="{{ $category->image_url ?? 'https://via.placeholder.com/320x320?text=No+Image' }}"
                            alt="{{ $category->cat_name }}" class="category-main-img">
                    </div>
                </div>

                <div class="info-column">
                    <div class="info-group">
                        <p class="info-label">Category Name</p>
                        <p class="info-value title-value">{{ $category->cat_name }}</p>
                    </div>

                    <div class="info-group">
                        <p class="info-label">Slug</p>
                        <p class="info-value slug-value">{{ $category->slug }}</p>
                    </div>

                    <div class="info-group">
                        <p class="info-label">Status</p>
                        <span
                            class="status-badge {{ $category->status == 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($category->status) }}
                        </span>
                    </div>

                    <div class="timestamp-grid">
                        <div class="timestamp-box">
                            <p class="info-label">Created At</p>
                            <p class="timestamp-text">
                                {{ optional($category->created_at)->format('d M Y, h:i A') ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="timestamp-box">
                            <p class="info-label">Updated At</p>
                            <p class="timestamp-text">
                                {{ optional($category->updated_at)->format('d M Y, h:i A') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ url('/admin/categories/edit/' . $category->id) }}" class="btn-edit">
                    Edit Category
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Main Container */
        .category-details-container {
            max-width: 896px;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 2rem;
        }

        /* Header Section */
        .category-header {
            margin-bottom: 1.5rem;
            border-radius: 1rem;
            border: 1px solid #fecaca;
            background: linear-gradient(to right, #dc2626, #e11d48, #f97316);
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .header-content-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .header-content-wrapper {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .header-title {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .header-subtitle {
            color: #e2e8f0;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .btn-back {
            background-color: #ffffff;
            color: #0f172a;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.875rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s;
        }

        .btn-back:hover {
            background-color: #f1f5f9;
        }

        /* Main Card */
        .details-card {
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .details-grid {
                grid-template-columns: repeat(5, 1fr);
            }

            .image-column {
                grid-column: span 2;
            }

            .info-column {
                grid-column: span 3;
            }
        }

        /* Image Styles */
        .image-wrapper {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            padding: 0.75rem;
        }

        .category-main-img {
            height: 16rem;
            width: 100%;
            border-radius: 0.5rem;
            object-fit: cover;
            box-shadow: 0 0 0 1px #e2e8f0;
        }

        /* Info Styles */
        .info-group {
            margin-bottom: 1rem;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            color: #64748b;
            margin: 0;
        }

        .info-value {
            margin-top: 0.25rem;
            font-weight: 600;
        }

        .title-value {
            font-size: 1.25rem;
            color: #1e293b;
        }

        .slug-value {
            font-size: 0.875rem;
            color: #334155;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.25rem;
        }

        .status-active {
            background-color: #d1fae5;
            color: #047857;
        }

        .status-inactive {
            background-color: #ffe4e6;
            color: #be123c;
        }

        /* Timestamps */
        .timestamp-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        @media (min-width: 640px) {
            .timestamp-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .timestamp-box {
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            padding: 0.75rem;
        }

        .timestamp-text {
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            margin-top: 0.25rem;
        }

        /* Footer actions */
        .card-footer {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        @media (min-width: 640px) {
            .card-footer {
                flex-direction: row;
                align-items: center;
            }
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            background-color: #e11d48;
            color: #ffffff;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s;
        }

        .btn-edit:hover {
            background-color: #be123c;
        }
    </style>
@endpush