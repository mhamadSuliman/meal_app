<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   
public function index()
{
    $user = auth()->user();

    // 👑 Admin

    

    if ($user->type === 'admin') {

    // 🧾 الطلبات المدفوعة فقط
    $orders = Order::where('paid', true)->get();

    // 💰 إجمالي المبيعات
    $totalSales = $orders->sum('final_price');

    // 💸 عمولة التطبيق (10%)
    $commission = $totalSales * 0.10;

    // 💵 أرباح المطاعم
    $restaurantsRevenue = $totalSales - $commission;

    // 📊 عدد الطلبات
    $totalOrders = $orders->count();

    // 👥 عدد المستخدمين
    $usersCount = User::count();

    // 🍔 عدد المطاعم
    $restaurantsCount = Restaurant::count();

    $restaurants = Restaurant::latest()->get();

     $chartData = Order::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(final_price) as total')
    )
    ->where('paid', true)
    ->groupBy('date')
    ->orderBy('date')
    ->get();

    $topMeals = DB::table('order_items')
    ->select('meal_id', DB::raw('SUM(quantity) as total'))
    ->groupBy('meal_id')
    ->orderByDesc('total')
    ->limit(5)
    ->get();

    $query = Order::query();

if (request('status')) {
    $query->where('status', request('status'));
}

$orders = $query->get();
    

    return view('dashboard.admin', compact(
        'totalSales',
        'commission',
        'restaurantsRevenue',
        'totalOrders',
        'usersCount',
        'restaurantsCount',
        'orders',
        'restaurants',
        'chartData',
        'topMeals'
    ));

}



    // 🍔 Restaurant Owner
    if ($user->type === 'restaurant_owner') {

    $restaurant = \App\Models\Restaurant::where('user_id', $user->id)->first();

    // 📦 كل الطلبات المدفوعة
    $orders = Order::where('restaurant_id', $restaurant->id)
        ->where('paid', true)
        ->get();

    // 💰 إجمالي الأرباح
    $totalRevenue = $orders->sum('final_price');

    // 📊 عدد الطلبات
    $totalOrders = $orders->count();

    // 📅 اليوم
    $today = Carbon::today();

    $todayOrders = Order::where('restaurant_id', $restaurant->id)
        ->where('paid', true)
        ->whereDate('created_at', $today)
        ->get();

    $todayRevenue = $todayOrders->sum('final_price');

    $meals = \App\Models\Meal::where('restaurant_id', $restaurant->id)->get();

    return view('dashboard.owner', compact(
        'restaurant',
        'meals',
        'totalRevenue',
        'totalOrders',
        'todayRevenue',
        'todayOrders'
    ));
}

    abort(403);
}
}