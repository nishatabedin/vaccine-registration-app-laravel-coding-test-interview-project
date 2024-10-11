<?php
namespace VaccineRegistration\VaccineCenter\Console\Commands;

use Illuminate\Console\Command;
use VaccineRegistration\VaccineCenter\Services\ScheduleVaccinationService;

class SendVaccinationReminder extends Command
{
    protected $signature = 'vaccination:remind';
    protected $description = 'Send a vaccination reminder to users for their upcoming appointment the next day';
    protected $scheduleVaccinationService;

    public function __construct(ScheduleVaccinationService $scheduleVaccinationService)
    {
        parent::__construct();
        $this->scheduleVaccinationService = $scheduleVaccinationService;
    }

    public function handle()
    {
        // Call the method to send vaccination reminders
        $this->info('Vaccination reminder command triggered!');
        $this->scheduleVaccinationService->sendVaccinationReminders();
    }
}
