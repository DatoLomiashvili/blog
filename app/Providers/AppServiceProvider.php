<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->renamePublicFolder();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     *  Change public folder name
     */
    protected function renamePublicFolder(): void
    {
        $publicFolder = base_path('public_html');
        $this->app->usePublicPath($publicFolder);
    }
}
