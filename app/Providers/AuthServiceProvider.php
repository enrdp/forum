<?php

namespace App\Providers;

use App\Models\Thread;
use App\Models\User;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
       Thread::class => ThreadPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::before(function (User $user)
//        {
//            if($user->is_admin)
//            {
//                return true;
//            }
//        });

        Gate::before(function ($user, $ability)
        {
            if (!$user->abilities()->contains($ability)) {
                return false;
            }
                return true;
        });


    }



}
