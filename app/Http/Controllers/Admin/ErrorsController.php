<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use AdminViewsManager;
use ErrorsManager;

use Gate;

class ErrorsController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:error');
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

        return view('admin.pages.errors.index')
            ->with(AdminViewsManager::getErrors($perPage, $search));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.pages.errors.show')
            ->with(['error' => ErrorsManager::show($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            ErrorsManager::destroy($id);

            return redirect()->route('admin.errors.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Error deleted'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.errors.index')
                ->with([
                    'type' => 'error',
                    'message' => 'Error deleting item'
                ]);
        }
    }
}
