{!! Form::open(array(
            'url' => route('admin.users.update', [
                'users' => $user->id
            ]),
            'method' => 'PUT'
        )) !!}

    @if ($user->status !== config('constants.user_status.SUSPENDED'))
        <input type="hidden"
               name="status"
               value="{{ config('constants.user_status.SUSPENDED') }}"
               class="datatable-confirm"
        />
        <button class="btn btn-danger btn-flat btn-block">
            <b>Suspend</b>
        </button>
    @else
        <input type="hidden"
               name="status"
               value="{{ config('constants.user_status.ACTIVE') }}"
               class="datatable-confirm"
        />
        <button class="btn btn-success btn-flat btn-block">
            <b>Activate</b>
        </button>
    @endif

{!! Form::close() !!}