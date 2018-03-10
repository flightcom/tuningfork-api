<?php

namespace Managers\Authentication;

use Models\User;
use Models\Permission;
use JWTAuth;

class AuthManager
{
    /*
    |--------------------------------------------------------------------------
    | AuthManager
    |--------------------------------------------------------------------------
    |
    | The AuthManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @param array $credentials
     * @return null
     */
    public function authenticate(array $credentials)
    {
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return null;
        }

        $user = User::where('email', $credentials['email'])->first();

        // Now we want to make sure the user is authorized to
        // log in based on their account status
        if ($user->status !== config('constants.user_status.ACTIVE') && !$user->isSuperAdmin()) {
            return false;
        }

        $user->token = $token;
        return $user;
    }

    /**
     * @return mixed
     */
    public function invalidate()
    {
        return JWTAuth::invalidate(JWTAuth::parseToken()->getToken()->get());
    }

    /**
     * @return mixed
     */
    public function whoAmI() {
        return JWTAuth::parseToken()->toUser();
    }

    /**
     * @param array $user
     * @return static
     */
    public function registerUser(array $user)
    {
        $user = User::create([
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'password' => $user['password'],
            'status' => config('constants.default_user_status'),
        ]);

        if (config('constants.default_role')) {
            $user->assignRole(config('constants.default_role'));
        }

        $user->token = JWTAuth::fromUser($user);

        return $user;
    }

    /**
     * Verifies if a user has access to the backend
     *
     * Returns null if the user doesn't exist. Otherwise, true or
     * false depending if the user is an admin or not
     *
     * @param $email
     * @return null
     */
    public function hasBackendAccess($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        // If it's the root user, they have access
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Otherwise, it definitely needs to be at least an active user
        if ($user->status !== config('constants.user_status.ACTIVE')) {
            return null;
        }

        $permission = Permission::where('slug', 'backend_access')
            ->with('roles')
            ->first();

        // This should only happen if we didn't set it in the database
        if (!$permission) {
            return null;
        }

        return $user->hasRole($permission->roles);
    }
}
