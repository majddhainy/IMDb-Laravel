<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerAuth
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
        {

            $user = Auth::user();
            if($user &&  $user->hasRole('customer') )
                return $next($request);
            else
                //Auth::logout();
                return redirect()->route('cms-login')->withErrors('Only Logged in Customers can rate movies!');
        }
    }
}
