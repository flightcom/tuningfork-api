<div class="{{ $errors->has($fieldName) ? ' has-error' : '' }}">
    {!! Form::label($fieldName, $fieldLabel) !!}

    @if(isset($fieldDisabled) && $fieldDisabled)
        <input id="{{ $fieldName }}"
               name="{{ $fieldName }}"
               class="form-control form-group"
               value="{{ $fieldValue }}"
               disabled
        />
    @else
        {!! Form::select(
            $fieldName,
            $fieldOptions,
            old($fieldName) ? old($fieldName) : $fieldValue,
            ['class' => 'form-control form-group'])
        !!}
    @endif

    @if ($errors->has($fieldName))
        <span class="help-block">
            <strong>{{ $errors->first($fieldName) }}</strong>
        </span>
    @endif
</div>