@if(count($missing))
    @if(authorized('sync_permissions'))
        <div class="col-xs-12 col-md-6">
            <div class="box box-warning">

                <div class="box-header">
                    <h3 class="box-title">
                        Missing Permissions
                    </h3>
                    {!! Form::open(array(
                            'url' => route('admin.permissions.sync.missing'),
                            'method' => 'POST',
                            'class' => 'resource-form pull-right'
                        )) !!}
                    <button class="btn btn-warning btn-flat">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                    </button>
                    {!! Form::close() !!}
                </div>

                <div class="box-body table-responsive no-padding">
                    <ul>
                        @foreach($missing as $missingPermission)
                            <li>{{ $missingPermission }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif
@endif

@if(count($deprecated))
    @if(authorized('sync_permissions'))
        <div class="col-xs-12 col-md-6">
            <div class="box box-danger">

                <div class="box-header">
                    <h3 class="box-title">
                        Deprecated Permissions
                    </h3>
                    {!! Form::open(array(
                           'url' => route('admin.permissions.sync.deprecated'),
                           'method' => 'POST',
                           'class' => 'resource-form pull-right'
                       )) !!}
                        <button class="btn btn-danger btn-flat">
                            <i class="fa fa-minus-square" aria-hidden="true"></i> Remove
                        </button>
                    {!! Form::close() !!}
                </div>

                <div class="box-body table-responsive no-padding">
                    <ul>
                        @foreach($deprecated as $deprecatedPermission)
                            <li>{{ $deprecatedPermission }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif
@endif