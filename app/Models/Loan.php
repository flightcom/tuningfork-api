<?php

namespace Models;

use Models\Extensions\LucyModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deposit_price',
        'deposit_received',
        'deposit_returned',
        'comment',
        'status',
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
        'starts_at',
        'ends_at',
        'ended_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be appended when the model is called.
     *
     * @var array
     */
    protected $appends = [
        'user',
        'instrument',
    ];

    /**
     * Parent category of the instrument.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Children category of the instrument.
     */
    public function instrument()
    {
        return $this->hasOne(Instrument::class);
    }

    /**
     * This function is called automatically to encrypt The password.
     *
     * @param $password
     */
    public function setStatusAttribute($status)
    {
        if (!$status) {
            $this->attributes['status'] = config('constants.default_loan_status');
        }
    }

    /**
     * Checks if a loan is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->starts_at < Carbon::now()
            && is_null($this->ended_at);
    }

    /**
     * Checks if the loan intented end date is over
     *
     * @return boolean
     */
    public function isNotEnded()
    {
        return $this->ends_at < Carbon::now()
            && is_null($this->ended_at);
    }
}
