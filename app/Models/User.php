<?php

namespace App\Models;

use App\Models\badges\Badge;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Comment;
use App\Models\like;
use App\Models\training\Record;

class User extends Authenticatable
{
  //use HasApiTokens,
    use  HasFactory, Notifiable;

    public function createPost($caption, $content,$type)
    {
      $post = Post::create(['caption' => $caption,
                    'content'=> $content,
                    'user_id'=>$this->id,
                    'type' => $type]);
        return $post;
    }
    //must be restricted to comment only on friends posts.
    public function commentOnPost(Post $post, $comment)
    {
      $newComment = Comment::create(['content'=>$comment,
                        'user_id'=>$this->id,
                        'post_id'=>$post->id]);
        return $newComment;
    }
    public function likePost(Post $post)
    {
      $res = Like::where('user_id',$this->id)->where('post_id',$post->id)->first();
      if(!$res)
      {
        $like = Like::create(['user_id'=>$this->id,'post_id'=>$post->id]);
        return true;
      }
      else {
        return false;
      }
    }
    public function liked(Post $post)
    {
      $res = Like::where('user_id',$this->id)->where('post_id',$post->id)->first();
      if($res)
      {
        return true;
      }
      else {
        return false;
      }
    }
    public function unLikePost(Post $post)
    {
      $like = Like::where('post_id',$post->id)->where('user_id',$this->id);
      if($like->first())
      {
        $like->delete();
        return true;
      }
      else return false;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

//NOT eloquent relationship.
//return users.
//it is called as user->friends()->get();
    public function friends()
    {
      return User::where(function($q) {
          $sent =DB::table('friendships')->where('sender', $this->id)->pluck('reciever');
          $recieved =DB::table('friendships')->where('reciever', $this->id)->pluck('sender');
          $friendsIds= $sent->merge($recieved);
          //state = 1 for accepted friend request.
          $q->whereIn('id', $friendsIds);
     });
    }

    public function addFriend(User $user)
    {
      $isFriend = DB::table('friendships')->where('sender',$this->id)
      ->where('reciever', $user->id)->first();
      if(!$isFriend && $user != $this)
      {
        DB::table('friendships')->insert([
              'sender' => $this->id,
              'reciever'=>$user->id,
            ]);
        return true;
      }
      else {
        return false;
      }
    }
    public function removeFriend(User $user)
    {
      $isFriend = DB::table('friendships')->where('sender',$this->id)
      ->where('reciever', $user->id);
      if($isFriend->first())
      {
        $isFriend->delete();
        return true;
      }
      else {
        return false;
      }
    }

    public function badges()
    {
      return $this->belongsToMany(Badge::class, 'user_has_badges', 'user_id', 'badge_name');
    }
    public function getBadgesAttribute($value)
    {
        return $this->badges()->get()->makeHidden('rules');
    }

    
    public function exercised()
    {
      return $this->hasMany(Record::class);
    }


    public function acceptFriendRequest()
    {

    }
    
    public function getPostsAttribute($value)
    {
        return $this->posts()->get();
    }
    public function getFriendsUsernameAttribute($value)
    {
        return $this->friends()->pluck('username');
    }
    public function getLevelAttribute($value)
    {
        return intval($this->exp / 1000);
    }
    public function getToReachNextLevelAttribute($value)
    {
        return intval( 1000 - ($this->exp % 1000));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'username',
        'email',
        'password',
        'api_token',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = [
      'friends_username',
      'posts',
      'badges',
      'level',
      'to_reach_next_level'
    ];
}
