<?php

namespace Amir\Permission\Middleware;

use Amir\Permission\Exceptions\UnauthenticatedException;
use Amir\Permission\Exceptions\UnauthorizedException;
use Amir\Permission\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class AuthRoles
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, Closure $next)
    {

        $guards = collect(config('auth.guards'));

        $authGuard = $guards->keys()->filter(function($key) {
            return auth($key)->check();
        })->first();

        throw_if(!auth($authGuard)->check(), UnauthenticatedException::notLoggedIn());

        $action = $request->route()->getActionname();
        $name = $request->route()->getActionname();

        $role_id = auth($authGuard)->user()->role_id;

        $permission = Permission::where(function ($query)use ($action, $name){
            $query->where('name', $name);
            $query->orWhere('action', $action);
        })->whereHas('roles', function ($query) use($role_id){
            $query->where('id',$role_id);
        })->first();

        throw_if(is_null($permission), UnauthorizedException::noPermission());

        return $next($request);
    }
}
