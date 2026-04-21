<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoodImage;
use App\Models\FoodItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    // Path constant for easy maintenance
    private const PRODUCT_IMAGE_PATH = 'images/products/';

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
            'image' => null, // Will be updated below
        ]);

        if ($request->hasFile('images')) {
            $firstImageName = null;

            foreach ($request->file('images') as $file) {
                $imageName = time() . '_' . Str::random(5) . '.' . $file->extension();

                // Move to public/images/products/
                $file->move(public_path(self::PRODUCT_IMAGE_PATH), $imageName);

                $firstImageName ??= $imageName;

                FoodImage::create([
                    'food_item_id' => $product->id,
                    'image_path' => $imageName, // Only store the filename
                ]);
            }

            $product->update(['image' => $firstImageName]);
        }

        return redirect('/admin/products')->with('success', 'Product and images added successfully!');
    }

    public function updateProduct(Request $request, int $id): RedirectResponse
    {
        // 1. Find the product or fail
        $product = FoodItem::findOrFail($id);

        // 2. Validate the incoming request
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'original_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'], // This is the Selling Price
            'is_featured' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
        ]);

        // 3. Calculate Discount Percentage automatically for the DB
        $discountPercent = 0;
        $orig = (float) $validated['original_price'];
        $sell = (float) $validated['price'];

        if ($orig > 0 && $orig > $sell) {
            $discountPercent = (($orig - $sell) / $orig) * 100;
        }

        // 4. Update the FoodItem record
        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $sell,
            'original_price' => $orig,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            // REMOVED 'discount_percent' line entirely
        ]);

        // 5. Handle Multiple Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Generate unique name
                $imageName = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();

                // Move to public/images/products
                $file->move(public_path('images/products/'), $imageName);

                // Create record in the related food_images table
                // Ensure you have a FoodImage model and relationship
                $product->images()->create([
                    'image_path' => $imageName,
                ]);
            }
        }

        // 6. Redirect with Success Message
        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(int $id): RedirectResponse
    {
        $product = FoodItem::with('images')->findOrFail($id);

        try {
            // Delete all associated files first
            foreach ($product->images as $img) {
                $this->removePhysicalFile($img->image_path);
            }

            // Delete the main thumbnail if it's different/standalone
            $this->removePhysicalFile($product->image);

            $product->delete(); // This should also cascade delete FoodImages if set in DB

            return redirect('/admin/products')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect('/admin/products')->with('error', 'Cannot delete product! It may be linked to active orders.');
        }
    }

    public function deleteImage(int $id): RedirectResponse
    {
        $image = FoodImage::findOrFail($id);
        $foodItem = $image->foodItem;
        $fileName = $image->image_path;

        $this->removePhysicalFile($fileName);
        $image->delete();

        // If we deleted the image that was set as the main thumbnail, update it to the next available one
        if ($foodItem && $foodItem->image === $fileName) {
            $nextImage = $foodItem->images()->first();
            $foodItem->update([
                'image' => $nextImage ? $nextImage->image_path : null,
            ]);
        }

        return redirect()->back()->with('success', 'Image removed!');
    }

    /**
     * Helper to clean up files from public/images/products/
     */
    private function removePhysicalFile(?string $fileName): void
    {
        if ($fileName && !str_starts_with($fileName, 'http')) {
            $fullPath = public_path(self::PRODUCT_IMAGE_PATH . $fileName);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }

    // --- Pricing and Slug logic remains the same ---

    private function resolvePricing(float $enteredPrice, int $discountPercent): array
    {
        $originalPrice = round($enteredPrice, 2);
        $currentPrice = ($discountPercent > 0)
            ? round($originalPrice * ((100 - $discountPercent) / 100), 2)
            : $originalPrice;

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
        while (FoodItem::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        return $slug;
    }

    public function editProduct(int $id): View
    {
        $product = FoodItem::with('images')->findOrFail($id);
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('admin.editProduct', compact('product', 'categories'));
    }
}