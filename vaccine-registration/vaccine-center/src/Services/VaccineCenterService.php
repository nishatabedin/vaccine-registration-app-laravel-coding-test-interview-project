<?php
namespace VaccineRegistration\VaccineCenter\Services;

use Illuminate\Support\Collection;
use VaccineRegistration\VaccineCenter\Models\VaccineCenter;
use VaccineRegistration\Common\Contracts\VaccineCenterInterface;


class VaccineCenterService implements VaccineCenterInterface
{
    public function getAllVaccineCenter(): Collection
    {
        return VaccineCenter::all();
    }
}