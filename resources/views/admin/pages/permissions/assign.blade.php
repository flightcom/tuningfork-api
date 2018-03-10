@extends('layouts.admin', [
    'page_title' => 'Role Permissions',
    'page_description' => 'Assign',
    'breadcrums' => [
        [
            'url' => route('admin.roles.permissions'),
            'name' => 'Role Permissions',
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
            <h3 class="box-title">Assign Permissions - {{ $role->label }}</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.roles.permissions.sync', $role->id),
            'method' => 'POST',
        )) !!}
        @include('admin.pages.permissions._permissions', [
            'role' => $role,
            'permissions' => $permissions
        ])
        {!! Form::close() !!}
    </div>
@endsection