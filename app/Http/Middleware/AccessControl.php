<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RoleToAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) {

        $roleToAccess = RoleToAccess::join('module_operations', 'module_operations.id', '=', 'role_to_accesses.module_operation_id')
                ->select('role_to_accesses.id', 'role_to_accesses.module_id', 'role_to_accesses.module_operation_id', 'module_operations.route', 'role_to_accesses.role_id')
                ->where('role_to_accesses.role_id', Auth::user()->role_id)
                ->pluck('module_operations.route', 'role_to_accesses.id')
                ->toArray();

        if (in_array(Request::route()->getName(), $roleToAccess) == false) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
