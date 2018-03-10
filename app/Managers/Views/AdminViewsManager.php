<?php

namespace Managers\Views;

use Auth;
use Models\User;
use Models\Role;
use Models\Permission;
use Models\Error;
use Models\Post;
use Models\TestSecond;
// END OF MODELS IMPORT - DO NOT REMOVE/MODIFY THIS COMMENT

use PermissionsManager;

class AdminViewsManager
{
    /*
    |--------------------------------------------------------------------------
    | AdminViewsManager
    |--------------------------------------------------------------------------
    |
    | The AdminViewsManager ensures the right data is returned based on the
    | type of view that is requested.
    |
    | It exists so that we don't polute our regular managers with the admin
    | side functionality
    |
    */

    /**
     * This function returns required information to display on the admin
     * dashboard view
     *
     * @return array
     */
    public function getAdminDashboard()
    {
        $totalUsers = User::count();
        $suspendedUsers = User::where('status', config('constants.user_status.SUSPENDED'))->count();

        return(compact('totalUsers', 'suspendedUsers'));
    }

    /**
     * This function returns required information to display on the users
     * view
     *
     * @param int $perPage
     * @param string $search
     * @param string $status
     * @return array
     */
    public function getUsers($perPage = 15, $search = null, $status = null)
    {
        $users = User::select([
            'id',
            'email',
            'first_name',
            'last_name',
            'status',
            'created_at'
        ]);

        if ($search) {
            $users->where('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
        }

        if ($status) {
            $users->where('status', $status);
        }

        return [ 'data' => $users->paginate($perPage) ];
    }

    /**
     * This function returns required information to display on the roles
     * view
     *
     * @param int $perPage
     * @param string $search
     * @return array
     */
    public function getRoles($perPage = 15, $search = null)
    {
        $roles = Role::select([
            'id',
            'slug',
            'label'
        ]);

        if ($search) {
            $roles->where('slug', 'LIKE', "%$search%")
                ->orWhere('label', 'LIKE', "%$search%");
        }

        return [ 'data' => $roles->paginate($perPage) ];
    }

    /**
     * This function returns the requested user with their associated
     * roles as well as the roles that can be assigned
     *
     * @param $userId
     * @return array
     */
    public function showUserRoles($userId)
    {
        $user = User::select([
            'id',
            'email',
            'first_name',
            'last_name'
        ])->with('roles')
            ->where('id', $userId)
            ->where('status', config('constants.user_status.ACTIVE'))
            ->first();

        $roles = Role::all();

        return [
            'user' => $user,
            'roles' => $roles
        ];
    }

    /**
     * This function returns the users with their associated roles
     * as well as the roles that can be assigned
     *
     * @param int $perPage
     * @param string $search
     * @param string $role
     * @return array
     */
    public function getSyncRoles($perPage = 15, $search = null, $role = null)
    {
        $users = User::select([
            'id',
            'email',
            'first_name',
            'last_name',
        ]);

        $users->with('roles')
            ->where('status', config('constants.user_status.ACTIVE'));

        if ($role) {
            $users->whereHas('roles', function ($query) use ($role) {
                $query->where('slug', $role);
            });
        }

        if ($search) {
            $users->where('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
        }

        $roles = Role::all();

        return [
            'data' => $users->paginate($perPage),
            'roles' => $roles
        ];
    }

    /**
     * This function returns the requested role with their associated
     * permissions as well as the permissions that can be assigned
     *
     * @param $roleId
     * @return array
     */
    public function showRolesPermissions($roleId)
    {
        $role = Role::select([
            'id',
            'slug',
            'label',
        ])->with('permissions')
            ->where('id', $roleId)
            ->first();

        $permissions = Permission::all();

        return [
            'role' => $role,
            'permissions' => $permissions
        ];
    }

    /**
     * This function returns required information to display on the roles
     * view
     *
     * @param int $perPage
     * @param string $search
     * @return array
     */
    public function getPermissions($perPage = 15, $search = null)
    {
        $permissions = Permission::select([
            'id',
            'slug',
            'label'
        ]);

        if ($search) {
            $permissions->where('slug', 'LIKE', "%$search%")
                ->orWhere('label', 'LIKE', "%$search%");
        }

        $permissions->orderBy('slug');

        $permissionsStatus = PermissionsManager::getPermissionsStatus();

        return [
            'data' => $permissions->paginate($perPage),
            'missing' => $permissionsStatus['missing'],
            'deprecated' => $permissionsStatus['deprecated']
        ];
    }

    /**
     * This function returns the roles with their associated permissions
     * as well as the permissions that can be assigned
     *
     * @param int $perPage
     * @param string $search
     * @return array
     */
    public function getSyncPermissions($perPage = 15, $search = null)
    {
        $roles = Role::select([
            'id',
            'slug',
            'label'
        ]);

        $roles->with('permissions');

        if ($search) {
            $roles->where('slug', 'LIKE', "%$search%")
                ->orWhere('label', 'LIKE', "%$search%");
        }

        $permissions = Permission::orderBy('slug')->get();

        return [
            'data' => $roles->paginate($perPage),
            'permissions' => $permissions
        ];
    }

    /**
     * This function returns the user profile representation for the
     * admin side of the website. If a user id is not passed, then
     * the authenticated user is returned
     *
     * @param int $userId
     * @return array
     */
    public function getProfile($userId = null)
    {
        $profileUserId = $userId;

        if (!$profileUserId) {
            $profileUserId = Auth::user()->id;
        }

        $user = User::with('roles')->findOrFail($profileUserId);

        return compact('user');
    }

    /**
     * This function returns the errors that were stored in the database
     * by the system log utility
     *
     * @param int $perPage
     * @param string $search
     * @return array
     */
    public function getErrors($perPage = 15, $search = null)
    {
        $errors = Error::select([
            'id',
            'type',
            'message',
            'stack_trace',
            'created_at'
        ]);

        if ($search) {
            $errors->where('type', 'LIKE', "%$search%")
                ->orWhere('message', 'LIKE', "%$search%")
                ->orWhere('stack_trace', 'LIKE', "%$search%");
        }

        return [ 'data' => $errors->paginate($perPage) ];
    }

	/**
	 * This function returns required information to display on the posts
	 * view
	 *
	 * @param int $perPage
	 * @param string $search
	 * @return array
	 */
	public function getPosts($perPage = 15, $search = null)
	{
		$posts = Post::select([
			'id',
			'title',
            'content',
			'created_at',
			'updated_at',
		]);

		if ($search) {
			$posts->where('field', 'LIKE', "%$search%"); // TODO
		};

		return [ 'data' => $posts->paginate($perPage) ];
	}

	// END OF ADMIN VIEWS - DO NOT REMOVE/DELETE THIS COMMENT
}
