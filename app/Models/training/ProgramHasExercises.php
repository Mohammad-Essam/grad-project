<?php

namespace App\Models\training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramHasExercises extends Model
{
    use HasFactory;
    protected $hidden =[
        'id',
        'program_id'
    ];
}
