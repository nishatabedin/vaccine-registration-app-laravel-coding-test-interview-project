<?php

namespace VaccineRegistration\Common\Contracts;

interface ScheduleVaccinationInterface
{
    public function scheduleVaccination(int $userId, int $vaccineCenterId);
    public function scheduleVaccinationJob(int $userId, int $vaccineCenterId);
    public function findVaccinationScheduleByUserId(int $userId);

}
