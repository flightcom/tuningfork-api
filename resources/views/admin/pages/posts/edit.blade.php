@extends('layouts.admin', [
    'page_title' => 'Posts',
    'page_description' => 'Edit',
    'breadcrums' => [
        [
            'url' => route('admin.posts.index'),
            'name' => 'Posts',
            'icon' => 'ion ion-bug',
        ], [
            'name' => 'Edit',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit post</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.posts.update', $post->id),
            'method' => 'PUT',
            'enctype' => 'multipart/form-data'
        )) !!}
        <div class="box-body profile-form">

            @include('admin.pages.posts._form', [
                'post' => $post,
                'requiredPermission' => 'post_update',
                'submitText' => 'Update post'
            ])

        </div>
        {!! Form::close() !!}
    </div>
@endsection

