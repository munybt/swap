<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Judite\Services\SwapSolver;

use GuzzleHttp\Client;
class SwapSolverServiceProvider  extends ServiceProvider
{


    /**
     * @return void
     */
    public function boot()
    {
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SwapSolver::class, function(){
            $client = new \GuzzleHttp\Client();
            return new SwapSolver($client);
        });
    }
}
