<?php

namespace App\Http\Middleware;

use Closure;

class cekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = request()->user();
        if ($user->role_id != $role) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Access forbidden'
            ], 403);
        }
        return $next($request);
    }
}
