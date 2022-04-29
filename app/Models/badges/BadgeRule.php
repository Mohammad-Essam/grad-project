<?php

namespace App\Models\badges;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeRule extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $hidden = [
        'id',
        'badge_name',
    ];
    protected $fillable = [
        'badge_name',
        'exercise_name',
        'count',

    ];
}
