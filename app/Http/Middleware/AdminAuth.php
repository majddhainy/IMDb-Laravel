<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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

        $user = Auth::user();
        if($user &&  $user->hasRole('cms_user') )
            return $next($request);
        else
            //Auth::logout();
            return redirect()->route('get-cms-login')->withErrors('Please login to continue !');
    }
}
