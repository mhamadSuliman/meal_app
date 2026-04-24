<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = ['name','image','price','is_active','type','restaurant_id'];
    public function meals(){
        return $this->belongsToMany(Meal::class,'meal_addon');
    }
    public function restaurant(){
    return $this->belongsTo(Restaurant::class);
}
}
