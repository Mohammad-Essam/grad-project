<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('EnsureTokenIsValid');
    }

    public function myProfile()
    {
        $user = getCurrentUser();
        return $user;
    }

    public function show(User $user)
    {
        return $user;
    }
    public function addFriend(User $user)
    {
        $currentUser = getCurrentUser();
        $res = $currentUser->addFriend($user);
        return response()->json(['success' => $res?true:false,
            'message'=>$res?'friend request is sent':'you already sent a request'],$res?201:200);
    }
    public function removeFriend(User $user)
    {
        $currentUser = getCurrentUser();
        $res = $currentUser->removeFriend($user);
        return response()->json(['success' => $res?true:false,
            'message'=>$res?'unfriend successfully':'he already is not your friend'],$res?201:200);
    }
        
    public function index()
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
