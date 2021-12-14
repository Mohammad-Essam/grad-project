<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    public function post()
    {
      return $this->belongsTo(Post::class);
    }
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function getUsernameAttribute($value)
    {
        return $this->user->username;
    }
    public function getUserAvatarAttribute($value)
    {
        return $this->user->avatar;
    }
    
    protected $fillable = [
      'content',
      'user_id',
      'post_id'
    ];
    protected $appends = [
      'username',
      'user_avatar',
    ];
    protected $hidden = [
      'user',
      'post',
    ];
}
