<?php

namespace Managers\Authorization;

use Models\Permission;
use Models\Role;

class PermissionsManager
{
    /*
    |--------------------------------------------------------------------------
    | PermissionsManager
    |--------------------------------------------------------------------------
    |
    | The PermissionsManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return Permission::paginate();
    }

    /**
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
        return Permission::create([
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
        return Permission::find($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $role = Permission::findOrFail($id);

        $role->fill($data);

        return $role->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return Permission::destroy($id);
    }

    /**
     * @param $permissions
     * @param $roleId
     */
    public function syncRolePermissions($permissions, $roleId)
    {
        $role = Role::findOrFail($roleId);

        return $role->permissions()->sync($permissions ? $permissions : []);
    }

    /**
     * Returns an array of all permissions required in the application.
     *
     * App permissions are composed of model permissions and system
     * permissions defined in the config/constants.php
     *
     * @return array
     */
    public function getPermissionsStatus()
    {
        $appPermissions = $this->getAppPermissions();

        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator(Permission::select('slug')->get()->toArray()));
        $dbPermissions = iterator_to_array($it, false);

        return [
            'missing' => $this->getMissingPermissions($appPermissions, $dbPermissions),
            'deprecated' => $this->getDeprecatedPermissions($appPermissions, $dbPermissions)
        ];
    }

    /**
     * Returns the app permissions by scanning the models directory
     * and merging it with the system permissions defined in the
     * config/constants.php
     *
     * @return array
     */
    protected function getAppPermissions()
    {
        $permissions = [];

        // Scanning the models directory for all files
        $modelFiles = scandir(app_path(config('constants.models_directory')));

        // We're gonna add the appropriate permissions for each model
        foreach($modelFiles as $model) {
            $phpExtensionPosition = strpos($model, '.php');

            // If it's at position 0, it's likely not a model anyway
            if (!$phpExtensionPosition) {
                continue;
            }

            $modelName = $this->toUnderscores(substr($model, 0, $phpExtensionPosition));

            $permissions[] = $modelName.'_index';
            $permissions[] = $modelName.'_show';
            $permissions[] = $modelName.'_store';
            $permissions[] = $modelName.'_update';
            $permissions[] = $modelName.'_destroy';
        }

        $permissions = array_filter($permissions, function ($permission) {
            return !in_array($permission, config('constants.ignore_permissions'));
        });

        return array_merge($permissions, config('constants.system_permissions'));
    }

    /**
     * Converts a camelCase or PascalCase input to underscores
     *
     * thisWould becomes this_would
     * ThisWould becomes this_would
     *
     * @param $input
     * @return string
     */
    protected function toUnderscores($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Returns an array of permissions that are not yet in the
     * database
     *
     * @param $appPermissions
     * @param $dbPermissions
     * @return array
     */
    protected function getMissingPermissions($appPermissions, $dbPermissions)
    {
        return array_filter($appPermissions, function ($appPermission) use ($dbPermissions) {
            return !in_array($appPermission, $dbPermissions);
        });
    }

    /**
     * Returns an array of permissions that are in the database but
     * are no longer required either because the model no longer
     * exists, or because the system permission was removed
     * from config/constants.php
     *
     * @param $appPermissions
     * @param $dbPermissions
     * @return array
     */
    protected function getDeprecatedPermissions($appPermissions, $dbPermissions)
    {
        return array_filter($dbPermissions, function ($dbPermission) use ($appPermissions) {
            return !in_array($dbPermission, $appPermissions);
        });
    }

    /**
     * Adds all the missing permissions in the database
     */
    public function addMissingPermissions()
    {
        $permissionsStatus = $this->getPermissionsStatus();

        foreach($permissionsStatus['missing'] as $permission) {
            $delimiter = strpos($permission, '_');

            $label = strtoupper(substr($permission, 0, 1));
            $label .= substr($permission, 1, $delimiter - 1);
            $label .= ' ';
            $label .= strtoupper(substr($permission, $delimiter + 1, 1));
            $label .= substr($permission, $delimiter + 2, strlen($permission));

            Permission::create([
                'slug' => $permission,
                'label' => $label
            ]);
        }
    }

    /**
     * Removes all the deprecated permissions fron the database
     */
    public function removeDeprecatedPermissions()
    {
        $permissionsStatus = $this->getPermissionsStatus();

        foreach($permissionsStatus['deprecated'] as $permission) {
            Permission::where('slug', $permission)
                ->delete();
        }
    }
}
