@if (isset($updatePermission))
    @if(authorized($updatePermission))
        <a href="{{ $editUrl }}" class="datatable-edit">
            <i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i>
        </a>
    @endif
@endif

@if (isset($deletePermission))
    @if(authorized($deletePermission))
        <a href="javascript:void(0)"
           class="datatable-delete"
           title="Delete"
        >
            <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>
    @endif
@endif
