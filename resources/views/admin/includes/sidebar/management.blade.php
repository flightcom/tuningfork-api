@if(authorized('user_index'))
    <li class="{{ activeRoute('admin.users.index') }}">
        <a href="{{ route('admin.users.index') }}">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span> Users</span>
        </a>
    </li>
@endif

@if(authorized('post_index'))
	<li class="{{ activeRoute('admin.posts.index') }}">
		<a href="{{ route('admin.posts.index') }}">
			<i class="ion ion-bug" aria-hidden="true"></i>
			<span> Posts</span>
		</a>
	</li>
@endif

{{--END OF MANAGEMENT LINKS - DO NOT REMOVE/MODIFY THIS COMMENT--}}