<?php

namespace VaccineRegistration\User\Http\Controllers;

use Illuminate\Http\Request;
use VaccineRegistration\User\Services\UserService;

class SearchController
{
    /**
     * Display the search form.
    */
    public function showSearchForm()
    {
        return view('user::search.form'); 
    }


    /**
     * Handle the search request and return the user's status.
     */
    public function search(Request $request, UserService  $userService )
    {
        $request->validate([
            'nid' => 'required',
        ]);

        $data = $userService->checkUserStatusByNID($request->nid);

        return view('user::search.form', [
            'status' => $data['status'],
            'schedule' => $data['schedule'],
            'registerLink' => $data['registerLink'] ?? null,
        ]);
    }
}
