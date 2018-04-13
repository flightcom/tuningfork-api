<?php

namespace Models;

use Models\Extensions\LucyModel as Model;
use Carbon\Carbon;

class Subscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
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
    ];

    /**
     * The attributes that should be appended when the model is called.
     *
     * @var array
     */
    protected $appends = [];

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
