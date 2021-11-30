<?php
use App\Models\User;
function getCurrentUser()
{
  $token = request()->bearerToken;
  $currentUser = User::where('api_token', $token);
  if(!$currentUser)
    return false;// ['success' => false, 'message'=> 'you are not loggen in'];
  return $currentUser;
}?>
