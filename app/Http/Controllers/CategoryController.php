<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    // Path constant for easy maintenance
    private const IMAGE_PATH = 'images/categories/';

    public function show(string $slug): View
    {
        $category = Category::with('foodItems')->where('slug', $slug)->firstOrFail();
        $foodItems = $category->foodItems;

        return view('category-items', compact('category', 'foodItems'));
    }

    public function allCategories(): View
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cat_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5020'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '-' . Str::random(5) . '.' . $request->file('image')->extension();
            // Moves to public/images/categories/
            $request->file('image')->move(public_path(self::IMAGE_PATH), $imageName);
        }

        Category::create([
            'name' => $validated['cat_name'],
            'slug' => $this->uniqueSlug($validated['cat_name']),
            'image' => $imageName, // Only store the filename
            'status' => $validated['status'],
        ]);

        return redirect('/admin/categories')->with('success', 'Category Saved!');
    }

    public function updateCategory(Request $request, int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'cat_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB limit
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Update attributes
        $category->name = $validated['cat_name'];
        $category->status = $validated['status'];

        // Ensure uniqueSlug handles the current ID to avoid "slug already taken" errors
        $category->slug = $this->uniqueSlug($validated['cat_name'], $id);

        if ($request->hasFile('image')) {
            // 1. Delete old image
            if ($category->image) {
                $this->deleteOldImage($category->image);
            }

            // 2. Process new image
            $file = $request->file('image');
            $imageName = time() . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();

            // 3. Move file
            $file->move(public_path(self::IMAGE_PATH), $imageName);

            // 4. Update model attribute
            $category->image = $imageName;
        }

        $category->save();

        return redirect('/admin/categories')->with('success', 'Category Updated Successfully!');
    }

    public function deleteCategory(int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $this->deleteOldImage($category->image);
        $category->delete();

        return redirect('/admin/categories')->with('success', 'Category deleted successfully!');
    }

    /**
     * Helper to handle file cleanup
     */
    private function deleteOldImage(?string $fileName): void
    {
        if ($fileName) {
            $fullPath = public_path(self::IMAGE_PATH . $fileName);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }

    // --- Standard Methods Remaining ---

    public function editCategory(int $id): View
    {
        $category = Category::findOrFail($id);
        return view('admin.editCategories', compact('category'));
    }

    public function showCategory(int $id): View
    {
        $category = Category::findOrFail($id);
        return view('admin.showCategory', compact('category'));
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $count = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}