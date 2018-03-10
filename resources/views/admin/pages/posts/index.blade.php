@extends('layouts.admin', [
    'page_title' => 'Posts',
])

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 class="box-title">Posts</h3>

                            @if(authorized('post_store'))
                                <a href="{{ route('admin.posts.create') }}">
                                    <button class="btn btn-primary btn-flat pull-right">
                                        New
                                    </button>
                                </a>
                            @endif
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

                @include('admin.pages.posts._datatable', [
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
