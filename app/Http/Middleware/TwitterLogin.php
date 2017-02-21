<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;

class TwitterLogin
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
        if (session()->has('user')) {
            
            if (session('user') == 'beirutspring') {
                return $next($request);
            }

            // if wrong twitter user
            die('wrong twitter username');

        }

        // if no twitter user
        return redirect('/login/twitter');

    }
}
