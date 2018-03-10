<div class="box-body">
    <div class="row">

        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="text-center">
                <img class="img-circle profile-user-img"
                     style="height: 100px;"
                     src="{{ $userAvatar }}"
                />
            </div>

            <div class="col-xs-12 text-center">
                @include('admin.includes.forms.input', [
                    'fieldType' => 'file',
                    'fieldName' => 'avatar',
                    'fieldLabel' => 'Avatar',
                    'fieldValue' => '',
                    'fieldPlaceholder' => '',
                    'fieldAccept' => 'image/*',
                ])
            </div>
        </div>

    </div>

    <hr />

    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-2">
            @include('admin.includes.forms.input', [
                'fieldType' => 'text',
                'fieldName' => 'first_name',
                'fieldLabel' => 'First name',
                'fieldValue' => $user ? $user->first_name : '',
                'fieldPlaceholder' => 'First name',
            ])
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4">
            @include('admin.includes.forms.input', [
                'fieldType' => 'text',
                'fieldName' => 'last_name',
                'fieldLabel' => 'Last name',
                'fieldValue' => $user ? $user->last_name : '',
                'fieldPlaceholder' => 'Last name',
            ])
        </div>

    </div>
    <div class="row">

        <div class="col-xs-12 col-md-8 col-md-offset-2">
            @include('admin.includes.forms.input', [
                'fieldType' => 'email',
                'fieldName' => 'email',
                'fieldLabel' => 'Email address',
                'fieldValue' => $user ? $user->email : '',
                'fieldPlaceholder' => 'user@example.com',
            ])
        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-2">
            @include('admin.includes.forms.input', [
                'fieldType' => 'password',
                'fieldName' => 'password',
                'fieldLabel' => 'Password',
                'fieldValue' => '',
                'fieldPlaceholder' => 'Password',
            ])
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4">
            @include('admin.includes.forms.input', [
                'fieldType' => 'password',
                'fieldName' => 'password_confirmation',
                'fieldLabel' => 'Password confirmation',
                'fieldValue' => '',
                'fieldPlaceholder' => 'Password confirmation',
            ])
        </div>

    </div>
    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-2">
            @include('admin.includes.forms.select', [
                'fieldName' => 'status',
                'fieldLabel' => 'Status',
                'fieldOptions' => config('constants.user_status'),
                'fieldValue' => config('constants.default_user_status'),
            ])
        </div>

    </div>
</div>

<div class="box-footer">
    <button type="submit" class="btn btn-primary btn-flat pull-right">
        {{ $submitText }}
    </button>
</div>