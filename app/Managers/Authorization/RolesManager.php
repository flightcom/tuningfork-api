<?php

namespace Managers\Authorization;

use Models\Role;
use Models\User;

class RolesManager
{
    /*
    |--------------------------------------------------------------------------
    | RolesManager
    |--------------------------------------------------------------------------
    |
    | The RolesManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return Role::paginate();
    }

    /**
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
        return Role::create([
            'slug' => $data['slug'],
            'label' => $data['label'],
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Role::find($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $role = Role::findOrFail($id);

        $role->fill($data);

        return $role->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return Role::destroy($id);
    }

    /**
     * @param $roles
     * @param $userId
     */
    public function syncUserRoles($roles, $userId)
    {
        $user = User::findOrFail($userId);

        return $user->roles()->sync($roles ? $roles : []);
    }
}
