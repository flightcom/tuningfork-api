<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use AdminViewsManager;
use PostsManager;

use Gate;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('RESTpermission:post')
            ->only(['index', 'store']);

        $this->middleware('own:post')
            ->except(['index', 'store', 'create']);

        $this->middleware('permission:post_store')
            ->only(['create']);
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

        return view('admin.pages.posts.index')
            ->with(AdminViewsManager::getPosts($perPage, $search));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $title required
     * @param text $content required
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withInput(
                $request->all()
            )->withErrors($validator->errors());
        }

        try {
            PostsManager::store($request->all());

            return redirect()->route('admin.posts.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Post created'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.posts.create')
                ->with([
                    'type' => 'error',
                    'message' => 'Error creating post'
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
        return view('admin.pages.posts.edit')->with([
            'post' => PostsManager::show($id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $posts The posts id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.pages.posts.show')
            ->with(['post' => PostsManager::show($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $title required
     * @param text $content required
     * @param int $posts The posts id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withInput(
                $request->all()
            )->withErrors($validator->errors());
        }

        try {
            PostsManager::update($request->all(), $id);

            return back()
                ->with([
                    'type' => 'success',
                    'message' => 'Post updated'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.posts.edit')
                ->with([
                    'type' => 'error',
                    'message' => 'Error updating post'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $posts The posts id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            PostsManager::destroy($id);

            return redirect()->route('admin.posts.index')
                ->with([
                    'type' => 'success',
                    'message' => 'Post deleted'
                ]);
        } catch (Exception $e) {
            return redirect()->route('admin.posts.index')
                ->with([
                    'type' => 'error',
                    'message' => 'Error deleting post'
                ]);
        }
    }
}
