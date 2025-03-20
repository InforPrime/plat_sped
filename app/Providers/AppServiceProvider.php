<?php

namespace App\Providers;

use App\Models\Arquivo;
use App\Observers\ArquivoObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Arquivo::observe(ArquivoObserver::class);
    }
}
