<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class VerifyRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $route = \Request::route()->getName();
        //dd($route);

        if ($route != "login") {
            if (!is_null(session('PERMISSIONS'))) {
                $permissions = [];
                $rolesAuth = Auth::user()->roles()->pluck('id')->toArray();
                dd($rolesAuth);

                $roles = Role::whereIn('id', $rolesAuth)->get();
                dd($roles);

                foreach ($roles as $role) {
                    $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
                }

                session(['PERMISSIONS' => $permissions]);
            }
            dd(session('PERMISSIONS'));

            if (!in_array($route, session('PERMISSIONS'))) {
                //return redirect()->route('login');
            }
        }

        return $next($request);
    }

}
