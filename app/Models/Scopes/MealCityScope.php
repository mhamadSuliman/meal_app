<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class MealCityScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (!Auth::check()) {
            return;
        }

        // 👑 admin يشوف الكل
        if (Auth::user()->type === 'admin') {
            return;
        }

        // 🌍 باقي المستخدمين حسب المدينة
        if (Auth::user()->city_id) {
            $builder->whereHas('restaurant', function ($q) {
                $q->where('city_id', Auth::user()->city_id);
            });
        }
    }
}