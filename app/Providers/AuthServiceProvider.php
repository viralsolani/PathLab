<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        $this->registerPolicies();

        $user = \Auth::user();


        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Reports management
        Gate::define('reports_management_access', function ($user) {
            return in_array($user->role_id, [1,2]);
        });

        // Auth gates for: Reports
        Gate::define('report_access', function ($user) {
            return in_array($user->role_id, [1,2]);
        });
        Gate::define('report_patient_name_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('report_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('report_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('report_view', function ($user) {
            return in_array($user->role_id, [1,2]);
        });
        Gate::define('report_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Tests
        Gate::define('test_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('test_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('test_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('test_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('test_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Reports Tests
        Gate::define('report_test_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

    }
}
