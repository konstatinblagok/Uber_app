<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
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
        if(Auth::check()) {

            if(Auth::user()->isAdmin()) {

                return $next($request);
            }
            else {

                return redirect()->route('index')->with('error', 'You are not allowed to access this page!');
            }
        }
        else {

            return redirect()->route('admin.auth.login.page');
        }
    }
}
