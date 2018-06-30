<?php

namespace App\Judite\Services;

use Exception;
use GuzzleHttp\ClientInterface;
use App\Judite\Contracts\SwapSolver as SwapSolverInterface;

class SwapSolver implements SwapSolverInterface
{
    /**
     * Guzzle client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;
    const URL = "167.99.219.46:4567";

    /**
     * Create a new LusoPay client instance.
     *
     * @param  \GuzzleHttp\ClientInterface  $client
     *
     * @return void
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Request payment's reference to LusoPay.
     *
     * @param  string  $exchangeRequests
     *
     * @return array
     */

    public function solve($exchangeRequests){
        try{
            $response = $this->client->post(self::URL, ['body'=>$exchangeRequests]);
            return $response->getBody();
        }
        catch(Exception $ex){
            echo "Failed retrieving result from swap solver service: " ;
            echo $ex->getMessage();
        }
    }
}
