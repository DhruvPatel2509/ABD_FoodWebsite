<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect admin users to dashboard
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect('/admin/dashboard');
        }

        $categories = collect();
        $featured = collect();

        if (Schema::hasTable('categories')) {
            $categories = Category::all();
        }

        if (Schema::hasTable('food_items')) {
            // Eager loading images - accessor handles the /images/products/ path
            $featured = FoodItem::with('images')
                ->where('is_featured', 1)
                ->take(8)
                ->get();
        }

        return view('welcome', compact('categories', 'featured'));
    }

    public function show($slug)
    {
        $product = FoodItem::with(['images', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('product-view', compact('product'));
    }

    public function fullMenu(Request $request)
    {
        $query = $request->input('q');
        $categoryId = $request->input('category');
        $sortPrice = $request->input('sort');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Eager load nested images relation
        $categories = Category::with(['foodItems.images'])
            ->when($categoryId, function ($q) use ($categoryId) {
                return $q->where('id', $categoryId);
            })
            ->whereHas('foodItems', function ($subQ) use ($query, $minPrice, $maxPrice) {
                if ($query) {
                    $subQ->where('name', 'LIKE', '%' . $query . '%');
                }
                if ($minPrice) {
                    $subQ->where('price', '>=', $minPrice);
                }
                if ($maxPrice) {
                    $subQ->where('price', '<=', $maxPrice);
                }
            })
            ->get();

        // Apply filters + sorting to the loaded collections
        $categories->each(function ($category) use ($query, $sortPrice, $minPrice, $maxPrice) {
            $items = $category->foodItems;

            if ($query) {
                $items = $items->filter(fn($i) => stripos($i->name, $query) !== false);
            }

            if ($minPrice) {
                $items = $items->where('price', '>=', $minPrice);
            }

            if ($maxPrice) {
                $items = $items->where('price', '<=', $maxPrice);
            }

            if ($sortPrice === 'asc') {
                $items = $items->sortBy('price');
            } elseif ($sortPrice === 'desc') {
                $items = $items->sortByDesc('price');
            }

            $category->setRelation('foodItems', $items->values());
        });

        $allCategories = Category::all();

        return view('full-menu', compact('categories', 'allCategories'));
    }

    public function search(Request $request)
    {
        $query = $request->q;

        // Returns JSON with images relation included
        return FoodItem::with('images')
            ->where('name', 'LIKE', "%$query%")
            ->limit(10)
            ->get([
                'id',
                'name',
                'price',
                'original_price',
                'slug'
            ]);
    }
}