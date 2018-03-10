@extends('layouts.admin', [
    'page_title' => 'System Errors',
])

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">

                    <div class="row">
                        <div class="col-xs-12">
                            <h3 class="box-title">Errors</h3>
                        </div>

                        <div class="clearfix"></div>
                        <br />

                        <div class="col-xs-6">
                            @include('admin.includes.resource.perpage')
                        </div>

                        <div class="col-xs-6">
                            @include('admin.includes.resource.search')
                        </div>
                    </div>
                </div>

                @include('admin.pages.errors._datatable', [
                    'data' => $data
                ])

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h5>
                @include('admin.includes.resource.entries', [
                    'data' => $data
                ])
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @include('admin.includes.resource.pagination')
        </div>
    </div>
@endsection