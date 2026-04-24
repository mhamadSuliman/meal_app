<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Meal;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;

class AdminRestaurantController extends Controller
{
    public function create()
{
    $owners = User::where('type', 'restaurant_owner')->get();
    $cities = City::all();

    return view('admin.create_restaurant', compact('owners', 'cities'));
}

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'user_id' => 'required',
        'city_id' => 'required'
    ]);

    Restaurant::create([
        'name' => $request->name,
        'user_id' => $request->user_id,
        'city_id' => $request->city_id
    ]);

    return redirect('/dashboard');
}

    public function destroy($id)
    {
        Restaurant::findOrFail($id)->delete();

        return back();
    }

    public function index(Request $request)
{
    $query = Restaurant::query();

    if ($request->filled('city_id')) {
        $query->where('city_id', $request->city_id);
    }

    $restaurants = $query->latest()->get();

    $cities = City::all(); // 👈 هذا المهم

    return view('restaurants.index', compact('restaurants', 'cities'));
}

    public function show($id)
    {
        $restaurant = Restaurant::with('meals')->findOrFail($id);
        return view('restaurants.show', compact('restaurant'));
    }
    public function storeMeal(Request $request, $restaurantId)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'description' => 'nullable',
        'type' => 'required|string'
    ]);

   Meal::create([
    'restaurant_id' => $restaurantId,
    'name' => $request->name,
    'price' => $request->price,
    'description' => $request->description,
    'type' => $request->type// 👈 أضفها
]);

    return back()->with('success', 'Meal added successfully');
}

public function updateMeal(Request $request, $mealId)
{
    $meal = Meal::findOrFail($mealId);

    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'description' => 'nullable'
    ]);

    $meal->update($request->only(['name','price','description']));

    return back()->with('success', 'Meal updated successfully');
}

public function deleteMeal($mealId)
{
    Meal::findOrFail($mealId)->delete();

    return back()->with('success', 'Meal deleted successfully');
}

public function edit($id)
{
    $restaurant = Restaurant::findOrFail($id);
    $cities = City::all();
    $owners = User::where('type', 'restaurant_owner')->get();

    return view('admin.edit_restaurant', compact('restaurant','cities','owners'));
}

public function update(Request $request, $id)
{
    $restaurant = Restaurant::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'city_id' => 'required',
        'user_id' => 'required'
    ]);

    $restaurant->update([
        'name' => $request->name,
        'city_id' => $request->city_id,
        'user_id' => $request->user_id
    ]);

    return redirect('/restaurants')->with('success','تم التعديل بنجاح');
}


   
}