<?php

namespace VaccineRegistration\VaccineCenter\Providers;

use Illuminate\Support\ServiceProvider;
use VaccineRegistration\Common\Contracts\ScheduleVaccinationInterface;
use VaccineRegistration\VaccineCenter\Services\ScheduleVaccinationService;

class VaccineCenterServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(ScheduleVaccinationInterface::class, ScheduleVaccinationService::class);
	}
	
	public function boot(): void
	{
	}
}
