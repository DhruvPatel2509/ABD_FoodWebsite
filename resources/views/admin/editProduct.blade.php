@extends('admin.layout')

@section('title', 'Edit Product')
@section('header_title', 'Edit Product')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div
            class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Edit Product</h1>
                    <p class="mt-1 text-sm text-slate-200">Update product details, pricing, media, and stock state.</p>
                </div>
                <a href="{{ url('/admin/products') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-rose-50">
                    Back to Products
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md sm:p-7">
            <form action="{{ url('/admin/products/update/' . $product->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Category</label>
                    <select name="category_id" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->cat_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Product Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Price (₹)</label>
                        <input type="number" name="price" value="{{ $product->price }}" step="0.01" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Discount (%)</label>
                        <input type="number" name="discount_percent" value="{{ $product->discount_percent ?? 0 }}" min="0"
                            max="100" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                    </div>
                </div>

                <div>
                    <label class="mb-3 block text-sm font-semibold text-slate-700">Current Product Gallery</label>

                    <div class="mb-4 flex flex-wrap gap-4 rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4">
                        @forelse($product->images as $img)
                            <div class="group relative">
                                <img src="{{ $img->image_url }}"
                                    class="h-24 w-24 rounded-lg object-cover ring-1 ring-slate-200 transition group-hover:opacity-75">

                                <a href="{{ url('/admin/products/delete-image/' . $img->id) }}"
                                    onclick="return confirm('Remove this image from gallery?')"
                                    class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-rose-600 text-[10px] text-white opacity-0 shadow-lg transition group-hover:opacity-100 hover:bg-rose-700">
                                    ✕
                                </a>
                            </div>
                        @empty
                            <p class="w-full text-center text-xs text-slate-400 italic py-4">No images in gallery yet.</p>
                        @endforelse
                    </div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Add New Images</label>
                    <input id="images" type="file" name="images[]" accept="image/*" multiple
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-rose-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-rose-700 hover:file:bg-rose-100">

                    <div id="previewContainer"
                        class="mt-4 hidden grid grid-cols-3 gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                    </div>

                    <p class="mt-2 text-[10px] text-slate-500">
                        Hold <strong>Ctrl</strong> to select multiple new photos. Leave blank to keep existing gallery.
                    </p>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Availability</label>
                    <select name="availability"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                        <option value="available" {{ $product->availability == 'available' ? 'selected' : '' }}>Available
                        </option>
                        <option value="out_of_stock" {{ $product->availability == 'out_of_stock' ? 'selected' : '' }}>Out of
                            Stock</option>
                    </select>
                </div>

                <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:items-center">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-rose-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-rose-700 sm:w-auto">
                        Update Product
                    </button>
                    <a href="{{ url('/admin/products') }}"
                        class="inline-flex w-full items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 sm:w-auto">
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
                previewContainer.innerHTML = ''; // Clear previous previews
                const files = event.target.files;

                if (files.length > 0) {
                    previewContainer.classList.remove('hidden');

                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const div = document.createElement('div');
                            div.className = "relative";
                            div.innerHTML = `
                                    <img src="${e.target.result}" class="h-20 w-full rounded-lg object-cover ring-1 ring-slate-200">
                                    <span class="absolute top-1 left-1 bg-black/50 text-white text-[8px] px-1 rounded">New</span>
                                `;
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
