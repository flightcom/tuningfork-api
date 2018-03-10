<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th class="hide-table-xs">Slug</th>
            <th colspan="2">Label</th>
        </tr>
        @foreach ($data as $item)

            <tr>
                <td class="hide-table-xs">{{ $item->slug }}</td>
                <td>{{ $item->label }}</td>
                <td>
                    <div class="datatable-actions">
                        @include('admin.includes.datatable.actions', [
                            'updatePermission' => 'role_update',
                            'deletePermission' => 'role_destroy',
                            'editUrl' => route('admin.roles.edit', $item->id)
                        ])
                    </div>
                    <div class="datatable-delete-confirmation hide">
                        @include('admin.includes.datatable.confirm', [
                            'route' => 'admin.roles.destroy',
                            'type' => 'roles',
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