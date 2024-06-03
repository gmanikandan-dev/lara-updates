<?php

namespace App\Http\Controllers;

use App\Interfaces\Camera;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    function __construct(protected Camera $camera)
    {
    }

    function capture() {
        dd($this->camera->takePicture());
    }
}
