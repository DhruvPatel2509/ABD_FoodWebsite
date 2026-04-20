<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoodImage;
use App\Models\FoodItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function allProducts(): View
    {
        $products = FoodItem::with(['category', 'images'])->latest()->get();

        return view('admin.product', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('admin.createProducts', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'availability' => ['required', 'in:available,out_of_stock'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:4096'],
        ]);

        $pricing = $this->resolvePricing(
            (float) $validated['price'],
            (int) ($validated['discount_percent'] ?? 0)
        );

        $product = FoodItem::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $pricing['price'],
            'original_price' => $pricing['original_price'],
            'availability' => $validated['availability'],
            'discount_percent' => $pricing['discount_percent'],
            'image' => null,
        ]);

        if ($request->hasFile('images')) {
            $firstImagePath = null;

            foreach ($request->file('images') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('uploads/products'), $name);
                $storedPath = 'uploads/products/' . $name;

                $firstImagePath ??= $storedPath;

                FoodImage::create([
                    'food_item_id' => $product->id,
                    'image_path' => $storedPath,
                ]);
            }

            $product->update(['image' => $firstImagePath]);
        }

        return redirect('/admin/products')->with('success', 'Product and images added successfully!');
    }

    public function deleteProduct(int $id): RedirectResponse
    {
        $product = FoodItem::with('images')->find($id);

        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found!');
        }

        try {
            $imagePaths = $product->images->pluck('image_path')->all();
            $mainImage = $product->image;

            $product->delete();

            foreach ($imagePaths as $path) {
                if ($path && !str_starts_with($path, 'http') && file_exists(public_path($path))) {
                    unlink(public_path($path));
                }
            }

            if ($mainImage && !str_starts_with($mainImage, 'http') && file_exists(public_path($mainImage))) {
                unlink(public_path($mainImage));
            }

            return redirect('/admin/products')->with('success', 'Product and images deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/admin/products')->with('error', 'Cannot delete! This product is linked to existing customer orders. Try marking it as "Out of Stock" instead.');
        }
    }

    public function editProduct(int $id): View|RedirectResponse
    {
        $product = FoodItem::with('images')->find($id);
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found!');
        }

        return view('admin.editProduct', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, int $id): RedirectResponse
    {
        $product = FoodItem::find($id);

        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found!');
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'availability' => ['required', 'in:available,out_of_stock'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
        ]);

        $pricing = $this->resolvePricing(
            (float) $validated['price'],
            (int) ($validated['discount_percent'] ?? 0)
        );

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug($validated['name'], $product->id),
            'description' => $validated['description'] ?? null,
            'price' => $pricing['price'],
            'original_price' => $pricing['original_price'],
            'availability' => $validated['availability'],
            'discount_percent' => $pricing['discount_percent'],
        ]);

        if ($request->hasFile('images')) {
            $firstNewImagePath = null;

            foreach ($request->file('images') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('uploads/products'), $name);
                $storedPath = 'uploads/products/' . $name;

                $firstNewImagePath ??= $storedPath;

                FoodImage::create([
                    'food_item_id' => $product->id,
                    'image_path' => $storedPath,
                ]);
            }

            if ($firstNewImagePath && !$product->image) {
                $product->update(['image' => $firstNewImagePath]);
            }
        }

        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }

    public function deleteImage(int $id): RedirectResponse
    {
        $image = FoodImage::find($id);

        if (!$image) {
            return redirect()->back()->with('error', 'Image not found!');
        }

        $foodItem = $image->foodItem;
        $imagePath = $image->image_path;

        if ($imagePath && !str_starts_with($imagePath, 'http') && file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }

        $image->delete();

        if ($foodItem && $foodItem->image === $imagePath) {
            $foodItem->update([
                'image' => optional($foodItem->images()->first())->image_path,
            ]);
        }

        return redirect()->back()->with('success', 'Image removed!');
    }

    private function resolvePricing(float $enteredPrice, int $discountPercent): array
    {
        $originalPrice = round($enteredPrice, 2);
        $currentPrice = $originalPrice;

        if ($discountPercent > 0) {
            $currentPrice = round($originalPrice * ((100 - $discountPercent) / 100), 2);
        }

        return [
            'price' => $currentPrice,
            'original_price' => $discountPercent > 0 ? $originalPrice : null,
            'discount_percent' => $discountPercent,
        ];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $count = 1;

        while (
            FoodItem::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
