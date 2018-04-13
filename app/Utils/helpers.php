<?php

use Carbon\Carbon;

/**
 * Returns true or false based on whether or not
 * the user is authorized.
 *
 * The super user is always authorized
 *
 * @param $permission
 *
 * @return mixed
 */
function authorized($permission)
{
    $user = Auth::getUser();

    // Super admin always has access
    if ($user->isSuperAdmin()) {
        return true;
    }

    // Checking for single permission
    if (!is_array($permission)) {
        return $user->can($permission);
    }

    // Checking for multiple permissions
    foreach ($permission as $perm) {
        if ($user->can($perm)) {
            return true;
        }
    }

    return false;
}

/**
 * Returns active if the current route name matches the passed route
 * or empty string otherwise.
 *
 * @param $route
 *
 * @return string
 */
function activeRoute($route)
{
    return request()->route()->getName() === $route ? 'active' : '';
}

/**
 * Returns membership due date based on current or given date.
 *
 * @param date ('Y-m-d H:i:s')
 *
 * @return Carbon\Carbon
 */
function getSubscriptionEndDate($start_date = null)
{
    if (is_null($start_date)) {
        $start_date = date(DATE_ATOM);
    }
    $start_timestamp = strtotime($start_date);
    $timestamp = (strtotime('last friday of june + 23 hours 59 minutes 59 seconds', $start_timestamp) > $start_timestamp)
        ? strtotime('last friday of june + 23 hours 59 minutes 59 seconds', $start_timestamp)
        : strtotime('-1 second last friday of june next year', $start_timestamp);

    return Carbon::createFromTimestamp($timestamp);
}

/**
 * Returns loan due date based on current or given date.
 * (currently same as Membership end date)
 *
 * @param date ('Y-m-d H:i:s')
 *
 * @return Carbon\Carbon
 */
function getLoanEndDate($start_date = null)
{
    if (is_null($start_date)) {
        $start_date = date(DATE_ATOM);
    }
    $start_timestamp = strtotime($start_date);
    $timestamp = (strtotime('last friday of june + 23 hours 59 minutes 59 seconds', $start_timestamp) > $start_timestamp)
        ? strtotime('last friday of june + 23 hours 59 minutes 59 seconds', $start_timestamp)
        : strtotime('-1 second last friday of june next year', $start_timestamp);

    return Carbon::createFromTimestamp($timestamp);
}
