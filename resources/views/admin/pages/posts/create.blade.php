@extends('layouts.admin', [
    'page_title' => 'Posts',
    'page_description' => 'Create',
    'breadcrums' => [
        [
            'url' => route('admin.posts.index'),
            'name' => 'Posts',
            'icon' => 'ion ion-bug',
        ], [
            'name' => 'Create',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">New post</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.posts.store'),
            'method' => 'POST',
            'enctype' => 'multipart/form-data'
        )) !!}
            <div class="box-body profile-form">

                @include('admin.pages.posts._form', [
                    'post' => null,
                    'postAvatar' => '/images/avatar_default.png',
                    'requiredPermission' => 'post_store',
                    'submitText' => 'Create post'
                ])

            </div>
        {!! Form::close() !!}
    </div>
@endsection
