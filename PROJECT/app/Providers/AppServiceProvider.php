<?php

namespace App\Providers;

use App\Models\RoleToAccess;
use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        
        $this->app->bind(UserInterface::class, UserRepository::class);

        view()->composer('*', function ($view) {

            if (Auth::check()) {
                $roleToAccess = RoleToAccess::join('module_names', 'module_names.id', '=', 'role_to_accesses.module_id')
                    ->join('module_operations', 'module_operations.id', '=', 'role_to_accesses.module_operation_id')
                    ->where('role_id', Auth::user()->role_id)
                    ->select('role_to_accesses.*', 'module_names.name', 'module_operations.operation', 'module_operations.route')
                    ->get();

                $accessArr = [];
                $accessRouteArr = [];
                if ($roleToAccess->isNotEmpty()) {
                    foreach ($roleToAccess as $key => $access) {
                        $accessArr[$access->name][$access->module_operation_id] = $access->operation;
                        $accessRouteArr[$key] = $access->route;
                    }
                }
            }


            $view->with([
                'accessArr' => isset($accessArr) ? $accessArr : [],
                'accessRouteArr' => isset($accessRouteArr) ? $accessRouteArr : [],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
