@extends('admin.layout')

@section('content')

    <div class="mx-auto max-w-3xl">
        <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Create Category</h1>
                    <p class="mt-1 text-sm text-slate-200">Add a new category with name, image, and availability status.</p>
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
            <form action="{{ url('/admin/categories/store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="cat_name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Category Name
                    </label>
                    <input id="cat_name" type="text" name="cat_name" value="{{ old('cat_name') }}" required
                        placeholder="Enter category name"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100 @error('cat_name') border-rose-300 focus:border-rose-400 focus:ring-rose-100 @enderror">
                    @error('cat_name')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Category Image
                    </label>
                    <input id="image" type="file" name="image" accept="image/*"
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-rose-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-rose-700 hover:file:bg-rose-100 @error('image') border-rose-300 @enderror">
                    <div id="imagePreviewWrapper"
                        class="mt-3 hidden overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-2">
                        <img id="imagePreview" src="" alt="Selected category image preview"
                            class="h-44 w-full rounded-lg object-cover sm:h-52">
                    </div>
                    <p id="imagePlaceholder" class="mt-2 text-xs text-slate-500">
                        No image selected yet.
                    </p>
                    <p class="mt-1.5 text-xs text-slate-500">Recommended: square image, max 2MB.</p>
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
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-1">
                        Save Category
                    </button>
                    <a href="{{ url('/admin/categories') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewWrapper = document.getElementById('imagePreviewWrapper');
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            if (!imageInput || !imagePreview || !previewWrapper || !imagePlaceholder) return;

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files && event.target.files[0];

                if (!file) {
                    imagePreview.src = '';
                    previewWrapper.classList.add('hidden');
                    imagePlaceholder.classList.remove('hidden');
                    return;
                }

                const previewUrl = URL.createObjectURL(file);
                imagePreview.src = previewUrl;
                previewWrapper.classList.remove('hidden');
                imagePlaceholder.classList.add('hidden');
            });
        });
    </script>

@endsection