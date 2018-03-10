{!! Form::open(array(
    'url' => route('admin.users.update', ['users' => $item->id]),
    'method' => 'PUT'
)) !!}

<a href="javascript:void(0)"
   onclick="parentNode.submit();"
   class="datatable-status"
   title="{{ $item->status !== config('constants.user_status.SUSPENDED') ? 'Suspend' : 'Unlock' }}"
>
    @if ($item->status !== config('constants.user_status.SUSPENDED'))
        <input type="hidden"
               name="status"
               value="{{ config('constants.user_status.SUSPENDED') }}"
               class="datatable-confirm"
        />
        <i class="fa fa-lock" aria-hidden="true"></i>
    @else
        <input type="hidden"
               name="status"
               value="{{ config('constants.user_status.ACTIVE') }}"
               class="datatable-confirm"
        />
        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
    @endif
</a>

{!! Form::close() !!}