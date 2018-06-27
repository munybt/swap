<?php

namespace App\Judite\Contracts;

interface SwapSolver
{
    /**
     * Solve the exchange requests
     *
     * @param  string  $exchangeRequests
     *
     * @return string
     */
    public function solve($exchangeRequests);

   
}
