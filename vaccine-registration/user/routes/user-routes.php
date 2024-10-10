<?php
use Illuminate\Support\Facades\Route;
use VaccineRegistration\User\Http\Controllers\RegistrationController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('user::registration.form');
    });

    Route::post('register', [RegistrationController::class, 'register']);
});
