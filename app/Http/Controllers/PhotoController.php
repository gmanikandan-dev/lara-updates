<?php

namespace App\Http\Controllers;

use App\Interfaces\Camera;

class PhotoController extends Controller
{
    public function __construct(protected Camera $camera) {}

    public function capture()
    {
        dd($this->camera->takePicture());
    }
}
