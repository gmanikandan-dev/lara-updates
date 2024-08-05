<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as EloquentModel;

class Student extends EloquentModel
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'email',
        'status'
    ];
    
}
