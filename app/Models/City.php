<?php

namespace Models;

use Models\Extensions\LucyModel as Model;

class City extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nameReal',
        'slug',
        'department',
        'cityCode',
        'postalCode',
        'longitude',
        'latitude',
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
        'country',
    ];

    /**
     * Children category of the instrument.
     */
    public function country()
    {
        return $this->hasOne(Country::class);
    }
}
