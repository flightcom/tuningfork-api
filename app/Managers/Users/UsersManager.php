<?php

namespace Managers\Users;

use App\Notifications\UserCreated;
use Models\Location;
use Models\User;
use Models\Role;
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
     *
     * @return static
     */
    public function store(array $data)
    {
        $userStatus = config('constants.default_user_status');

        if (isset($data['status'])) {
            if (!array_key_exists($data['status'], config('constants.user_status'))) {
                return null;
            }

            $userStatus = config('constants.user_status')[$data['status']];
        }

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'birth_date' => $data['birth_date'] ? date('Y-m-d', strtotime($data['birth_date'])) : date('Y-m-d'),
            'password' => $data['password'],
            'status' => $userStatus,
        ]);

        // If an avatar was added, save it
        if (array_key_exists('avatar', $data)) {
            $this->saveAvatar($user, $data['avatar']);
        }

        // If location, save it
        if (array_key_exists('location', $data)) {
            $location = Location::create($data['location']);
            $user->location()->save($location);
        }

        // Role
        if (array_key_exists('roles', $data)) {
            $role = Role::find($data['roles'][0]['id']);
            if ($role) {
                $user->assignRole($role);
            }
        } else {
            // We'll assign a role as without one, the user cannot have
            // access to any of the resources we created
            $role = Role::where('slug', config('constants.default_user_role'))->first();
            $user->assignRole($role);
        }

        $user->notify(new UserCreated($user));

        return $user;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return User::find($id)->load('location', 'roles');
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $user;
        }

        $user->fill($data);

        // If an avatar was added, save it
        if (array_key_exists('avatar', $data)) {
            $this->saveAvatar($user, $data['avatar']);
        }

        // If location, save it
        if (array_key_exists('location', $data)) {
            $user->location->fill($data['location']);
            $user->location->save();
        }

        // Role
        if (array_key_exists('roles', $data)) {
            $role = Role::find($data['roles'][0]['id']);
            if ($role) {
                $user->assignRole($role);
            }
        } else {
            // We'll assign a role as without one, the user cannot have
            // access to any of the resources we created
            $role = Role::where('slug', config('constants.default_user_role'))->first();
            $user->assignRole($role);
        }

        return $user->save();
    }

    /**
     * @param $id
     *
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

    /**
     * This function returns required information to display on the users
     * view.
     *
     * @param int    $perPage
     * @param string $search
     * @param string $status
     *
     * @return array
     */
    public function search($perPage = 15, $filter = null, $sort = null)
    {
        $users = User::query();

        if ($filter) {
            foreach ($filter as $key => $value) {
                $users->where($key, 'LIKE', "%$value%");
            }
        }

        if ($sort) {
            list($field, $direction) = $sort;
            $users->orderBy($field, $direction);
        }

        return $users->paginate($perPage);
    }
}
