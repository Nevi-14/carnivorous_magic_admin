<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Loggedin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->session()->get('user', NULL);

        if(!isset($user['user_id']) || !(intval($user['user_id'] ?? 0))){
            
			return redirect()->route('login');
			
        }
        
		return $next($request);

    }
}