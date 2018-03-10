<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use AdminViewsManager;
use UsersManager;
use RolesManager;
use PermissionsManager;

use Gate;

class AuthorizationController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('permission:sync_roles')
            ->only([
                'showUserRoles',
                'getSyncRoles',
                'syncRoles'
            ]);

        $this->middleware('permission:sync_permissions')
            ->only([
                'showRolesPermissions',
                'getSyncPermissions',
                'syncPermissions',
                'addMissingPermissions',
                'removeDeprecatedPermissions'
            ]);
    }

    /**
     * Display the user roles form for one user
     *
     * @return \Illuminate\Http\Response
     */
    public function showUserRoles(Request $request, $id)
    {
        return view('admin.pages.roles.assign')
            ->with(AdminViewsManager::showUserRoles($id));
    }

    /**
     * Display a listing of the resource modified to
     * view the roles of users
     *
     * @return \Illuminate\Http\Response
     */
    public function getSyncRoles(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $role = $request->input('role');

        return view('admin.pages.roles.users')
            ->with(AdminViewsManager::getSyncRoles($perPage, $search, $role));
    }

    /**
     * Syncs the user roles with the given user
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncRoles(Request $request, $id)
    {
        try {
            RolesManager::syncUserRoles($request->input('roles'), $id);

            return redirect()->route('admin.users.roles')
                ->with([
                    'type' => 'success',
                    'message' => 'Roles synced'
                ]);
        } catch (Exception $e) {
            return redirect()->route('users.roles.show', $id)
                ->with([
                    'type' => 'error',
                    'message' => 'Error syncing roles'
                ]);
        }
    }

    /**
     * Display the role permissions form for one role
     *
     * @return \Illuminate\Http\Response
     */
    public function showRolesPermissions(Request $request, $id)
    {
        return view('admin.pages.permissions.assign')
            ->with(AdminViewsManager::showRolesPermissions($id));
    }

    /**
     * Display a listing of the resource modified to
     * view the permissions of roles
     *
     * @return \Illuminate\Http\Response
     */
    public function getSyncPermissions(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        return view('admin.pages.permissions.roles')
            ->with(AdminViewsManager::getSyncPermissions($perPage, $search));
    }

    /**
     * Syncs the permissions with the given role
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncPermissions(Request $request, $id)
    {
        try {
            PermissionsManager::syncRolePermissions($request->input('permissions'), $id);

            return redirect()->route('admin.roles.permissions')
                ->with([
                    'type' => 'success',
                    'message' => 'Permissions synced'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.roles.permissions')
                ->with([
                    'type' => 'error',
                    'message' => 'Error syncing permissions'
                ]);
        }
    }

    /**
     * Adds missing permissions to the database
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMissingPermissions()
    {
        try {
            PermissionsManager::addMissingPermissions();

            return redirect()->route('admin.permissions.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Permissions added'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.permissions.index')
                ->with([
                    'type' => 'error',
                    'message' => 'Error adding permissions'
                ]);
        }
    }

    /**
     * Removes deprecated permissions from the database
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeDeprecatedPermissions()
    {
        try {
            PermissionsManager::removeDeprecatedPermissions();

            return redirect()->route('admin.permissions.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Permissions removed'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.permissions.index')
                ->with([
                    'type' => 'error',
                    'message' => 'Error removing permissions'
                ]);
        }
    }
}
