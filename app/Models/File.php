<?php

namespace Models;

use Models\Extensions\LucyModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'local_filename',
        'local_path',
        'entity',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['fileable_id', 'fileable_type'];

    /**
     * This morphs the file to whichever model it is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    public function delete()
    {
        if (Storage::exists($this->local_path)) {
            Storage::delete($this->local_path);
        }
        parent::delete();
    }
}
