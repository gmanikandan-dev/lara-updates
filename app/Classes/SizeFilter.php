<?php
 
namespace App\Classes;

use App\Interfaces\Filter;

class SizeFilter implements Filter {

    public function filterWords()
    {
        return 'Filtering words by size';
    }

}