@extends('layouts.admin', [
    'page_title' => 'Posts',
    'page_description' => 'Show',
    'breadcrums' => [
        [
            'url' => route('admin.posts.index'),
            'name' => 'Posts',
            'icon' => 'ion ion-bug',
        ], [
            'name' => 'Show',
            'active' => true,
        ],
    ]
])

@section('content')
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Posts</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <p><strong>ID:</strong></p>
                                <p>{{ $post->id }}</p>
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <p><strong>Title:</strong></p>
                                <p>{{ $post->title }}</p>
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <p><strong>Content:</strong></p>
                                <p>{{ $post->content }}</p>
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <p><strong>Created at:</strong></p>
                                <p>{{ $post->created_at }}</p>
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <p><strong>Updated at:</strong></p>
                                <p>{{ $post->updated_at }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="{{ route('admin.posts.edit', $post->id) }}">
                            <button class="btn btn-default btn-flat pull-right">
                                Edit
                            </button>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        @if(authorized('actionlog_index'))
            <div class="row">
                <div class="col-xs-12>
                    @include('admin.includes.logs', [
                        'model' => $post
                    ])
                </div>
            </div>
        @endif
@endsection

