<?php

namespace App\Services;

class MyService
{
    private $id;

    public function __construct()
    {
        $this->id = uniqid();
    }

    public function getId()
    {
        return $this->id;
    }
}
