<?php

namespace App\Classes;

use App\Interfaces\Filter;

class Firewall
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        Filter ...$filters,
    ) {
        dd($filters);
    }
}
