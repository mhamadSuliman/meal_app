<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'meal_id',
        'quantity',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'order_item_addon')
            ->withPivot('price')
            ->withTimestamps();
    }
}
