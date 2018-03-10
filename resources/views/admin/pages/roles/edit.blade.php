@extends('layouts.admin', [
    'page_title' => 'Roles',
    'page_description' => 'Edit',
    'breadcrums' => [
        [
            'url' => route('admin.roles.index'),
            'name' => 'Roles',
            'icon' => 'fa fa-users',
        ], [
            'name' => 'Edit',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit role</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.roles.update', $role->id),
            'method' => 'PUT',
        )) !!}
        <div class="box-body profile-form">

            @include('admin.pages.roles._form', [
                'role' => $role,
                'requiredPermission' => 'role_update',
                'submitText' => 'Update role'
            ])

        </div>
        {!! Form::close() !!}
    </div>
@endsection