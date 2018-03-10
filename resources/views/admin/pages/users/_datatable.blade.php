<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th class="hide-table-xs"></th>
            <th class="hide-table-xs">Name</th>
            <th>Email</th>
            <th class="hide-table-md">Status</th>
            <th class="hide-table-sm">Created at</th>
            <th></th>
        </tr>
        @foreach ($data as $item)

            <tr>
                <td class="hide-table-xs">
                    <img class="img-circle"
                         style="width:25px;height:25px;"
                         src="{{ $item->avatar ? $item->avatar : '/images/avatar_default.png' }}"
                    />
                </td>
                <td class="hide-table-xs">
                    {{ $item->first_name }} {{ $item->last_name }}
                </td>
                <td>
                    {{ $item->email }}
                </td>
                <td class="hide-table-md">
                    {{ $item->status }}
                </td>
                <td class="hide-table-sm">
                    {{ $item->created_at }}
                </td>
                <td style="min-width: 100px;">
                    <div class="datatable-actions">
                        @if(authorized('user_show'))
                            <a class="datatable-show"
                               href="{{ route('admin.users.show', $item->id) }}"
                            >
                                <i class="fa fa-file" aria-hidden="true"></i>
                            </a>
                        @endif
                        @include('admin.includes.datatable.actions', [
                            'editUrl' => route('admin.users.edit', [
                                'id' => $item->id
                            ]),
                            'updatePermission' => 'user_update',
                            'deletePermission' => 'user_destroy'
                        ])
                        @if(authorized('user_update'))
                            @include('admin.pages.users._actions')
                        @endif
                    </div>
                    <div class="datatable-delete-confirmation hide">
                        @include('admin.includes.datatable.confirm', [
                            'route' => 'admin.users.destroy',
                            'type' => 'users',
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