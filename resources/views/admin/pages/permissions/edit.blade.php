@extends('layouts.admin', [
    'page_title' => 'Permissions',
    'page_description' => 'Edit',
    'breadcrums' => [
        [
            'url' => route('admin.permissions.index'),
            'name' => 'Permissions',
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
            <h3 class="box-title">Edit permission</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.permissions.update', $permission->id),
            'method' => 'PUT',
        )) !!}
        <div class="box-body profile-form">

            @include('admin.pages.permissions._form', [
                'permission' => $permission,
                'requiredPermission' => 'permission_update',
                'submitText' => 'Update permission'
            ])

        </div>
        {!! Form::close() !!}
    </div>
@endsection