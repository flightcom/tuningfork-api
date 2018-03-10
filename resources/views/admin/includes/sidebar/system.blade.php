@if(authorized('error_index'))
    <li class="{{ activeRoute('admin.errors.index') }}">
        <a href="{{ route('admin.errors.index') }}">
            <i class="ion ion-android-warning"></i>
            <span> System errors</span>
        </a>
    </li>
@endif
