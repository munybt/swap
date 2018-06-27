<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use GuzzleHttp\Client;
class SwapSolverServiceProvider extends ServiceProvider
{

    protected $client 

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        this->app->singleton('swapSolver'),function($app){
            $client = new \GuzzleHttp\Client();
            $url = "http://167.99.219.46:4567";
            $myBody = '{"exchange_requests":[
                {
                    "id": "a1",
                    "from_shift_id": "TP1",
                    "to_shift_id": "TP2",
                    "created_at": 1
                },
                {
                    "id": "a2",
                    "from_shift_id": "TP1",
                    "to_shift_id": "TP3",
                    "created_at": 1
                },
                {
                    "id": "a3",
                    "from_shift_id": "TP1",
                    "to_shift_id": "TP4",
                    "created_at": 1
                },
                {
                    "id": "a4",
                    "from_shift_id": "TP2",
                    "to_shift_id": "TP1",
                    "created_at": 2
                },
                {
                    "id": "a5",
                    "from_shift_id": "TP2",
                    "to_shift_id": "TP3",
                    "created_at": 2
                },
                {
                    "id": "a6",
                    "from_shift_id": "TP2",
                    "to_shift_id": "TP4",
                    "created_at": 2
                },
                {
                    "id": "a7",
                    "from_shift_id": "TP3",
                    "to_shift_id": "TP1",
                    "created_at": 3
                },
                {
                    "id": "a8",
                    "from_shift_id": "TP3",
                    "to_shift_id": "TP2",
                    "created_at": 3
                },
                {
                    "id": "a9",
                    "from_shift_id": "TP3",
                    "to_shift_id": "TP4",
                    "created_at": 3
                },
                {
                    "id": "a10",
                    "from_shift_id": "TP4",
                    "to_shift_id": "TP1",
                    "created_at": 4
                },
                {
                    "id": "a11",
                    "from_shift_id": "TP4",
                    "to_shift_id": "TP2",
                    "created_at": 4
                },
                {
                    "id": "a12",
                    "from_shift_id": "TP4",
                    "to_shift_id": "TP3",
                    "created_at": 4
                }       
            ]
                }';
            $request = $client->post($url,['body'=>$myBody]);
            $response = $request->send();
            echo($response);
        }
    }
}
