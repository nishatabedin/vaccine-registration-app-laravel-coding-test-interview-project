<?php

namespace VaccineRegistration\User\Enums;

enum UserStatus: string
{
    case REGISTERED = 'registered';
    case NOT_SCHEDULED = 'Not scheduled';
    case SCHEDULED = 'Scheduled';
    case VACCINATED = 'Vaccinated';
}
