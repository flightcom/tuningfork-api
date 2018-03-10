<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle"
             style="height: 100px;"
             src="{{ $user->avatar ? $user->avatar : '/images/avatar_default.png' }}"
             alt="User profile picture"
        >

        <h3 class="profile-username text-center">
            {{ $user->first_name . ' ' . $user->last_name }}
        </h3>

        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Status</b> <a class="pull-right">{{ $user->status }}</a>
            </li>
        </ul>

        @if(authorized('user_update'))
            @include('admin.pages.users.profile.suspend')

            <br />
        @endif

        @if(authorized('user_update') || $user->id === Auth::getUser()->id)
            <a href="{{ route('admin.users.edit', $user->id) }}">
                <button class="btn btn-primary btn-flat btn-block">
                    <b>Edit</b>
                </button>
            </a>
        @endif
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->