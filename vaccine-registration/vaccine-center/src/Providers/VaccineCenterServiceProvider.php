<?php

namespace VaccineRegistration\VaccineCenter\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use VaccineRegistration\Common\Contracts\VaccineCenterInterface;
use VaccineRegistration\VaccineCenter\Services\VaccineCenterService;
use VaccineRegistration\Common\Contracts\ScheduleVaccinationInterface;
use VaccineRegistration\VaccineCenter\Services\ScheduleVaccinationService;
use VaccineRegistration\VaccineCenter\Console\Commands\SendVaccinationReminder;

class VaccineCenterServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(ScheduleVaccinationInterface::class, ScheduleVaccinationService::class);
        $this->app->bind(VaccineCenterInterface::class, VaccineCenterService::class);
        
	}
	
	public function boot(): void
	{
		 // Register the command for the module
		 if ($this->app->runningInConsole()) {
            $this->commands([
                SendVaccinationReminder::class,
            ]);
        }

		$this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $reminderTime = env('VACCINATION_REMINDER_TIME', '21:00');
            $reminderTimezone = env('VACCINATION_REMINDER_TIMEZONE', 'Asia/Dhaka');

            // Schedule the command
            $schedule->command('vaccination:remind')
                     ->dailyAt($reminderTime)
                     ->timezone($reminderTimezone); 
        });
	}
}
