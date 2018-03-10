<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use AdminViewsManager;
use RolesManager;

use Gate;

class RolesController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:role')
            ->except(['create', 'edit']);

        $this->middleware('permission:user_store')
            ->only('create');

        $this->middleware('permission:user_update')
            ->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        return view('admin.pages.roles.index')
            ->with(AdminViewsManager::getRoles($perPage, $search));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param string $slug required, unique
     * @internal param string $label optional
     *
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|max:255|unique:roles',
            'label' => 'sometimes|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withInput(
                $request->all()
            )->withErrors($validator->errors());
        }

        try {
            RolesManager::store($request->all());

            return redirect()->route('admin.roles.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Role created'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.roles.create')
                ->with([
                    'type' => 'error',
                    'message' => 'Error creating role'
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
        return view('admin.pages.roles.edit')->with([
            'role' => RolesManager::show($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param string $slug required, unique
     * @internal param string $label optional
     * @internal param int $role The role id
     *
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|max:255|unique:roles,slug,'.$id,
            'label' => 'sometimes|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withInput(
                $request->all()
            )->withErrors($validator->errors());
        }

        try {
            RolesManager::update($request->all(), $id);

            return back()
                ->with([
                    'type' => 'success',
                    'message' => 'Role updated'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.roles.edit')
                ->with([
                    'type' => 'error',
                    'message' => 'Error updating role'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param int $role The role id
     *
     */
    public function destroy($id)
    {
        try {
            RolesManager::destroy($id);

            return redirect()->route('admin.roles.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Role deleted'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.roles.index')
                ->with([
                    'type' => 'error',
                    'message' => 'Error deleting role'
                ]);
        }
    }
}
