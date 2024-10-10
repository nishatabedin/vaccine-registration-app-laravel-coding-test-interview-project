<?php

namespace VaccineRegistration\User\Services;

use VaccineRegistration\User\Models\User;


class RegistrationService
{
    public function registerUser($userDto):User
    {
        // Create user
        return User::create([
            'nid' => $userDto->nid,
            'name' =>$userDto->name,
            'email' =>$userDto->email,
            'status' => 'registered',
        ]);
    }
    
}
