<?php

namespace VaccineRegistration\User\Enums;

enum UserStatus: string
{
    case REGISTERED = 'registered';
    case SCHEDULED = 'scheduled';
    case VACCINATED = 'vaccinated';
}
