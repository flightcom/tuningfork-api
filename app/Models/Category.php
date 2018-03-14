<?php

namespace Models;

use Models\Extensions\LucyModel as Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
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
        'parent',
        'children',
    ];

    /**
     * Parent category of the instrument.
     */
    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * Children category of the instrument.
     */
    public function children()
    {
        return $this->hasMany(self::class);
    }
}
