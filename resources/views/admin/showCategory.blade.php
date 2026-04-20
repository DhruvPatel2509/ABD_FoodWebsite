@extends('admin.layout')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div
            class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Category Details</h1>
                    <p class="mt-1 text-sm text-slate-200">View full information </p>
                </div>
                <a href="{{ url('/admin/categories') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-white/70 focus:ring-offset-1 focus:ring-offset-slate-800">
                    Back to Categories
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md sm:p-7">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-5">
                <div class="md:col-span-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <img src="{{ $category->image_url ?? 'https://via.placeholder.com/320x320?text=No+Image' }}" alt="{{ $category->cat_name }}"
                            class="h-64 w-full rounded-lg object-cover ring-1 ring-slate-200">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Category Name</p>
                            <p class="mt-1 text-xl font-semibold text-slate-800">{{ $category->cat_name }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Slug</p>
                            <p class="mt-1 text-sm font-medium text-slate-700">{{ $category->slug }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</p>
                            <span
                                class="mt-1 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $category->status == 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Created At</p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ optional($category->created_at)->format('d M Y, h:i A') ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Updated At</p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ optional($category->updated_at)->format('d M Y, h:i A') ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center">
                <a href="{{ url('/admin/categories/edit/' . $category->id) }}"
                    class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-1">
                    Edit Category
                </a>
                <!-- <a href="{{ url('/admin/categories/delete/' . $category->id) }}"
                        onclick="return confirm('Are you sure you want to delete this category?')"
                        class="inline-flex items-center justify-center rounded-lg border border-rose-300 bg-white px-5 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">
                        Delete Category
                    </a> -->
            </div>
        </div>
    </div>
@endsection
