<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th>Title</th>
            <th>Created at</th>
            <th colspan="2">Updated at</th>
        </tr>
        @foreach ($data as $item)

            <tr>
                <td>
                    {{ $item->title }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
                <td>
                    {{ $item->updated_at }}
                </td>
                <td>
                    <div class="datatable-actions">
                        @if(authorized('post_show'))
                            <a class="datatable-show"
                               href="{{ route('admin.posts.show', $item->id) }}"
                            >
                                <i class="fa fa-file" aria-hidden="true"></i>
                            </a>
                        @endif
                        @include('admin.includes.datatable.actions', [
                            'editUrl' => route('admin.posts.edit', [
                                'id' => $item->id
                            ]),
                            'updatePermission' => 'post_update',
                            'deletePermission' => 'post_delete'
                        ])
                    </div>
                    <div class="datatable-delete-confirmation hide">
                        @include('admin.includes.datatable.confirm', [
                            'route' => 'admin.posts.destroy',
                            'type' => 'posts',
                            'id' => $item->id
                        ])
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
<!-- /.box-body -->
