<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Container\Container as App;

class OwnerPermission
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param bool $prefix
     * @param string $foreign
     * @param string $model Required for checking relationship ownership
     * @param string $parent Required when model is defined
     * @return mixed
     */
    public function handle($request, Closure $next, $prefix = false, $foreign = 'user_id', $model = null, $parent = null)
    {
        $user = Auth::getUser();

        // If no user, well it's broken
        if (!$user) {
            return $this->determineReturn($request);
        }

        // Gotta check if the user is the owner of the model
        if (
            $this->isOwner(
                $request->route()->getParameter($prefix),
                $user,
                $prefix,
                $foreign,
                $model,
                $parent
            )) {
            return $next($request);
        }

        // Not the owner, then you must have the appropriate permission
        $action = $request->route()->getAction()['uses'];
        $delimitedAction = explode('\\', $action);
        $permission = explode('@', $delimitedAction[count($delimitedAction) - 1]);

        $permission = $permission[1] !== 'edit' ? $permission[1] : 'update';

        if (!$user->isSuperAdmin() && $user->cannot($prefix.'_'.$permission)) {
            return $this->determineReturn($request);
        } else {
            return $next($request);
        }
    }

    /**
     * Verifies the model the the database for the foreign user key to
     * match the given user
     *
     * @param $id
     * @param $user
     * @param $prefix
     * @param $foreign
     * @return bool
     */
    protected function isOwner($id, $user, $prefix, $foreign, $model, $parent)
    {
        // If it's the user model, there is no owner
        if (strcmp($prefix, 'user') === 0 || strcmp($prefix, 'profile') === 0) {
            return $user->id === $id;
        }

        if (!$model && !$parent) {
            return $this->checkDirectOwnership($id, $user, $prefix, $foreign);
        }

        return $this->checkRelationalOwnership($id, $user, $foreign, $model, $parent);
    }

    /**
     * Checks the ownership of a direct model (meaning the foreign user id is
     * directly inside the given model).
     *
     * @param $id
     * @param $user
     * @param $prefix
     * @param $foreign
     * @return bool
     */
    protected function checkDirectOwnership($id, $user, $prefix, $foreign)
    {
        $foreignModel = \DB::table($prefix.'s')
            ->select($foreign)
            ->where('id', $id)
            ->first();

        return $foreignModel && $foreignModel->$foreign === $user->id;
    }

    /**
     * Checks the ownership of the model relationship. The parent model can
     * be polymorphic as well. It will work as long as the "parent" string
     * is the function to call to get the parent.
     *
     * Note that the foreign key should be
     * the same for all related parents if it's a polymorphic relation
     *
     * @param $id
     * @param $user
     * @param $foreign
     * @param $model
     * @param $parent
     * @return bool
     */
    protected function checkRelationalOwnership($id, $user, $foreign, $model, $parent)
    {
        $this->makeModel($model);
        $foreignId = $parent.'_id';

        $this->model = $this->model->where('id', $id)
            ->first();

        // If no parent relationship defined, (or is null) then there's no ownership
        if (!$this->model || !$this->model->$foreignId) {
            return false;
        }

        $this->model = $this->model->$parent()
            ->select($foreign)
            ->first();

        return $this->model && $this->model->$foreign === $user->id;
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

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function makeModel($name) {
        $model = $this->app->make('Models\\'.$name);

        return $this->model = $model;
    }
}
