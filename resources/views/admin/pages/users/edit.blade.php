@extends('layouts.admin', [
    'page_title' => 'User Management',
    'page_description' => 'Edit',
    'breadcrums' => [
        [
            'url' => route('admin.users.index'),
            'name' => 'User Management',
            'icon' => 'fa fa-user',
        ], [
            'name' => 'Edit',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit user</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.users.update', $user->id),
            'method' => 'PUT',
            'enctype' => 'multipart/form-data'
        )) !!}
        <div class="box-body profile-form">

            @include('admin.pages.users._form', [
                'user' => $user,
                'userAvatar' => $user->avatar ? $user->avatar : '/images/avatar_default.png',
                'requiredPermission' => 'user_update',
                'submitText' => 'Update user'
            ])

        </div>
        {!! Form::close() !!}
    </div>
@endsection