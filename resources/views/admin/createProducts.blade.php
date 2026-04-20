@extends('admin.layout')

@section('title', 'Create Product')
@section('header_title', 'Create Product')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div
            class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Create Product</h1>
                    <p class="mt-1 text-sm text-slate-200">Add product details, pricing, discount, and availability.</p>
                </div>
                <a href="{{ url('/admin/products') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-rose-50">
                    Back to Products
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md sm:p-7">
            <form action="{{ url('/admin/products/store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Select Category</label>
                    <select name="category_id" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                        <option value="">-- Choose Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->cat_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Price (₹)</label>
                        <input type="number" name="price" value="{{ old('price') }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Discount (%)</label>
                        <input type="number" name="discount_percent" value="{{ old('discount_percent', 0) }}" min="0"
                            max="100"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Product Images</label>
                    <input id="images" type="file" name="images[]" accept="image/*" multiple required
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-rose-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-rose-700 hover:file:bg-rose-100">

                    <div id="previewContainer"
                        class="mt-3 hidden grid grid-cols-3 gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                    </div>
                    <p class="mt-1 text-xs text-slate-500">You can select multiple images at once.</p>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Availability</label>
                    <select name="availability"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                        <option value="available" {{ old('availability', 'available') == 'available' ? 'selected' : '' }}>
                            Available</option>
                        <option value="out_of_stock" {{ old('availability') == 'out_of_stock' ? 'selected' : '' }}>Out of
                            Stock</option>
                    </select>
                </div>

                <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:items-center">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700">
                        Save Product
                    </button>
                    <a href="{{ url('/admin/products') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imagesInput = document.getElementById('images');
            const previewContainer = document.getElementById('previewContainer');

            if (!imagesInput || !previewContainer) return;

            imagesInput.addEventListener('change', function (event) {
                previewContainer.innerHTML = ''; // Clear existing
                const files = event.target.files;

                if (files.length > 0) {
                    previewContainer.classList.remove('hidden');

                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const div = document.createElement('div');
                            div.className = "h-24 w-full overflow-hidden rounded-lg border border-slate-200 bg-white";
                            div.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover">`;
                            previewContainer.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        });
    </script>
@endsection