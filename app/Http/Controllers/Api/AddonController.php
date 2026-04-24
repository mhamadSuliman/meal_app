<?php


namespace App\Http\Controllers\Api; 
use App\Http\Controllers\Controller;
use App\Http\Requests\AddonMealRequest;
use App\Http\Requests\UpdateAddonMealRequest;
use App\Models\Addon;
use App\Models\Restaurant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AddonController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return response()->json(Addon::with('restaurant')->get());
    }

    public function store(AddonMealRequest $request, $restaurant_id)
{
    $restaurant = Restaurant::findOrFail($restaurant_id);

    // 🔥 أهم سطر
    $this->authorize('create', [Addon::class, $restaurant]);

    $data = $request->validated();
    $data['restaurant_id'] = $restaurant_id;

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('addons', 'public');
    }

    $addon = Addon::create($data);

    return response()->json($addon, 201);
}

    public function update(UpdateAddonMealRequest $request, $restaurant_id, $addon_id)
    {
        $addon = Addon::with('restaurant')->findOrFail($addon_id);

        // 🔥 Policy
        $this->authorize('update', $addon);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('addons', 'public');
        }

        $addon->update($data);

        return response()->json($addon);
    }

    public function show($restaurant_id, $addon_id)
    {
        $addon = Addon::where('id', $addon_id)
            ->where('restaurant_id', $restaurant_id)
            ->firstOrFail();

        return response()->json($addon);
    }

    public function destroy($restaurant_id, $addon_id)
    {
        $addon = Addon::with('restaurant')->findOrFail($addon_id);

        // 🔥 Policy
        $this->authorize('delete', $addon);

        $addon->delete();

        return response()->json(['message' => 'Addon deleted']);
    }
}