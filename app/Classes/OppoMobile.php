<?php

namespace App\Classes;

use App\Interfaces\Camera;

class OppoMobile implements Camera
{
    public function takePicture()
    {
        return 'Taking picture with Oppo Mobile';
    }
}
