<?php

namespace Models;

use Models\Extensions\LucyModel as Model;

class Brand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
    protected $dates = [];

    /**
     * The attributes that should be appended when the model is called.
     *
     * @var array
     */
    protected $appends = [
        'instruments',
    ];

    /**
     * Category of the instrument.
     */
    public function instruments()
    {
        return $this->hasMany(Instrument::class);
    }
}
