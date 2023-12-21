<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RoleToAccess;
use Illuminate\Http\Request;
use App\Models\ModuleOperation;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

class AccessControl {

    use ApiReturnFormatTrait;

    public function handle(Request $request, Closure $next) {

        $roleToAccess = RoleToAccess::join('module_operations', 'module_operations.id', '=', 'role_to_accesses.module_operation_id')
                ->select('role_to_accesses.id', 'role_to_accesses.module_id', 'role_to_accesses.module_operation_id', 'module_operations.route', 'role_to_accesses.role_id')
                ->where('role_to_accesses.role_id', Auth::user()->role_id)
                ->pluck('module_operations.route', 'role_to_accesses.id')
                ->toArray();

        if (in_array(\Request::route()->getName(), $roleToAccess) == false) {
            return $this->responseWithSuccess('You no Permission to this action!!');
        }
        return $next($request);
    }

}
