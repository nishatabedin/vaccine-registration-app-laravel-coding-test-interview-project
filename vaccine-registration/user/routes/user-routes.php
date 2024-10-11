<?php
use Illuminate\Support\Facades\Route;
use VaccineRegistration\User\Http\Controllers\RegistrationController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('user::registration.form');
    });

    Route::post('register', [RegistrationController::class, 'register']);

    // Route::get('/search', [SearchController::class, 'showSearchForm'])->name('search.form');  
    // Route::get('/search/status', [SearchController::class, 'search'])->name('search.status');
});
