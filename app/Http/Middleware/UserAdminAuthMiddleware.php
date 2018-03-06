<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class UserAdminAuthMiddleware
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
        $is_allow_access = null !== session('user_email') && User::where('email',$user_email)->first()->type == 'A';
        if(!$is_allow_access)
            return redirect('/');
        return $next($request);
    }
}
