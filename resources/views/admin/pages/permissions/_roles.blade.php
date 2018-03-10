<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th class="hide-table-xs">Slug</th>
            <th>Label</th>
            <th colspan="2"># Permissions</th>
        </tr>
        @foreach ($data as $item)

            <tr>
                <td class="hide-table-xs">{{ $item->slug }}</td>
                <td>{{ $item->label }}</td>
                <td>
                    @if(count($item->permissions) === 0)
                        <span class="label label-danger">0</span>
                    @else
                        <span class="label label-success">{{ count($item->permissions) }}</span>
                    @endif
                </td>
                <td>
                    <div class="datatable-actions">
                        @include('admin.includes.datatable.actions', [
                            'updatePermission' => 'sync_permissions',
                            'editUrl' => route('admin.roles.permissions.show', $item->id)
                        ])
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
<!-- /.box-body -->