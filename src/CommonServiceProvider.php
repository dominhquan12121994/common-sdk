<?php

namespace Common;

use Closure;
use Illuminate\Support\ServiceProvider;
use Common\Response\Response;

class CommonServiceProvider extends ServiceProvider
{
    public function register()
    {
//        app()->make(Response::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->make(Response::class);
    }
}
