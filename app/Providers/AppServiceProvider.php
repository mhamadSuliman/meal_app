<?php

namespace App\Providers;

use App\Models\Addon;
use App\Models\Meal;
use App\Models\Restaurant;
use App\Policies\AddonPolicy;
use App\Policies\MealPolicy;
use App\Policies\RestaurantPolicy;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
    \App\Models\Restaurant::class => \App\Policies\RestaurantPolicy::class,
    \App\Models\Meal::class => \App\Policies\MealPolicy::class,
    \App\Models\Addon::class=>\App\Policies\AddonPolicy::class,
    \App\Models\Order::class=>\App\Policies\OrderPolicy::class,
];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
     Broadcast::routes();
    Gate::policy(Restaurant::class, RestaurantPolicy::class);
    Gate::policy(Meal::class, MealPolicy::class);
}
}
