@extends('layouts.admin', [
    'page_title' => 'Error',
    'breadcrums' => [
        [
            'url' => route('admin.errors.index'),
            'name' => 'System Errors',
            'icon' => 'ion ion-android-warning',
        ], [
            'name' => 'Error',
            'active' => true,
        ],
    ]
])

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="stack-trace-container">
                {!! str_replace('#', '<br>#', $error->stack_trace) !!}
            </div>
        </div>
    </div>
@endsection