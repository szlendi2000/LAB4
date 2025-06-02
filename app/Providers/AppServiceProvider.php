<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\ModuleManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->singleton(\App\Modules\ComponentRegistry::class, function ($app) {
        return new \App\Modules\ComponentRegistry();
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $moduleManager = new ModuleManager();
        $moduleManager->loadModules();
    }
}
