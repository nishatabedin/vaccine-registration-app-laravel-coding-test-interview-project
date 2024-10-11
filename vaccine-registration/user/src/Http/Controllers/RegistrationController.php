<?php

namespace VaccineRegistration\User\Http\Controllers;

use App\Http\Controllers\Controller; 
use VaccineRegistration\User\Actions\UserRegistrationAction;
use VaccineRegistration\Common\Contracts\VaccineCenterInterface;
use VaccineRegistration\User\Http\Requests\UserRegistrationRequest;

class RegistrationController extends Controller
{

    /**
     * Display the registration form.
    */
    public function showRegistrationForm(VaccineCenterInterface $vaccineCenterService)
    {
        $vaccineCenters = $vaccineCenterService->getAllVaccineCenter();
        return view('user::registration.form', [
            'vaccineCenters' => $vaccineCenters,
        ]);
    }


    public function register(UserRegistrationRequest $request, UserRegistrationAction $userRegistrationAction)
    {
        $userRegistrationAction->execute($request);
        return redirect()->back()->with('success', 'Registration successful. We will notify you via email.');

    }
}
