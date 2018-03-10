@extends('layouts.admin', [
    'page_title' => 'User Roles',
    'page_description' => 'Assign',
    'breadcrums' => [
        [
            'url' => route('admin.users.roles'),
            'name' => 'User Roles',
            'icon' => 'fa fa-users',
        ], [
            'name' => 'Assign',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Assign Roles - {{ $user->first_name }} {{ $user->last_name }}</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.users.roles.sync', $user->id),
            'method' => 'POST',
        )) !!}
            @include('admin.pages.roles._roles', [
                'user' => $user,
                'roles' => $roles
            ])
        {!! Form::close() !!}
    </div>
@endsection