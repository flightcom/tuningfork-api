<?php

namespace Models;

use Models\Extensions\LucyModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionLog extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'loggable_id',
        'loggable_type',
        'type',
        'old',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the users for the logs
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
