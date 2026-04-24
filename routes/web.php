<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\NotificationController;
// use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Web\AdminRestaurantController;
use App\Http\Controllers\Web\OwnerMealController;

Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect('/login');
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // 🛠️ Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // 🍔 Owner Dashboard
    Route::get('/owner/dashboard', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');

});

Route::middleware(['auth'])->group(function () {

    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

});



Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/restaurants/create', [AdminRestaurantController::class, 'create']);
    Route::post('/restaurants', [AdminRestaurantController::class, 'store']);
    Route::delete('/restaurants/{id}', [AdminRestaurantController::class, 'destroy']);

});

Route::middleware(['auth'])->prefix('owner')->group(function () {

    Route::get('/meals/create', [OwnerMealController::class, 'create']);
    Route::post('/meals', [OwnerMealController::class, 'store']);
    Route::delete('/meals/{id}', [OwnerMealController::class, 'destroy']);

});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');

    Route::post('/orders/{id}/accept', [AdminOrderController::class, 'accept'])->name('orders.accept');

    Route::post('/orders/{id}/reject', [AdminOrderController::class, 'reject'])->name('orders.reject');

});
Route::post('/notifications/mark-all-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->middleware('auth')->name('notifications.markAllRead');




Route::middleware(['auth'])->group(function () {
    Route::get('/restaurants', [AdminRestaurantController::class, 'index'])->name('restaurants.index');
    Route::get('/restaurants/{id}', [AdminRestaurantController::class, 'show'])->name('restaurants.show');
    Route::get('/admin/restaurants/filter', [AdminRestaurantController::class, 'filterByCity']);
    Route::get('/restaurants/{id}/edit', [AdminRestaurantController::class,'edit']);
Route::put('/restaurants/{id}', [AdminRestaurantController::class,'update']);
Route::delete('/restaurants/{id}', [AdminRestaurantController::class,'destroy']);
});

Route::post('/restaurants/{id}/meals', [AdminRestaurantController::class, 'storeMeal']);
Route::put('/meals/{id}', [AdminRestaurantController::class, 'updateMeal']);
Route::delete('/meals/{id}', [AdminRestaurantController::class, 'deleteMeal']);


Route::middleware(['auth'])->prefix('delivery')->group(function () {

    Route::get('/dashboard', [DeliveryController::class, 'dashboard']);

});


require __DIR__.'/auth.php';
