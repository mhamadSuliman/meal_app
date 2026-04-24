<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Addon;
use App\Models\Restaurant;

class AddonPolicy
{
    // إضافة addon
    public function create(User $user, Restaurant $restaurant)
    {
        return $user->type === 'admin'
            || $restaurant->user_id === $user->id;
    }

    // تعديل
    public function update(User $user, Addon $addon)
    {
        return $user->type === 'admin'
            || $addon->restaurant->user_id === $user->id;
    }

    // حذف
    public function delete(User $user, Addon $addon)
    {
        return $user->type === 'admin'
            || $addon->restaurant->user_id === $user->id;
    }
}