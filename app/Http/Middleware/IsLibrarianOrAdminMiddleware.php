<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class IsLibrarianOrAdminMiddleware
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
        $role_admin = Role::query()->where(['name' => 'admin',])->first();
        $role_librarian = Role::query()->where(['name' => 'librarian',])->first();
        if(!(auth()->user()->role_id == $role_admin->id) && !(auth()->user()->role_id ==$role_librarian->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Users have not permission here'
            ], 401);
        }
        return $next($request);
    }
}
