<?php

namespace App\Models\comptitive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;
    protected $fillable =[
        'exercise_name',
        'player_one_id',
        'player_two_id',
        'reps',
        'state',
        'player_one_score',
        'player_two_score',
    ];
    public function playerOne()
    {
        return $this->belongsTo(User::class,'player_one_id','id');//, 'foreign_key', 'owner_key');
    }
    public function playerTwo()
    {
        return $this->belongsTo(User::class,'player_two_id','id');//, 'foreign_key', 'owner_key');
    }
}
