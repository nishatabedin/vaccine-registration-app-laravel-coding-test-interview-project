<?php

namespace VaccineRegistration\Common\Contracts;

use Illuminate\Support\Collection;

interface VaccineCenterInterface
{
    public function getAllVaccineCenter(): Collection;
}
