<?php
 
namespace App\Classes;

use App\Interfaces\Camera;

class OppoMobile implements Camera
{
    function takePicture()
    {
        return 'Taking picture with Oppo Mobile';
    }
}