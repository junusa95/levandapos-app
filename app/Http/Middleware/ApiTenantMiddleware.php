<?php

namespace App\Http\Middleware;

use App\Company;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TenantService;
use Symfony\Component\HttpFoundation\Response;

class ApiTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->company_id) {
            $company = Company::find($user->company_id);

             if (! $company) {
                session()->forget('tenant_id');
                abort(404, 'Tenant not found');
            }

            TenantService::connect($company->dbname);
        }

        return $next($request);
    }
}
