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
    ];

    /**
     * Parent category of the instrument.
     */
    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * GET Parent category of the instrument.
     */
    public function getParentAttribute()
    {
        return $this->parent()->first();
    }

    /**
     * Children category of the instrument.
     */
    public function children()
    {
        return $this->hasMany(self::class);
    }

    /**
     * Children category of the instrument.
     */
    public function getChildrenAttribute()
    {
        return $this->children()->get()->toArray();
    }

    /**
     * Set Slug attribute (if not set)
     */
    public function setNameAttribute($value)
    {
        $slug = str_slug($value, '-');
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $slug;
    }
}
