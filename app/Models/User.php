<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Comment;
use App\Models\like;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function createPost($caption, $content)
    {
      $post = Post::create(['caption' => $caption,
                    'content'=> $content,
                    'user_id'=>$this->id]);
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
      $like = Like::create(['user_id'=>$this->id,
                        'post_id'=>$post->id]);
        return $like;
    }
    public function unLikePost(Post $post)
    {
      $like = Like::where('post_id',$post->id)->where('user_id',$this->id);
      if($like)
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
//it is called as user->friends()->get();
    public function friends()
    {
      //$sent = $this->belongsToMany(User::class, 'friendships', 'sender', 'reciever');
      //$recieved=  $this->belongsToMany(User::class, 'friendships', 'reciever', 'sender');
      //return $sent;
      return User::where(function($q) {
          $sent =DB::table('friendships')->where('sender', $this->id)->pluck('reciever');
          $recieved =DB::table('friendships')->where('reciever', $this->id)->pluck('sender');
          $friendsIds= $sent->merge($recieved);
          //state = 1 for accepted friend request.
          $q->whereIn('id', $friendsIds)->where('state',0);
     });
    }

    public function addFriend(User $user)
    {
        DB::table('friendships')->insert(
            [
            'sender' => $this->id,
            'reciever'=>$user->id,
            'state'=>0
            ]
        );
    }

    public function acceptFriendRequest()
    {

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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
