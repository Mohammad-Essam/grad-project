<?php

namespace App\Http\Controllers\social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;


class PostController extends Controller
{
	public function __construct()
    {
        $this->middleware('EnsureTokenIsValid');
    }

		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */

    public function index()
    {
        $user = getCurrentUser();
				$friendsID = $user->friends()->pluck('id');
				$posts = Post::whereIn('user_id', $friendsID)->
				orWhere('user_id',$user->id)->latest()->get();
				return response()->json(['posts' => $posts],201);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			//$request->validate(['caption'=>'required']);
			$currentUser = getCurrentUser();
			$post = $currentUser->createPost($request->caption,$request->content,$request->type?intval($request->type):0);
			return response()->json(['success' => true, 'message' =>$post],201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
				$user = getCurrentUser();
				if($post->user == $user)
				{
					$post->delete();
					return response()->json(['success' => true, 'message' =>"deleted succesfully"],200);
				}
				else
				return response()->json(['success' => false, 'message' =>"cannot delete what isn't yours"],403);
    }

    public function like(Post $post)
    {
			$user = getCurrentUser();
			$res = $user->likePost($post);
			return response()->json(['success' => $res?true:false,
			'message'=>$res?'you liked the post':'you already liked the post before'],$res?201:200);
    }

    public function unlike(Post $post)
    {
			$user = getCurrentUser();
			$result = $user->unLikePost($post);
			return response()->json(['success' => $result?true:false,
			'message'=>$result?'you unliked the post':'you have not liked the post before to be able to unlike it'],$result?201:200);
    }
    public function numberOfLikes(Post $post)
    {
      return ['numberOfLikes' => $post->numberOfLikes()];
    }

		    /**
		     * Display the specified resource.
		     *
		     * @param  int  $id
		     * @return \Illuminate\Http\Response
		     */
			//TODO: remove that things and replace it with accessor if needed.
		    public function show(Post $post)
		    {
		        $comments = $post->comments;
				$NoLikes = $post->numberOfLikes();
				return $post;
		    }

		    // /**
		    //  * Update the specified resource in storage.
		    //  *
		    //  * @param  \Illuminate\Http\Request  $request
		    //  * @param  int  $id
		    //  * @return \Illuminate\Http\Response
		    //  */
		    // public function update(Request $request, $id)
		    // {
		    //     //
		    // }
				//

}
