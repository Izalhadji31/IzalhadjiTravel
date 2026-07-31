<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScopeTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get company_id from route parameter, session, or user company
        $companyId = $request->route('company_id') ?? 
                     session('company_id') ?? 
                     ($request->user()?->company_id ?? null);

        if (!$companyId && $request->user()) {
            // If user is admin, get their company from admin_user_id
            $company = \App\Models\Company::where('admin_user_id', $request->user()->id)->first();
            $companyId = $company?->id;
        }

        // Store in request for use in queries
        if ($companyId) {
            $request->attributes->set('company_id', $companyId);
            session(['company_id' => $companyId]);
        }

        return $next($request);
    }
}
