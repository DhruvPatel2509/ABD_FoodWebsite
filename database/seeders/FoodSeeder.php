<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\FoodItem;
use App\Models\FoodImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class FoodSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        FoodImage::truncate();
        FoodItem::truncate();
        Category::truncate();

        $menuData = [
            'ABD Punjabi Special' => [
                'banner' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=800',
                'items' => [
                    ['name' => 'Dal Makhani (Slow Cooked)', 'img' => 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=600'],
                    ['name' => 'Paneer Butter Masala', 'img' => 'https://images.unsplash.com/photo-1603894584134-f6c043e6209e?w=600'],
                    ['name' => 'Amritsari Kulcha with Chole', 'img' => 'https://images.unsplash.com/photo-1626132646529-500637532537?w=600'],
                    ['name' => 'Sarson Da Saag & Makki Di Roti', 'img' => 'https://images.unsplash.com/photo-1631452180519-c014fe946bc7?w=600'],
                    ['name' => 'Malai Kofta Curry', 'img' => 'https://images.unsplash.com/photo-1645177623570-ad4c2a5789f2?w=600'],
                    ['name' => 'Shahi Kadhai Paneer', 'img' => 'https://images.unsplash.com/photo-1631452180539-960204730628?w=600'],
                ],
                'angles' => ['https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=400', 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=400', 'https://images.unsplash.com/photo-1603894584134-f6c043e6209e?w=400']
            ],
            'ABD Veg Biryani' => [
                'banner' => 'https://images.unsplash.com/photo-1563379091339-03b21bc4a4f8?w=800',
                'items' => [
                    ['name' => 'Hyderabadi Veg Dum Biryani', 'img' => 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=600'],
                    ['name' => 'Lucknowi Soya Chaap Biryani', 'img' => 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?w=600'],
                    ['name' => 'Paneer Tikka Biryani', 'img' => 'https://images.unsplash.com/photo-1563379091339-03b21bc4a4f8?w=600'],
                ],
                'angles' => ['https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=400', 'https://images.unsplash.com/photo-1563379091339-03b21bc4a4f8?w=400', 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?w=400']
            ],
            'ABD Desserts' => [
                'banner' => 'https://images.unsplash.com/photo-1582716401301-b2407dc7563d?w=800',
                'items' => [
                    ['name' => 'Saffron Rasmalai (2 pcs)', 'img' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=600'],
                    ['name' => 'Hot Gulab Jamun with Rabri', 'img' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=600'],
                    ['name' => 'Eggless Chocolate Lava Cake', 'img' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=600'],
                    ['name' => 'Moong Dal Halwa (Ghee Special)', 'img' => 'https://images.unsplash.com/photo-1601050690597-df056fb01793?w=600'],
                    ['name' => 'Kesar Pista Kulfi', 'img' => 'https://images.unsplash.com/photo-1505394033323-424ebb441fe3?w=600'],
                    ['name' => 'Warm Brownie with Vanilla', 'img' => 'https://images.unsplash.com/photo-1589119634735-121045ef3bc8?w=600'],
                ],
                'angles' => ['https://images.unsplash.com/photo-1582716401301-b2407dc7563d?w=400', 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400', 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=400']
            ],
            'ABD South Indian' => [
                'banner' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=800',
                'items' => [
                    ['name' => 'Cheese Corn Dosa', 'img' => 'https://images.unsplash.com/photo-1668236543090-82eba5ee5976?w=600'],
                    ['name' => 'Onion Rava Masala Dosa', 'img' => 'https://images.unsplash.com/photo-1630383249896-424e482df921?w=600'],
                ],
                'angles' => ['https://images.unsplash.com/photo-1668236543090-82eba5ee5976?w=400', 'https://images.unsplash.com/photo-1630383249896-424e482df921?w=400']
            ],
            'ABD Beverages' => [
                'banner' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=800',
                'items' => [
                    ['name' => 'Fresh Mint Mojito', 'img' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=600'],
                    ['name' => 'Thick Mango Lassi', 'img' => 'https://images.unsplash.com/photo-1544145945-f904253d0c71?w=600'],
                ],
                'angles' => ['https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=400', 'https://images.unsplash.com/photo-1544145945-f904253d0c71?w=400']
            ]
        ];

        foreach ($menuData as $catName => $data) {
            $category = Category::create([
                'name' => $catName,
                'slug' => Str::slug($catName),
                'image' => $data['banner']
            ]);

            foreach ($data['items'] as $item) {
                $food = FoodItem::create([
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name'] . '-' . rand(100, 999)),
                    'description' => "Experience the authentic taste of " . $item['name'] . ". Made with 100% vegetarian ingredients in the ABD kitchen.",
                    'price' => rand(180, 480),
                    'image' => $item['img'],
                    'is_featured' => 1,
                ]);

                foreach ($data['angles'] as $angleUrl) {
                    FoodImage::create([
                        'food_item_id' => $food->id,
                        'image_path' => $angleUrl
                    ]);
                }
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}