<li class="treeview">
    <a href="#">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span>Authorization</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

        @if(authorized('role_index'))
            <li>
                <a href="{{ route('admin.roles.index') }}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i>
                    Roles
                </a>
            </li>
        @endif

        @if(authorized('sync_roles'))
            <li>
                <a href="{{ route('admin.users.roles') }}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i>
                    Assign Roles
                </a>
            </li>
        @endif

        @if(authorized('permission_index'))
            <li>
                <a href="{{ route('admin.permissions.index') }}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i>
                    Permissions
                </a>
            </li>
        @endif

        @if(authorized('sync_permissions'))
            <li>
                <a href="{{ route('admin.roles.permissions') }}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i>
                    Assign Permissions
                </a>
            </li>
        @endif

    </ul>
</li>