<?php
 
namespace App\Classes;

use App\Interfaces\Filter;

class ColorFilter implements Filter{
    public function filterWords()
    {
        return 'Filtering words by color';
    }
}