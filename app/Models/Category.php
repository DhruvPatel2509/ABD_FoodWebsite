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
