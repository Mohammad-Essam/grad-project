<?php

namespace App\Models\comptitive;

use App\Models\User;
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
        'winner_username'
    ];
    public function playerOne()
    {
        return $this->belongsTo(User::class,'player_one_id','id');//, 'foreign_key', 'owner_key');
    }
    public function playerTwo()
    {
        return $this->belongsTo(User::class,'player_two_id','id');//, 'foreign_key', 'owner_key');
    }
    // public function opponent()
    // {
    //     return $this->belongsTo(User::class,'player_two_id','id');//, 'foreign_key', 'owner_key');
    // }
    
    public function getCreatorNameAttribute($value)
    {
        return $this->playerOne->username;
    }
    public function getUserAvatarAttribute($value)
    {
        return $this->playerOne->avatar;
    }
    protected $appends = [
        'creator_name',
        'user_avatar',
    ];
    protected $hidden = [
        'playerOne',
    ];

    
}
