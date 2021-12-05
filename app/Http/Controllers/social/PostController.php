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
				return $posts;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			$currentUser = getCurrentUser();
			$post = $currentUser->createPost($request->caption,$request->content);
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
					return response()->json(['success' => true, 'message' =>"deleted succesfully"],201);
				}
				else
				return response()->json(['success' => false, 'message' =>"cannot delete what isn't yours"]);
    }

    public function like(Post $post)
    {
			$user = getCurrentUser();
			$result = $user->likePost($post);
			return $result;
    }

    public function unlike(Post $post)
    {
			$user = getCurrentUser();
			$result = $user->unLikePost($post);
			return $result;
    }
    public function numberOfLikes(Post $post)
    {
      return $post->likes()->count();
    }



		    /**
		     * Display the specified resource.
		     *
		     * @param  int  $id
		     * @return \Illuminate\Http\Response
		     */
		    public function show(Post $post)
		    {
		        $comments = $post->comments;
						$NoLikes = $post->likes->count();
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
