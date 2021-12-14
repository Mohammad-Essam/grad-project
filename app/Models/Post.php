<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);//, 'foreign_key', 'owner_key');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id','id');
    }

    public function likes()
    {
      return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }
    public function numberOfLikes()
    {
      return $this->likes()->count();
    }

    public function getNumberOfLikesAttribute($value)
    {
        return $this->numberOfLikes();
    }
    public function getUsernameAttribute($value)
    {
        return $this->user->username;
    }
    public function getCommentsAttribute()
    {
        return $this->comments()->get();
    }

    public function getNumberOfCommentsAttribute($value)
    {
        return $this->comments()->count();
    }
    
    public function getUserAvatarAttribute($value)
    {
        return $this->user->avatar;
    }
    
    public function getLikedAttribute($value)
    {
        $user = getCurrentUser();
        if($user)
        {
          $result = $user->liked($this);
          return $result;
        }
    }
    
    public function getLikesAttribute($value)
    {
        return $this->likes()->pluck('username');
    }
    protected $appends = [
      'number_of_likes',
      'number_of_comments',
      'username',
      'user_avatar',
      'comments',
      'liked',
      'likes',
    ];
    protected $fillable = [
      'caption',
      'content',
      'user_id'
    ];
    protected $hidden = [
      'user',
    ];
}
