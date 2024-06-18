<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserPackage;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Domain;

class Tenant
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
        if(isAddonInstalled('DESKSAAS') > 0){
            $host = request()->getHost();
            $domainDetails = Domain::where('domain', $host)->first();
            if (is_null($domainDetails)) {
                abort(404);
            }

            $tenant = User::where(['tenant_id'=> $domainDetails->tenant_id, 'status'=> USER_STATUS_ACTIVE])->first();
            if(is_null($tenant)){
                abort(404);
            }

//            $tenantAnyPackageActiveOrNot = UserPackage::query()
//                    ->where('status', PACKAGE_STATUS_ACTIVE)
//                    ->where('user_id', $tenant->id)
//                    ->whereDate('end_date', '>=', now()->toDateTimeString())
//                    ->first();

//            if(is_null($tenantAnyPackageActiveOrNot)){
//                abort(404);
//            }
        }
        return $next($request);
    }
}
