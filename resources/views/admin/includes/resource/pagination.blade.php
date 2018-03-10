<nav class="pagination-container" aria-label="pagination">
    {!! $data->appends([
        'perPage' => request()->input('perPage'),
        'search' => request()->input('search'),
        'status' => request()->input('status'),
        'role' => request()->input('role')
    ])->render() !!}
</nav>