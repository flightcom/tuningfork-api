<?php

namespace Models\Extensions;

use Illuminate\Auth\Authenticatable;
use Models\Extensions\LucyModel as Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * The user model is a special one as it requires multiple implementations
 * and traits that are already built into Laravel. The problem is that the
 * regular User model that we should extend, extends the regular "Model"
 *
 *
 * Class LucyUserModel
 * @package App\Models\Extensions
 */
class LucyUserModel extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
}
