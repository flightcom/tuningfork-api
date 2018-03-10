<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th>Type</th>
            <th>Message</th>
            <th colspan="3">Created at</th>
        </tr>
        @foreach ($data as $item)

            <tr>
                <td>{{ $item->type }}</td>
                <td class="truncate"
                    style="max-width: 500px;"
                >{{ $item->message }}</td>
                <td style="min-width: 160px;">{{ $item->created_at }}</td>
                <td style="min-width: 70px;">
                    <div class="datatable-actions">
                        @if(authorized('error_show'))
                            <a class="datatable-show"
                               href="{{ route('admin.errors.show', $item->id) }}"
                            >
                                <i class="fa fa-file" aria-hidden="true"></i>
                            </a>
                        @endif
                        @include('admin.includes.datatable.actions', [
                            'deletePermission' => 'error_delete'
                        ])
                    </div>
                    <div class="datatable-delete-confirmation hide">
                        @include('admin.includes.datatable.confirm', [
                            'route' => 'admin.errors.destroy',
                            'type' => 'errors',
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