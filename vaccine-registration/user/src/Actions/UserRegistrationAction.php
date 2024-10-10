<?php

namespace VaccineRegistration\User\Actions;

use VaccineRegistration\User\Services\UserService;
use VaccineRegistration\User\DTO\UserRegistrationDTO;
use VaccineRegistration\User\Http\Requests\UserRegistrationRequest;
use VaccineRegistration\Common\Contracts\ScheduleVaccinationInterface;

class UserRegistrationAction
{
    protected $userService;
    protected $scheduleVaccinationService;

    public function __construct(UserService $userService, ScheduleVaccinationInterface $scheduleVaccinationService)
    {
        $this->userService = $userService;
        $this->scheduleVaccinationService = $scheduleVaccinationService;
    }
    
    public function execute(UserRegistrationRequest $request)
    {
        $userDto = UserRegistrationDTO::fromRequest($request);
        $user = $this->userService->registerUser($userDto);

        // Dispatch the job to schedule vaccination
        $this->scheduleVaccinationService->scheduleVaccinationJob($user->id, $request->vaccine_center_id);
        return $user;
    }
}
