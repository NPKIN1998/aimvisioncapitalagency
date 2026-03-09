<?php

namespace App\Providers;

use App\Helpers\CurrencyHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrencyHelper::class, function () {
            return new CurrencyHelper;
        });

        // Optional: Create a shorter alias if desired
        $this->app->alias(CurrencyHelper::class, 'currency');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $currencyHelper = app(CurrencyHelper::class);
            $user = Auth::user();

            $notifications = $user ? $user->notifications()->latest()->get() : collect();

            $view->with([
                'currency' => [
                    'symbol' => $currencyHelper->symbol(),
                    'rate' => $currencyHelper->rate(),
                    // Add more currency-related data if needed
                ],
                // Optional: Direct helper method for common use cases
                'currencyFormat' => function ($amount) use ($currencyHelper) {
                    return $currencyHelper->format($amount);
                },
                'notifications' => $notifications,
            ]);
        });
    }
}
