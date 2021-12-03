<?php
use App\Models\User;
function getCurrentUser()
{
  $token = request()->bearerToken();
  $currentUser = User::where('api_token', $token)->first();
  return $currentUser;
}?>
