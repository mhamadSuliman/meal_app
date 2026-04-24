<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;

class RestaurantPolicy
{
    // ✅ فقط الأدمن ينشئ مطعم
    public function create(User $user)
    {
        return $user->type === 'admin';
    }

    // ✅ عرض (اختياري - حسب المدينة أو مفتوح)
    public function view(User $user, Restaurant $restaurant)
    {
        return true; // أو حسب city إذا بدك
    }

    // ✅ تعديل (admin أو صاحب المطعم)
    public function update(User $user, Restaurant $restaurant)
    {
        return $user->type === 'admin'
            || $restaurant->user_id === $user->id;
    }

    // ✅ حذف (admin أو صاحب المطعم)
    public function delete(User $user, Restaurant $restaurant)
    {
        return $user->type === 'admin'
            || $restaurant->user_id === $user->id;
    }
}