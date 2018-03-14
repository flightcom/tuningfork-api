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
        'brand',
        'category',
        'loans',
        'picture',
        'store',
    ];

    /**
     * Category of the instrument.
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

    /**
     * A user can have one avatar.
     */
    public function picture()
    {
        return $this->morphOne(File::class, 'fileable');
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
        return $this->hasOne(Store::class);
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
}
