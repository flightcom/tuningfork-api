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
        // 'category',
    ];

    /**
     * Scope
     */
    public function scopeOfCategory($query, $category)
    {
        error_log('CATEGORY : ' . $category);
        if (is_null($category)) {
            return $query->whereNull('category_id');
        } else {
            return $query->where('category_id', $category);
        }
    }

    /**
     * Parent category of the instrument.
     */
    public function category()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * GET Parent category of the instrument.
     */
    public function getCategoryAttribute()
    {
        return $this->category()->first();
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
