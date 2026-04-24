<?php

namespace App\Models;

use App\Models\Scopes\MealCityScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    protected static function booted()
{
    static::addGlobalScope(new MealCityScope);
}
    protected $fillable = ['restaurant_id','name','price','rating','image','type','description'];

    public function restaurant(){
        return $this->BelongsTo(Restaurant::class,'restaurant_id');
    }
    public function addons(){
        return $this->belongsToMany(Addon::class,'meal_addon');
    }
}
