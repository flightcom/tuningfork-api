<div class="{{ $errors->has($fieldName) ? ' has-error' : '' }}">
    {!! Form::label($fieldName, $fieldLabel) !!}

    <input id="{{ $fieldName }}"
           name="{{ $fieldName }}"
           type="{{ $fieldType }}"
           value="{{ old($fieldName) ? old($fieldName) : $fieldValue }}"
           placeholder="{{ $fieldPlaceholder }}"
           class="form-control form-group"
           @if (isset($fieldDisabled) && $fieldDisabled) disabled @endif
           @if ($fieldType === 'file' && $fieldAccept) active="{{ $fieldAccept }}" @endif
    />

    @if ($errors->has($fieldName))
        <span class="help-block">
            <strong>{{ $errors->first($fieldName) }}</strong>
        </span>
    @endif
</div>