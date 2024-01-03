<?php

namespace App\Providers;

use App\Models\Program;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        View::share('ROOT_URL', config('app.root_url') ?: request()->root());
        View::share('activePrograms', Program::where('is_active', 1)->get());
    }
}
