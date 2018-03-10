<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::getUser();

        if (!$user) {
            return $this->determineReturn($request);
        }

        if (!$user->isSuperAdmin() && $user->cannot($permission)) {
            return $this->determineReturn($request);
        } else {
            return $next($request);
        }
    }

    /**
     * Returns the proper response based on the client
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function determineReturn($request)
    {
        if (strpos($request->getPathInfo(), '/api/') === false) {
            abort(403);
        } else {
            return response()->json('unauthorized', 403);
        }
    }
}
