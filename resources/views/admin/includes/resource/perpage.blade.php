{!! Form::open(array(
    'method' => 'GET',
    'id' => 'per-page-form'
)) !!}
{!! Form::label('perPage', '#') !!}
{!! Form::select('perPage', [
    '15' => 15,
    '25' => 25,
    '50' => 50,
    '100' => 100
], $data->perPage(), [
    'class' => 'form-control',
    'id' => 'per-page-selector'
]) !!}

@if(request()->input('search'))
    {!! Form::hidden('search', request()->input('search')) !!}
@endif
@if(request()->input('status'))
    {!! Form::hidden('status', request()->input('status')) !!}
@endif
{!! Form::close() !!}