<div class="{{ $errors->has($fieldName) ? ' has-error' : '' }}">
    {!! Form::label($fieldName, $fieldLabel) !!}

    <textarea id="{{ $fieldName }}"
              name="{{ $fieldName }}"
              placeholder="{{ $fieldPlaceholder }}"
              class="form-control form-group"
              @if (isset($fieldDisabled) && $fieldDisabled) disabled @endif
              rows="7"
    >{{ old($fieldName) ? old($fieldName) : $fieldValue }}</textarea>

    @if ($errors->has($fieldName))
        <span class="help-block">
            <strong>{{ $errors->first($fieldName) }}</strong>
        </span>
    @endif
</div>