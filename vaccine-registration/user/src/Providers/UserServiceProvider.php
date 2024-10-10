<?php

namespace VaccineRegistration\User\Providers;

use Illuminate\Support\ServiceProvider;
use VaccineRegistration\User\Services\UserService;
use VaccineRegistration\Common\Contracts\UserInterface;

class UserServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(UserInterface::class, UserService::class);
	}
	
	public function boot()
    {
      
    }
}
