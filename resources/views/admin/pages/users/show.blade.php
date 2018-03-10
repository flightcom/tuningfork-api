@extends('layouts.admin', [
    'page_title' => 'Profile',
    'page_description' => $user->first_name . ' ' . $user->last_name,
    'breadcrums' => [
        [
            'url' => route('admin.users.index'),
            'name' => 'User Management',
            'icon' => 'fa fa-user',
        ], [
            'name' => 'Profile',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-3">

            @include('admin.pages.users.profile.main')
            @include('admin.pages.users.profile.about')

        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#logs" data-toggle="tab" aria-expanded="false">Logs</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="logs">
                        @include('admin.includes.logs', [
                            'model' => $user
                        ])
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
@endsection