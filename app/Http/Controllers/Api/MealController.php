<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    use AuthorizesRequests;
public function byRestaurant(Restaurant $restaurant, Request $request)
{
    $query = Meal::where('restaurant_id', $restaurant->id)
        ->with(['restaurant', 'addons']);

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('price_min')) {
        $query->where('price', '>=', $request->price_min);
    }

    if ($request->filled('price_max')) {
        $query->where('price', '<=', $request->price_max);
    }

    return response()->json(
        $query->latest()->paginate(10)
    );
}
    //عرض وجبات المطاعم
  public function index()
{
    return Meal::with(['restaurant', 'addons'])
        ->latest()
        ->paginate(10);
}
    //عرض وجبات مطعم
   public function show($restaurant_id, $meal_id)
{
    $meal = Meal::with(['restaurant', 'addons'])
        ->where('id', $meal_id)
        ->where('restaurant_id', $restaurant_id)
        ->firstOrFail();

    return new MealResource($meal);
}
  

public function store(StoreMealRequest $request, $restaurant_id)
{
    $restaurant = Restaurant::findOrFail($restaurant_id);

    $this->authorize('create', [Meal::class, $restaurant]);

    $meal = DB::transaction(function () use ($request, $restaurant_id) {

        $existingMeal = Meal::where('restaurant_id', $restaurant_id)
            ->where('name', $request->name)
            ->lockForUpdate()
            ->first();

        if ($existingMeal) {
            throw new \Exception('الوجبة موجودة مسبقاً');
        }

        $data = $request->validated();
        $data['restaurant_id'] = $restaurant_id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('meals', 'public');
        }

        $meal = Meal::create($data);

        if ($request->has('addons')) {
            $meal->addons()->sync($request->addons);
        }

        return $meal;
    });

    return new MealResource($meal);
}
//تعديل وجبة
public function update(UpdateMealRequest $request, $restaurant_id, $meal_id)
{
    $meal = Meal::with('restaurant')
        ->where('id', $meal_id)
        ->where('restaurant_id', $restaurant_id)
        ->firstOrFail();

    $this->authorize('update', $meal);

    $meal = DB::transaction(function () use ($request, $meal) {

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('meals', 'public');
        }

        $meal->update($data);

        if ($request->has('addons')) {
            $meal->addons()->sync($request->addons);
        }

        return $meal;
    });

    return new MealResource($meal);
}
    //حذف وجبة

public function destroy($restaurant_id, $meal_id)
{
    $meal = Meal::with('restaurant')
        ->where('id', $meal_id)
        ->where('restaurant_id', $restaurant_id)
        ->firstOrFail();

    $this->authorize('delete', $meal);

    $meal->delete();

    return response()->json([
        'message' => 'Meal deleted successfully.'
    ]);
}

}
