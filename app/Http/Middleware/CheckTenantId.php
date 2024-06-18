<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;

class CheckTenantId
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == USER_ROLE_ADMIN) {
            if(!auth()->user()->tenant_id || auth()->user()->tenant_id == null || auth()->user()->tenant_id == '' || empty(auth()->user()->tenant_id)){
                return $this->error([],  'Please setup your domain first');
            }
        }
        return $next($request);
    }
}
