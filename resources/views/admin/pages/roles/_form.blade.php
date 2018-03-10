<div class="box-body">
    <div class="row">

        <div class="col-xs-12 col-sm-6">
            @include('admin.includes.forms.input', [
                'fieldType' => 'text',
                'fieldName' => 'slug',
                'fieldLabel' => 'Slug',
                'fieldValue' => $role ? $role->slug : '',
                'fieldPlaceholder' => 'example_group',
                'fieldDisabled' => !authorized($requiredPermission),
            ])
        </div>

        <div class="col-xs-12 col-sm-6">
            @include('admin.includes.forms.input', [
                'fieldType' => 'text',
                'fieldName' => 'label',
                'fieldLabel' => 'Label',
                'fieldValue' => $role ? $role->label : '',
                'fieldPlaceholder' => 'Example group',
                'fieldDisabled' => !authorized($requiredPermission),
            ])
        </div>

    </div>
</div>

@if(authorized($requiredPermission))
    <div class="box-footer">
        <button type="submit" class="btn btn-primary btn-flat pull-right">
            {{ $submitText }}
        </button>
    </div>
@endif