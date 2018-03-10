<div class="box-body">
    <div class="row">

        <div class="col-xs-12">
            @foreach($permissions as $permission)
                <div>
                    <label for="role-{{ $role->id }}-permission-{{ $permission->id }}">
                        <input type="checkbox"
                               value="{{ $permission->id }}"
                               id="role-{{ $role->id }}-permission-{{ $permission->id }}"
                               name="permissions[]"
                               @if($role->permissions->contains('slug', $permission->slug)) checked @endif />
                        {{ $permission->label }}
                    </label>
                </div>
            @endforeach
        </div>

    </div>

    <div class="row">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-flat pull-right">
                Update
            </button>
        </div>
    </div>
</div>