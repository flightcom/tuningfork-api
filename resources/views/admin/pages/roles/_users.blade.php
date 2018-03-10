<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th class="hide-table-xs">Name</th>
            <th>Email</th>
            <th colspan="2">Roles</th>
        </tr>
        @foreach ($data as $item)

            <tr>
                <td class="hide-table-xs">
                    {{ $item->first_name }} {{ $item->last_name }}
                </td>
                <td>{{ $item->email }}</td>
                <td>
                    @foreach($item->roles as $role)
                        <div>
                            <span class="label label-success">
                                {{ $role->label }}
                            </span>
                        </div>
                    @endforeach

                    @if(count($item->roles) === 0)
                        <span class="label label-danger">
                            No roles
                        </span>
                    @endif
                </td>
                <td>
                    <div class="datatable-actions">
                        @include('admin.includes.datatable.actions', [
                            'updatePermission' => 'sync_roles',
                            'editUrl' => route('admin.users.roles.show', $item->id)
                        ])
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
<!-- /.box-body -->