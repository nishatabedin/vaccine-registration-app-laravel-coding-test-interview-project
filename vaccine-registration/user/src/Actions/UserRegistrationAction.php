<?php

namespace VaccineRegistration\User\Actions;

use Illuminate\Support\Facades\DB;
use VaccineRegistration\User\DTO\UserRegistrationDTO;
use VaccineRegistration\User\Services\RegistrationService;
use VaccineRegistration\User\Http\Requests\UserRegistrationRequest;

class UserRegistrationAction
{
    protected $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }
    
    public function execute(UserRegistrationRequest $request)
    {
        $userDto = UserRegistrationDTO::fromRequest($request);

        DB::transaction(function () use ($userDto) {

            $user = $this->registrationService->registerUser($userDto);
          
            //To Do: Schedule vaccination
            
        });


       

       
    }
}
