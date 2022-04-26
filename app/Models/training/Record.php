<?php

namespace App\Models\training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'exercise_id',
        'count',
        'duration'
    ];
}
