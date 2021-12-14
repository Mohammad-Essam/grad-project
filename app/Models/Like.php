<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Like extends Model
{
    use HasFactory;
    
    public function user()
    {
      return $this->belongTo(User::class);
    }
    public function getUsernameAttribute($value)
    {
      return $this->user->username;
    }
    protected $fillable = [
      'user_id',
      'post_id'
    ];
    protected $hidden = [
      'user',
    ];
    protected $appends = [
      'username',
    ];
}
