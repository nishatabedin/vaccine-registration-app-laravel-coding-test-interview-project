<?php

namespace VaccineRegistration\User\Observers;

use Illuminate\Support\Facades\Cache;
use VaccineRegistration\User\Models\User;

class UserObserver
{
   /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        // Invalidate cache after user is created
        Cache::forget("user_status_{$user->nid}");
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user)
    {
        // Invalidate cache after user is updated
        Cache::forget("user_status_{$user->nid}");
    }
}
