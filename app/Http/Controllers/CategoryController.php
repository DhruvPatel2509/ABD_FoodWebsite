<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
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
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $imageName);
            $imagePath = 'uploads/' . $imageName;
        }

        Category::create([
            'name' => $validated['cat_name'],
            'slug' => $this->uniqueSlug($validated['cat_name']),
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect('/admin/categories')->with('success', 'Saved!');
    }

    public function deleteCategory(int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        if ($category->image && !str_starts_with($category->image, 'http') && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        return redirect('/admin/categories')->with('success', 'Category deleted successfully!');
    }

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

    public function updateCategory(Request $request, int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'cat_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $category->name = $validated['cat_name'];
        $category->slug = $this->uniqueSlug($validated['cat_name'], $category->id);
        $category->status = $validated['status'];

        if ($request->hasFile('image')) {
            if ($category->image && !str_starts_with($category->image, 'http') && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $imageName);
            $category->image = 'uploads/' . $imageName;
        }

        $category->save();

        return redirect('/admin/categories')->with('success', 'Category Updated Successfully!');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $count = 1;

        while (
            Category::query()
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
