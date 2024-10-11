<?php

namespace VaccineRegistration\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use VaccineRegistration\Common\Contracts\NotificationInterface;
use VaccineRegistration\Notification\Services\NotificationService;

class NotificationServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(NotificationInterface::class, NotificationService::class);
	}
	
	public function boot(): void
	{
	}
}
