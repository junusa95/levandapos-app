<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApiCeoBusinessOwnerMiddleware
{
    /**
     * Only allow an incoming request when the logged in user
     * has CEO or Business Owner Roles.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->isActive() && Auth::user()->isCEOorBusinessOwner()){
            return $next($request);
        }else{
            abort(401, "Unauthorized to perform this action.");
        }
    }
}
