<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->status == STATUS_ACTIVE){
            return $next($request);
        }else{
            Auth::logout();
            return redirect("login")->with('error', __('Your account is inactive. Please contact with admin'));
        }
    }
}
