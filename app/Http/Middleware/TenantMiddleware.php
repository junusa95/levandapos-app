<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Company;
use App\Services\TenantService;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company_id = session('company.id');

        if ($company_id) {
            $company = Company::find($company_id);

            if (! $company) {
                session()->forget('tenant_id');
                abort(404, 'Tenant not found');
            }

            // Connect to the tenant DB (this updates config('database.connections.tenant.database'))
            TenantService::connect($company->dbname);
        }

        return $next($request);
    }
}
