<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CityScope implements Scope
{
    public function apply(Builder $builder, Model $model)
{
    if (!auth()->check()) {
        return;
    }

    // 👇 إذا المستخدم admin → لا تطبق فلترة
    if (auth()->user()->type === 'admin') {
        return;
    }

    if (auth()->user()->city_id) {
        $builder->where('city_id', auth()->user()->city_id);
    }
}
}