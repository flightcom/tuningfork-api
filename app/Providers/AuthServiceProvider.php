<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $this->registerPolicies();

            foreach($this->getPermissions() as $permission) {
                Gate::define($permission->slug, function($user) use ($permission) {
                    return $user->isSuperAdmin() || $user->hasRole($permission->roles);
                });
            }
        } catch (\Exception $e) {
            \Log::info('Permissions table does not exist to register roles and permissions');
        }
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
