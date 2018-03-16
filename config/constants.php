<?php

return [
    /*
    |--------------------------------------------------------------------------
    | App Constants
    |--------------------------------------------------------------------------
    |
    | Used by the app to determine certain settings
    |
    */

    'models_directory' => 'Models',

    'system_permissions' => [
        'backend_access',
        'sync_roles',
        'sync_permissions',
    ],

    'ignore_permissions' => [
        'actionlog_show',
        'actionlog_store',
        'actionlog_update',
        'actionlog_destroy',
        'error_store',
        'error_update',
        'error_destroy',
        'permission_show',
        'permission_store',
        'role_show',
    ],

    'default_role' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Root User
    |--------------------------------------------------------------------------
    |
    | This user will always have permissions to the entire gate facade
    |
    */
    'root_user' => 'root@tuningfork.fr',
    'admin_user' => 'admin@tuningfork.fr',
    'moderator_user' => 'moderator@tuningfork.fr',
    'default_user' => 'default@tuningfork.fr',

    /*
    |--------------------------------------------------------------------------
    | User Status
    |--------------------------------------------------------------------------
    |
    | Here you may specify different statuses a user can have such as active,
    | inactive, etc
    |
    */

    'user_status' => [
        'ACTIVE' => 'ACTIVE',
        'SUSPENDED' => 'SUSPENDED',
    ],

    'default_user_status' => 'ACTIVE',

    /*
    |--------------------------------------------------------------------------
    | Error Type
    |--------------------------------------------------------------------------
    |
    | Here you may specify the different platforms used by your application. This
    | is also used by the error manager to determine who logged the error
    |
    */

    'error_type' => [
        'backend' => 'backend',
        'web' => 'web',
        'mobile' => 'mobile',
    ],

    /*
    |--------------------------------------------------------------------------
    | Actions Log Type
    |--------------------------------------------------------------------------
    |
    | Here you may specify the different platforms used by your application. This
    | is also used by the error manager to determine who logged the error
    |
    */

    'actions_log_type' => [
        'CREATED' => 'CREATED',
        'UPDATED' => 'UPDATED',
        'DELETED' => 'DELETED',
    ],

    /*
    |--------------------------------------------------------------------------
    | User Status
    |--------------------------------------------------------------------------
    |
    | Here you may specify different statuses a user can have such as active,
    | inactive, etc
    |
    */

    'loan_status' => [
        'ACTIVE' => 'ACTIVE',
        'CLOSED' => 'CLOSED',
        'CANCELED' => 'CANCELED',
    ],

    'default_loan_status' => 'ACTIVE',
];
