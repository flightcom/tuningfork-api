<?php

namespace Managers\Posts;

use Models\Post;
use Auth;

class PostsManager
{
    /*
    |--------------------------------------------------------------------------
    | PostsManager
    |--------------------------------------------------------------------------
    |
    | The PostsManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return Post::paginate();
    }

    /**
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
        return Post::create([
            'user_id' => Auth::getUser()->id,
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Post::find($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $item = Post::find($id);

        if (!$item) {
            return $item;
        }

        $item->title = $data['title'];
        $item->content = $data['content'];

        return $item->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return Post::destroy($id);
    }
}
