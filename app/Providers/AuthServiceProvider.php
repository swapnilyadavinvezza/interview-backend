<?php

namespace App\Providers;

use App\Modules\User\Models\Profile;
use App\Modules\User\Models\User;
use App\Modules\User\Policies\ProfilePolicy;
use App\Modules\User\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::enablePasswordGrant();
    }

}
