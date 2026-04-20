<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'status'];

    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }

    public function getCatNameAttribute(): string
    {
        return $this->attributes['name'] ?? '';
    }

    public function setCatNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;
    }

    // app/Models/Category.php

    public function getImageUrlAttribute(): string
    {
        $image = $this->image;

        // 1. If no image is set, return a placeholder
        if (!$image) {
            return asset('images/categories/default.png');
        }

        // 2. If it's already a full URL (like an external link), return it as is
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        // 3. NEW LOGIC: Prepend your specific category path
        // This turns "pizza.jpg" into "http://yourdomain.com/images/categories/pizza.jpg"
        return asset('images/categories/' . $image);
    }
}
