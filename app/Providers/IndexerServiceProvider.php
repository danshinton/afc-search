<?php

namespace App\Providers;

use App\Net\Shinton\CatechismIndexer;
use Illuminate\Support\ServiceProvider;

class IndexerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CatechismIndexer::class, function ($app) {
            return new CatechismIndexer();
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
