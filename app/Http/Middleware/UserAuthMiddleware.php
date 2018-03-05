<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class UserAuthMiddleware
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
        $user_email = session('user_email');
        $is_allow_access = $user_email != null;
        if(!$is_allow_access)
            return redirect('/user');
        return $next($request);
    }
}
