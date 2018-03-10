{!! Form::open(array(
    'url' => route($route, [$type => $id]),
    'method' => 'DELETE'
)) !!}

<a href="javascript:void(0)"
   onclick="parentNode.submit();"
   class="datatable-confirm"
   title="Delete"
>
    <i class="fa fa-check" aria-hidden="true"></i>
</a>

{!! Form::close() !!}

<a href="javascript:void(0)"
   class="datatable-cancel"
   title="cancel"
>
    <i class="fa fa-times" aria-hidden="true"></i>
</a>