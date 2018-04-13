<?php

namespace Models;

use Models\Extensions\LucyUserModel as Authenticatable;
use Models\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'phone',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that should be appended when the model is called.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
        'full_name',
        'has_subscribed',
        'has_active_loan',
    ];

    /**
     * The relations that should be appended when the model is called.
     *
     * @var array
     */
    protected $with = [
        // 'loans',
        'location',
        'subscriptions',
    ];

    /**
     * This function simply determines if the user is the app super admin.
     *
     * An app super admin bypasses all permissions and roles
     */
    public function isSuperAdmin()
    {
        return strcmp($this->email, config('constants.root_user')) === 0;
    }

    /**
     * This function is called automatically to encrypt The password.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Returns the users avatar.
     *
     * @return string | null
     */
    public function getAvatarAttribute()
    {
        $avatar = $this->avatar()->first();

        return $avatar ? $avatar->local_path : null;
    }

    /**
     * Full name of user
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * A user can have one avatar.
     */
    public function avatar()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * A user can have one address.
     */
    public function location()
    {
        return $this->morphOne(Location::class, 'locatable');
    }

    /**
     * A user can have several devices.
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function action_logs()
    {
        return $this->hasMany(ActionLog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Getter has_subscribed
     *
     * @return boolean
     */
    public function getHasSubscribedAttribute()
    {
        return $this->hasActiveSubscription();
    }

    /**
     * Checks if user has subscribed (= paid his annual fee)
     *
     * @return boolean
     */
    public function hasActiveSubscription()
    {
        $subscriptions = $this->subscriptions;
        foreach ($subscriptions as $sub) {
            if ($sub->starts_at < Carbon::now() && $sub->ends_at > Carbon::now()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if user has subscribed (= paid his annual fee)
     *
     * @return boolean
     */
    public function getActiveSubscription()
    {
        $subscription = $this->subscriptions()->where([
            ['starts_at', '<', Carbon::now()],
            ['ends_at', '>', Carbon::now()],
        ])->first();

        return $subscription ?? null;
    }

    public function getHasActiveLoanAttribute()
    {
        return $this->loans()->where([
            ['starts_at', '<', Carbon::now()],
            ['ends_at', '>', Carbon::now()],
            ['ended_at', 'IS', 'NULL']
        ])->count() > 0;
    }
}
