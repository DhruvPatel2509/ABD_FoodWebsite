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

    public function getImageUrlAttribute(): ?string
    {
        $image = $this->image;

        if (!$image) {
            return null;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        return asset($image);
    }
}
