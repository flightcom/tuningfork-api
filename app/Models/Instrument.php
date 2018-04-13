<?php

namespace Models;

use Models\Extensions\LucyModel as Model;

class Instrument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'serial_number',
        'condition',
        'to_be_checked',
        'barcode',
        'comment',
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
        'categories',
        'category_ids',
        'picture',
        'store',
        'is_available',
    ];

    protected $with = [
        'brand',
        'category',
    ];

    /* The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'to_be_checked' => 'boolean',
    ];

    /**
     * Brand of the instrument.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Category of the instrument.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryIdsAttribute()
    {
        $ids = [];
        $category = $this->category;
        $ids[] = $category ? $category->id : null;

        if ($category) {
            while ($category = $category->category) {
                $ids[] = $category->id;
            }
        }

        return array_reverse($ids);
    }

    public function getCategoriesAttribute()
    {
        $categories = [];
        $category = $this->category;
        $categories[] = $category ?? null;

        if ($category) {
            while ($category = $category->category) {
                $categories[] = $category;
            }
        }

        return array_reverse($categories);
    }

    /**
     * An instrument can have one picture.
     */
    public function picture()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function getPictureAttribute()
    {
        $picture = $this->picture()->first();

        return $picture->local_path ?? null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function action_logs()
    {
        return $this->hasMany(ActionLog::class);
    }

    /**
     * An instrument is stored somewhere.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getStoreAttribute()
    {
        $store = $this->store()->first();

        return $store->name ?? null;
    }

    /**
     * An instrument can be lended.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Checks if an instrument is currently on a loan
     *
     * @return boolean
     */
    public function getIsAvailableAttribute()
    {
        return $this->loans()->count() === 0;
    }
}
