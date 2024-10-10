<?php

namespace VaccineRegistration\VaccineCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vaccine_center_id', 'scheduled_date'];


    public function center()
    {
        return $this->belongsTo(VaccineCenter::class);
    }
}
