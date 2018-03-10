<?php
/**
 * Returns true or false based on whether or not
 * the user is authorized.
 *
 * The super user is always authorized
 *
 * @param $permission
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
 * or empty string otherwise
 *
 * @param $route
 * @return string
 */
function activeRoute($route)
{
    return request()->route()->getName() === $route ? 'active' : '';
}
