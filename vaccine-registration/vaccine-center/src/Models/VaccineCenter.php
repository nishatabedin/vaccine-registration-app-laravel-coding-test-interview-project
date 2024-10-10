<?php

namespace VaccineRegistration\VaccineCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'daily_limit'];

    public function schedules()
    {
        return $this->hasMany(VaccinationSchedule::class);
    }
}
