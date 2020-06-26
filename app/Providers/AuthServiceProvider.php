<?php

namespace App\Providers;

use App\Models\Category;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('categories', function (User $user, Category $category) {
           return $user->role == "admin";
        });
        Gate::define('edit-post', function (User $user, Post $post) {
            return $user->role == "admin";
        });
        //
    }
}
