<?php

namespace App\Providers;

use App\Net\Shinton\CatechismParser;
use Illuminate\Support\ServiceProvider;

class CatechismParserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CatechismParser::class, function ($app) {
            return new CatechismParser();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
