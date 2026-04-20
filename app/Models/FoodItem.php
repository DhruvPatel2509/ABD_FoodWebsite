<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'image',
        'is_featured',
        'availability',
        'discount_percent',
    ];

    /**
     * Get the category that owns the food item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the multiple angle images for the food item.
     */
    public function images()
    {
        return $this->hasMany(FoodImage::class);
    }

    /**
     * Accessor for the main product image URL.
     * Maps to /images/products/
     */
    /**
     * Accessor for the main product image URL.
     * Pulls the FIRST image from the related FoodImage model.
     */
    public function getImageUrlAttribute(): string
    {
        // 1. Get the first record from the 'images' relationship (FoodImage model)
        $firstImageRecord = $this->images->first();

        // 2. If a record exists in the food_images table
        if ($firstImageRecord) {
            // We call 'image_url' which is the accessor we defined in FoodImage model
            // That accessor already handles the '/images/products/' pathing
            return $firstImageRecord->image_url;
        }

        // 3. Fallback if no images are found in the gallery at all
        return asset('images/products/default-food.png');
    }
}