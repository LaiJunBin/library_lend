<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\RegisterUser;


class SignUpMiddleware
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
        $inputEmail = $request->request->get('email');
        if(User::where('email',$inputEmail)->first()==null and
           RegisterUser::where('email',$inputEmail)->first()==null)
            return $next($request);
        else{
            return redirect('user/sign-up')->withErrors(['errors'=>'電子郵件重複!'])->withInput();
        }
    }
}
