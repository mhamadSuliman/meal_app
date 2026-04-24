<?php


use App\Http\Controllers\Api\AddonController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\DeliveryApiController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\TestPaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\StripeWebhookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/user/set-city', [UserController::class, 'setCity']);


//راوت خاص للمطاعم
Route::middleware(['auth:sanctum', 'city.selected'])->group(function () {

    Route::prefix('restaurants')->group(function () {
        Route::get('top-rated', [RestaurantController::class, 'topRated']);
        Route::get('filter', [RestaurantController::class, 'byresname']);
    });

    Route::apiResource('restaurants', RestaurantController::class)
        ->only(['index', 'show']);
});


Route::middleware('auth:sanctum', 'role:admin,restaurant_owner')->group(function () {
    Route::apiResource('restaurants', RestaurantController::class)
        ->only(['store','update', 'destroy']);
});
//راوت خاص بالوجبات 
Route::middleware(['auth:sanctum'])->prefix('restaurants/{restaurant_id}')->group(function () {

    Route::post('meals', [MealController::class, 'store']);
    Route::put('meals/{meal}', [MealController::class, 'update']);
    Route::delete('meals/{meal}', [MealController::class, 'destroy']);
    Route::get('meals/{meal}', [MealController::class, 'show']);

});

//راوت خاص لاضافة الاضافات 
Route::get('restaurants/{restaurant}/meals', [MealController::class, 'byRestaurant']);
Route::middleware(['auth:sanctum'])->prefix('restaurants/{restaurant_id}')->group(function () {

    Route::post('addons', [AddonController::class, 'store']);
    Route::put('addons/{addon}', [AddonController::class, 'update']);
    Route::delete('addons/{addon}', [AddonController::class, 'destroy']);
    Route::get('addons/{addon}', [AddonController::class, 'show']);

});


Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{id}', [CountryController::class, 'show']);

Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{id}', [CityController::class, 'show']);

// 🔥 أهم route عندك
Route::get('/countries/{id}/cities', [CityController::class, 'byCountry']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/cart/add', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::delete('/cart/item/{id}', [CartController::class, 'remove']);
    Route::put('/cart/item/{id}', [CartController::class, 'updateQuantity']);

});


 Route::middleware('auth:sanctum')->group(function () {

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

 });

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::post('/test-confirm-payment', [TestPaymentController::class, 'confirm']);

Route::middleware(['auth:sanctum', 'role:admin,restaurant_owner'])
    ->post('/orders/{id}/refund', [OrderController::class, 'refund']);

    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/delivery/order/respond', [DeliveryApiController::class, 'respond']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/delivery/orders/{id}/accept', [DeliveryController::class, 'accept']);

    Route::post('/delivery/orders/{id}/reject', [DeliveryController::class, 'reject']);

});

