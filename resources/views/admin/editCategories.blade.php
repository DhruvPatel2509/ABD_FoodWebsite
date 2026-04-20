@extends('admin.layout')

@section('content')

    <div class="mx-auto max-w-3xl">
        <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Edit Category</h1>
                    <p class="mt-1 text-sm text-slate-200">Update category details, image, and current status.</p>
                </div>
                <a href="{{ url('/admin/categories') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-white/70 focus:ring-offset-1 focus:ring-offset-slate-800">
                    Back to Categories
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 shadow-sm">
                <p class="font-semibold">Please fix the following issues:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md sm:p-7">
            <form action="{{ url('/admin/categories/updateCat/' . $category->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div>
                    <label for="cat_name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Category Name
                    </label>
                    <input id="cat_name" type="text" name="cat_name"
                        value="{{ old('cat_name', $category->cat_name) }}" required
                        placeholder="Enter category name"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100 @error('cat_name') border-rose-300 focus:border-rose-400 focus:ring-rose-100 @enderror">
                    @error('cat_name')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Current Image
                    </label>

                    <div class="mb-3 inline-block rounded-xl border border-slate-200 bg-slate-50 p-2">
                        <img src="{{ $category->image_url ?? 'https://via.placeholder.com/160x160?text=No+Image' }}" alt="{{ $category->cat_name }}"
                            class="h-36 w-36 rounded-lg object-cover ring-1 ring-slate-200">
                    </div>

                    <label for="image" class="mb-1.5 block text-sm font-medium text-slate-600">Replace Image (Optional)</label>
                    <input id="image" type="file" name="image" accept="image/*"
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-rose-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-rose-700 hover:file:bg-rose-100 @error('image') border-rose-300 @enderror">
                    <p class="mt-1.5 text-xs text-slate-500">Leave empty if you do not want to change the image.</p>
                    @error('image')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Status
                    </label>
                    <select id="status" name="status"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100 @error('status') border-rose-300 focus:border-rose-400 focus:ring-rose-100 @enderror">

                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-1">
                        Update Category
                    </button>
                    <a href="{{ url('/admin/categories') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
