@if (session('type') && session('type') === 'success')
    <div class="alert alert-success alert-dismissible system-alert"
         role="alert"
    >
        <button type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
        >
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fa fa-check" aria-hidden="true"></i> {{ session('message') }}
    </div>
@endif

@if (session('type') && session('type') === 'error')
    <div class="alert alert-danger alert-dismissible system-alert"
         role="alert"
    >
        <button type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
        >
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fa fa-times" aria-hidden="true"></i> {{ session('message') }}
    </div>
@endif