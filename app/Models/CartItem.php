<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'meal_id',
        'quantity',
        'price'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'cart_item_addon')
            ->withPivot('price')
            ->withTimestamps();
    }
}
