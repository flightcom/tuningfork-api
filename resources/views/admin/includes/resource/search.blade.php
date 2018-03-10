<div class="box-tools pull-right">
    {!! Form::open(array(
        'method' => 'GET',
    )) !!}

    @if(request()->input('perPage'))
        {!! Form::hidden('perPage', request()->input('perPage')) !!}
    @endif

        <div class="input-group input-group-sm"
             style="width: 150px;"
        >
            {!! Form::text('search', request()->input('search'), array(
                'name' => 'search',
                'class' => 'form-control form-group',
                'placeholder' => 'Search...',
            )) !!}

            <div class="input-group-btn">
                <button type="submit"
                        class="btn btn-default btn-flat"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

    {!! Form::close() !!}
</div>