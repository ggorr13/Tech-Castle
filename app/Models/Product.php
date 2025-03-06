<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'type',
        'weight',
        'width',
        'height',
        'length',
        'download_url',
        'created_at',
        'updated_at',
    ];

    public function getPriceWithTaxAttribute(): float
    {
        // Assuming a 20% tax rate
        return isset($this->attributes['price']) ? round($this->attributes['price'] * 1.2, 2) : 0;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cart_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity', 'price_with_tax')
            ->withTimestamps();
    }
}
