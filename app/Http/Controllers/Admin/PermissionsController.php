<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use AdminViewsManager;
use PermissionsManager;

use Gate;

class PermissionsController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:permission')
            ->except('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        return view('admin.pages.permissions.index')
            ->with(AdminViewsManager::getPermissions($perPage, $search));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $slug required, unique
     * @param string $label optional
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|max:255|unique:permissions',
            'label' => 'sometimes|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withInput(
                $request->all()
            )->withErrors($validator->errors());
        }

        try {
            PermissionsManager::store($request->all());

            return redirect()->route('admin.permissions.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Permissions synced'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.permissions.edit')
                ->with([
                    'type' => 'error',
                    'message' => 'Error syncing permissions'
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.pages.permissions.edit')->with([
            'permission' => PermissionsManager::show($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $slug required, unique
     * @param string $label optional
     * @param int $permission The permission id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'sometimes|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withInput(
                $request->all()
            )->withErrors($validator->errors());
        }

        try {
            PermissionsManager::update($request->only('label'), $id);

            return redirect()->route('admin.permissions.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Permission updated'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.permissions.edit')
                ->with([
                    'type' => 'error',
                    'message' => 'Error updating permission'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $permission The permission id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            PermissionsManager::destroy($id);

            return redirect()->route('admin.permissions.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Permissions deleted'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.permissions.edit')
                ->with([
                    'type' => 'error',
                    'message' => 'Error deleting permissions'
                ]);
        }
    }
}
