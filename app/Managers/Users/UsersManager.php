<?php

namespace Managers\Users;

use Models\User;
use JWTAuth;
use FilesManager;

class UsersManager
{
    /*
    |--------------------------------------------------------------------------
    | UsersManager
    |--------------------------------------------------------------------------
    |
    | The UsersManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return User::paginate();
    }

    /**
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
        $userStatus = config('constants.default_user_status');

        if ($data['status']) {
            if (!array_key_exists($data['status'], config('constants.user_status'))) {
                return null;
            }

            $userStatus = config('constants.user_status')[$data['status']];
        }

        $user = User::create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => $data['password'],
            'status' => $userStatus,
        ]);

        // If an avatar was added, save it
        if (array_key_exists('avatar', $data)) {
            $this->saveAvatar($user, $data['avatar']);
        }

        // We'll assign a role as without one, the user cannot have
        // access to any of the resources we created
        $user->assignRole(config('constants.default_role'));

        return $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $user;
        }

        $trim = array_filter($data, function($value) { return !empty(trim($value)); });

        $user->fill($trim);

        // If an avatar was added, save it
        if (array_key_exists('avatar', $data)) {
            $this->saveAvatar($user, $data['avatar']);
        }

        return $user->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }

    protected function saveAvatar($user, $avatar)
    {
        $user->avatar()->delete();

        $file = FilesManager::store($avatar, 'avatars');
        $user->avatar()->save($file);
    }
}
