@extends('layouts.admin', [
    'page_title' => 'Roles',
    'page_description' => 'Create',
    'breadcrums' => [
        [
            'url' => route('admin.roles.index'),
            'name' => 'Roles',
            'icon' => 'fa fa-users',
        ], [
            'name' => 'Create',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">New role</h3>
        </div>

        {!! Form::open(array(
            'url' => route('admin.roles.store'),
            'method' => 'POST',
        )) !!}
        <div class="box-body profile-form">

            @include('admin.pages.roles._form', [
                'role' => null,
                'requiredPermission' => 'role_store',
                'submitText' => 'Create role'
            ])

        </div>
        {!! Form::close() !!}
    </div>
@endsection