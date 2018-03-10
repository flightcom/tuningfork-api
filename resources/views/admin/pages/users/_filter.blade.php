<ul class="resource-filter-container">
    <li>
        <a href="{{ route('admin.users.index') }}"
           class="{{ !request()->input('status') ? 'active' : '' }}"
        >
            ALL
        </a>
    </li>
    @foreach(config('constants.user_status') as $status)
        <li>
            <a href="{{ route('admin.users.index', 'status='.$status) }}"
               class="{{ request()->input('status') === $status ? 'active' : '' }}"
            >
                {{ $status }}
            </a>
        </li>
    @endforeach
</ul>