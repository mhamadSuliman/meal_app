<?php

namespace App\Policies;

use App\Models\Meal;
use App\Models\User;
use App\Models\Restaurant;

class MealPolicy
{
    // إضافة وجبة
  public function create(User $user, Restaurant $restaurant)
{
    return $user->type === 'admin'
        || ($user->type === 'restaurant_owner' && $restaurant->user_id === $user->id);
}

    // تعديل وجبة
    public function update(User $user, Meal $meal)
    {
        return $user->type === 'admin'
            || $meal->restaurant->user_id === $user->id;
    }

    // حذف وجبة
    public function delete(User $user, Meal $meal)
    {
        return $user->type === 'admin'
            || $meal->restaurant->user_id === $user->id;
    }
}