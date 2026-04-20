<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodImage extends Model
{
    use HasFactory;

    protected $fillable = ['food_item_id', 'image_path'];

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }

    /**
     * Accessor for the product image URL.
     * Maps the filename in 'image_path' to the /images/products/ folder.
     */
    public function getImageUrlAttribute(): ?string
    {
        $path = $this->image_path;

        if (!$path) {
            return asset('images/products/default.png'); // Fallback if empty
        }

        // If it's already a full URL (like an external link), return it as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Prepend your specific product directory
        return asset('images/products/' . $path);
    }
}