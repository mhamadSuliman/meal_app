<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AddonCityScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
{
    if (!auth()->check()) return;

    if (auth()->user()->type === 'admin') return;

    $builder->whereHas('restaurant', function ($q) {
        $q->where('city_id', auth()->user()->city_id);
    });
}
}
