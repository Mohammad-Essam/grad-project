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

    protected $fillable = [
      'caption',
      'content',
      'user_id'
    ];
}
