<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class OwnerMealController extends Controller
{
  public function create()
{
    $user = auth()->user();

    $restaurant = Restaurant::where('user_id', $user->id)->first();

    if (!$restaurant) {
        return redirect('/dashboard')->with('error', 'ما عندك مطعم');
    }

    $addons = Addon::where('restaurant_id', $restaurant->id)->get();

    // 👇 ضيف هاد
    $meals = $restaurant->meals;

    // (إذا لسا عم تستخدمهم)
    $todayOrders = $restaurant->orders()->whereDate('created_at', today())->get();
    $todayRevenue = $todayOrders->sum('total_price');

    $totalOrders = $restaurant->orders()->count();
    $totalRevenue = $restaurant->orders()->sum('total_price');

    return view('owner.create_meal_form', compact(
        'restaurant',
        'addons',
        'meals',
        'todayOrders',
        'todayRevenue',
        'totalOrders',
        'totalRevenue'
    ));
}

   public function store(Request $request)
{
    $user = auth()->user();

    $restaurant = \App\Models\Restaurant::where('user_id', $user->id)->first();

    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'type' => 'required',
        'price' => 'required|numeric',
        'image' => 'nullable|image',
        'addons' => 'nullable|array'
    ]);

    // 📸 رفع الصورة
    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('meals', 'public');
    }

    // ✅ إنشاء الوجبة
    $meal = \App\Models\Meal::create([
        'name' => $request->name,
        'description' => $request->description,
        'type' => $request->type,
        'price' => $request->price,
        'image' => $imagePath,
        'restaurant_id' => $restaurant->id
    ]);

    // 🔗 ربط الإضافات
    if ($request->has('addons')) {
        $meal->addons()->sync($request->addons);
    }

    return redirect('/dashboard');
}

    public function destroy($id)
    {
        Meal::findOrFail($id)->delete();

        return back();
    }
}