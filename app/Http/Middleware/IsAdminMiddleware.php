<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $role = Role::query()->where(['name' => 'admin',])->first();
        if(!(auth()->user()->role_id == $role->id)) {
            return response()->json([
                'success' => false,
                'message' => "You have not permission here"
            ]);
        }
        return $next($request);
    }
}
