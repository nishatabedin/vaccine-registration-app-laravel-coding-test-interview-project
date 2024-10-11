<?php

namespace VaccineRegistration\User\Providers;

use Illuminate\Support\ServiceProvider;
use VaccineRegistration\User\Models\User;
use VaccineRegistration\User\Services\UserService;
use VaccineRegistration\User\Observers\UserObserver;
use VaccineRegistration\Common\Contracts\UserInterface;

class UserServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(UserInterface::class, UserService::class);
	}
	
	public function boot()
    {
		User::observe(UserObserver::class);
    }
}
