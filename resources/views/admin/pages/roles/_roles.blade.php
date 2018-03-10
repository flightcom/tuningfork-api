<div class="box-body">
    <div class="row">

        <div class="col-xs-12">
            @foreach($roles as $role)
                <div>
                    <label for="user-{{ $user->id }}-role-{{ $role->id }}">
                        <input type="checkbox"
                            value="{{ $role->id }}"
                            id="user-{{ $user->id }}-role-{{ $role->id }}"
                            name="roles[]"
@if($user->roles->contains('slug', $role->slug)) checked @endif />
                        {{ $role->label }}
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