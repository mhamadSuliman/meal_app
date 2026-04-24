<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class RestaurantController extends Controller
{
    use AuthorizesRequests;
    //الفلترة والبحث 
    public function byresname(Request $request){
        $query = Restaurant::query();
        if($request->filled('search')){
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if($request->filled('rating')){
            $query->where('rating', '>=', $request->rating);
        }
        return response()->json(
        $query->latest()->paginate(10)
    );
    }
    //عرض جميع المطاعم
   public function index()
{
    return Restaurant::with('city')->get();
}

    //لعرض اعلى 5 مطاعم تقييما 
    //لاتنسى لازم طبق شي اسمو حسب المدينة بحيث اذا انت ضمن دمشق يطلعلك اعلى المطاعم تقييما ضمن دمشق فقط وليس باقي المحافظات او الدول 
    
    public function topRated()
{
    return Restaurant::where('rating', '>', 0)
        ->orderByDesc('rating')
        ->limit(5)
        ->get();
}
    //عرض مطعم معين
    public function show($id)
{
    return Restaurant::findOrFail($id);
}
    //تخزين مطعم جديد
  public function store(StoreRestaurantRequest $request)
{
    $this->authorize('create', Restaurant::class);

    try {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant = Restaurant::create($data);

        return response()->json($restaurant, 201);

    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 400);
    }
}
    //تعديل مطعم
  public function update(StoreRestaurantRequest $request, Restaurant $restaurant)
{
    $this->authorize('update', $restaurant);

    $data = $request->validated();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('restaurants', 'public');
    }

    $restaurant->update($data);

    return response()->json($restaurant);
}
    //حذف مطعم
   public function destroy(Restaurant $restaurant)
{
    $this->authorize('delete', $restaurant);

    $restaurant->delete();

    return response()->json([
        'message' => 'تم حذف المطعم'
    ]);
}
}
