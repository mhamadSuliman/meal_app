<?php

namespace App\Models;

use App\Models\Scopes\CityScope;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name','image','rating','city_id','user_id'];

    public function meals(){
        return $this->hasMany(Meal::class);
    }
    public function resowner(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function addons(){
    return $this->hasMany(Addon::class);
}
public function city()
{
    return $this->belongsTo(City::class);
}


protected static function booted()
{
    static::addGlobalScope(new CityScope);
}
public function carts()
{
    return $this->hasMany(Cart::class);
}

public function orders()
{
    return $this->hasMany(Order::class);
}
}

