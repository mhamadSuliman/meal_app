<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    // عرض الطلب
    public function view(User $user, Order $order)
    {
        return $user->id === $order->user_id
            || $user->type === 'admin'
            || $order->restaurant->user_id === $user->id;
    }

    // عرض كل الطلبات
    public function viewAny(User $user)
    {
        return true;
    }

    // تغيير الحالة (owner أو admin فقط)
    public function update(User $user, Order $order)
    {
        return $user->type === 'admin'
            || $order->restaurant->user_id === $user->id;
    }
}
