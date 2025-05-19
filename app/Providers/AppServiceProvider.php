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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(HttpException::class, function ($exception) {
            if ($exception->getStatusCode() === 403) {
                return redirect('/'); // Change to your desired route
            }
    
            return Response::make(view('errors.403'), 403);
        });
    }
}
