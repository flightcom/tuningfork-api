<?php

namespace Models;

use Models\Extensions\LucyModel as Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'address_more',
        'postalCode',
        'city',
        'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'locatable_id',
        'locatable_type',
    ];

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
        'full_address',
    ];

    /**
     * This morphs the address to whichever model it is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function locatable()
    {
        return $this->morphTo();
    }

    public function getFullAddressAttribute()
    {
        return ($this->address ? ' ' . $this->address : '')
            . ($this->address_more ? ' ' . $this->address_more : '')
            . ($this->postalCode ? ' ' . $this->postalCode : '')
            . ($this->city ? ' ' . $this->city : '')
            . ($this->country ? ' ' . $this->country : '');
    }
}
