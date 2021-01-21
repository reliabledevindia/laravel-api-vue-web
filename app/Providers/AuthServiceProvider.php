<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use App\Models\Spatie\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

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
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        Passport::routes(); 
        foreach ($this->getPermissions() as $permission) {
            $gate->define($permission->name, function ($user) use ($permission) {
                return $user->checkPermissionTo($permission);
            });
        }
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
