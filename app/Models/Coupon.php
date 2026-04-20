<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type', // 'fixed' or 'percent'
        'value',
        'is_active',
    ];

    /**
     * Calculate the discount amount.
     */
    public function calculateDiscount($total)
    {
        if (!$this->is_active) {
            return 0;
        }

        if ($this->type === 'percent') {
            return ($total * $this->value) / 100;
        }

        return $this->value; // fixed
    }
}
