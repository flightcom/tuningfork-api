<!-- About Me Box -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">About</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body break-word">
        <strong>
            <i class="fa fa-envelope" aria-hidden="true"></i> Email
        </strong>

        <p class="text-muted">
            {{ $user->email }}
        </p>

        <hr>

        <strong>
            <i class="fa fa-calendar" aria-hidden="true"></i> User since
        </strong>

        <p class="text-muted">{{ $user->created_at }}</p>

        <hr>

        <strong>
            <i class="fa fa-calendar" aria-hidden="true"></i> Last updated
        </strong>

        <p class="text-muted">{{ $user->updated_at }}</p>

        <hr>

        <strong><i class="fa fa-pencil margin-r-5"></i> Roles</strong>

        <p>
            @foreach($user->roles as $role)
                <span class="label label-success">{{ $role->label }}</span>
            @endforeach

            @if(count($user->roles) === 0)
                <span class="label label-danger">No roles</span>
            @endif
        </p>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->