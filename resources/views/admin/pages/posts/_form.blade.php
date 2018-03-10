<div class="box-body">
    <div class="row">

        <div class="col-xs-12">
            @include('admin.includes.forms.input', [
                'fieldType' => 'text',
                'fieldName' => 'title',
                'fieldLabel' => 'Title',
                'fieldValue' => $post ? $post->title : '',
                'fieldPlaceholder' => 'Title',
                'fieldDisabled' => !authorized($requiredPermission),
            ])
        </div>

        <div class="col-xs-12">
            @include('admin.includes.forms.input', [
                'fieldType' => 'text',
                'fieldName' => 'content',
                'fieldLabel' => 'Content',
                'fieldValue' => $post ? $post->content : '',
                'fieldPlaceholder' => 'Content',
                'fieldDisabled' => !authorized($requiredPermission),
            ])
        </div>

    </div>
</div>

<div class="box-footer">
    <button type="submit" class="btn btn-primary btn-flat pull-right">
        {{ $submitText }}
    </button>
</div>
