<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use AdminViewsManager;
use UsersManager;

use Gate;
use Auth;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:user')
            ->only(['index', 'store']);

        $this->middleware('own:user')
            ->except(['index', 'store', 'create']);

        $this->middleware('permission:user_store')
            ->only(['create']);
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
        $status = $request->input('status');

        return view('admin.pages.users.index')
            ->with(AdminViewsManager::getUsers($perPage, $search, $status));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $email required, unique
     * @param string $first_name optional
     * @param string $last_name optional
     * @param string $password required
     * @param string $password_confirmation required
     * @param string $status optional
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'password' => 'required|confirmed',
            'status' => 'sometimes|string|max:30',
            'avatar' => 'sometimes|image',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->except([
                'password',
                'password_confirmation'
            ]))->withErrors($validator->errors());
        }

        try {
            UsersManager::store($request->all());

            return redirect()->route('admin.users.index')
                ->with([
                    'type' => 'success',
                    'message' => 'User created'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.users.create')
                ->with([
                    'type' => 'error',
                    'message' => 'Error creating user'
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
        return view('admin.pages.users.edit')->with([
            'user' => UsersManager::show($id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        return view('admin.pages.users.show')
            ->with(AdminViewsManager::getProfile($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $email optional, unique
     * @param string $first_name optional
     * @param string $last_name optional
     * @param string $password optional
     * @param string $password_confirmation optional if password not set
     * @param string $status optional
     * @param int $user The user id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|email|max:255|unique:users,email,'.$id,
            'first_name' => 'sometimes|max:255',
            'last_name' => 'sometimes|max:255',
            'password' => 'sometimes|confirmed',
            'status' => 'sometimes|string|max:30',
            'avatar' => 'sometimes|image',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->except([
                'password',
                'password_confirmation'
            ]))->withErrors($validator->errors());
        }

        try {
            UsersManager::update($request->all(), $id);

            return back()
                ->with([
                    'type' => 'success',
                    'message' => 'User updated'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.users.edit')
                ->with([
                    'type' => 'error',
                    'message' => 'Error updating user'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $user The user id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            UsersManager::destroy($id);

            return redirect()->route('admin.users.index')
                ->with([
                    'type' => 'success',
                    'message' => 'User deleted'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.users.index')
                ->with([
                    'type' => 'error',
                    'message' => 'Error deleting user'
                ]);
        }
    }
}
