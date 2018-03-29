<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RESTPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param null                     $prefix
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $prefix = null)
    {
        $user = Auth::getUser();

        if (!$user) {
            return $this->determineReturn($request);
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $action = $request->route()->getAction()['uses'];
        $delimitedAction = explode('\\', $action);
        $permission = explode('@', $delimitedAction[count($delimitedAction) - 1]);

        if ($user->cannot($prefix.'_'.$permission[1])) {
            error_log('User cannot '.$prefix.'_'.$permission[1]);
            \Log::info('user cannot '.$prefix.'_'.$permission[1]);

            return $this->determineReturn($request);
        } else {
            return $next($request);
        }
    }

    /**
     * Returns the proper response based on the client.
     *
     * @param $request
     *
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
