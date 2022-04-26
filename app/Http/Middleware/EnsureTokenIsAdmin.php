<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
class EnsureTokenIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		$token = $request->bearerToken();
		$user = User::where('api_token', $token)->first();
		if(!($token && $user))
		return response()->json(['success' => false,'message' => 'unauthenticated user'],403);
        if ($user->role != 2)
        return response()->json(['success' => false,'message' => 'you must be an admin to acces this end-point'],401);
		return $next($request);
    }
}
