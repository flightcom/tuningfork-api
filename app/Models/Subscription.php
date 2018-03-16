<?php

namespace Models;

use Models\Extensions\LucyModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Subscription extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
        'deleted_at',
    ];

    /**
     * The attributes that should be appended when the model is called.
     *
     * @var array
     */
    protected $appends = [
        'user',
    ];

    /**
     * Parent category of the instrument.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->starts_at < Carbon::now()
            && $this->ends_at > Carbon::now();
    }
}
