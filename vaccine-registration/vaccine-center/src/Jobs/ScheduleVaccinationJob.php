<?php

namespace VaccineRegistration\VaccineCenter\Jobs;

use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use VaccineRegistration\Common\Contracts\ScheduleVaccinationInterface;

class ScheduleVaccinationJob implements ShouldQueue
{
    use Queueable;

    protected $userId;
    protected $vaccineCenterId;

    public function __construct(int $userId, int $vaccineCenterId)
    {
        $this->userId = $userId;
        $this->vaccineCenterId = $vaccineCenterId;
    }

    public function handle(ScheduleVaccinationInterface $scheduleVaccinationService)
    {
        $scheduleVaccinationService->scheduleVaccination($this->userId, $this->vaccineCenterId);
    }
}
