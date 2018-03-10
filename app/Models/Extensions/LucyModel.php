<?php

namespace Models\Extensions;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

use App\Events\UserModelAction;
use Models\ActionLog;

/**
 * While this model extends the regular Model, it is a place
 * to add additional functionality that all models share.
 *
 * Class LucyModel
 * @package App\Models\Extensions
 */
class LucyModel extends Model
{

    /**
     * We're removing auto-incrementing as we're using UUID's
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Boot function from laravel where we will generate the model UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::created(function ($model) {
            self::createLogEvent(
                config('constants.actions_log_type.CREATED'),
                $model
            );
        });

        static::updating(function ($model) {
            self::createLogEvent(
                config('constants.actions_log_type.UPDATED'),
                $model
            );
        });

        static::deleting(function ($model) {
            self::createLogEvent(
                config('constants.actions_log_type.DELETED'),
                $model
            );
        });
    }

    protected static function createLogEvent($type, $model)
    {
        if (get_class($model) === ActionLog::class) {
            return;
        }

        event(new UserModelAction(
            $type,
            $model
        ));
    }
}
