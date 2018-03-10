@extends('layouts.admin', [
    'page_title' => 'User Management',
    'page_description' => 'Create',
    'breadcrums' => [
        [
            'url' => route('admin.users.index'),
            'name' => 'User Management',
            'icon' => 'fa fa-user',
        ], [
            'name' => 'Create',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">New user</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.users.store'),
            'method' => 'POST',
            'enctype' => 'multipart/form-data'
        )) !!}
            <div class="box-body profile-form">

                @include('admin.pages.users._form', [
                    'user' => null,
                    'userAvatar' => '/images/avatar_default.png',
                    'requiredPermission' => 'user_store',
                    'submitText' => 'Create user'
                ])

            </div>
        {!! Form::close() !!}
    </div>
@endsection