<ul class="resource-filter-container">
    <li>
        <a href="{{ route('admin.users.roles') }}"
           class="{{ !request()->input('role') ? 'active' : '' }}"
        >
            ALL
        </a>
    </li>
    @foreach($roles as $role)
        <li>
            <a href="{{ route('admin.users.roles', 'role='.$role->slug) }}"
               class="{{ request()->input('role') === $role->slug ? 'active' : '' }}"
            >
                {{ $role->label }}
            </a>
        </li>
    @endforeach
</ul>