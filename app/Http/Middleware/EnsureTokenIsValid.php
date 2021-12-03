<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		$token = $request->bearerToken();
		$user = User::where('api_token', $token)->first();
		if(!($token && $user))
		return response()->json(['success' => false,'message' => 'unauthenticated user'],403);
        
		return $next($request);
    }
}
