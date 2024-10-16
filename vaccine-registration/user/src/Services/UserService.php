<?php

namespace VaccineRegistration\User\Services;

use Exception;
use ValueError;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use VaccineRegistration\User\Models\User;
use VaccineRegistration\User\Enums\UserStatus;
use VaccineRegistration\Common\Contracts\UserInterface;
use VaccineRegistration\Common\Contracts\ScheduleVaccinationInterface;

class UserService implements UserInterface
{


    /**
     * Register a user
     *
     * @param object $userDto
     * @return User
     */
    public function registerUser($userDto): User
    {
        return User::create([
            'nid' => $userDto->nid,
            'name' => $userDto->name,
            'email' => $userDto->email,
            'status' => 'registered',
        ]);
    }

    /**
     * Find user data by user ID
     *
     * @param int $userId
     * @return User|null
     */
    public function findUserDataByUserId(int $userId): ?User
    {
        return User::find($userId);
    }



 
    public function updateUserStatus(int $userId, string $status)
    {
        try {
            // Check if the status is a valid enum value
            $validStatus = UserStatus::from($status);
    
            $user = User::find($userId);
            if ($user) {
                $user->status = $validStatus->value;
                return $user->save();
            }
    
            throw new Exception('User not found.');
        } catch (ValueError $e) {
            // Throw an exception if an invalid enum value is provided
            throw new Exception('Invalid status value.');
        }
    }




    /**
     * Find user status by NID 
     *
     * @param string $nid
     * @return array
     */
    public function checkUserStatusByNID(string $nid): array
    {
        $scheduleVaccinationService = app(ScheduleVaccinationInterface::class);
        // Get the cache TTL value from the environment, defaulting to 60 minutes if not set
        $cacheTTL = env('CACHE_TTL', 60)*60;

        $scheduleVaccinationService = app(ScheduleVaccinationInterface::class);
        return Cache::remember("user_status_{$nid}", $cacheTTL, function () use ($nid, $scheduleVaccinationService) {
            $user = User::where('nid', $nid)->first();
            //Log::debug('Cache User Status - User fetched:', ['user' => $user]);
        
            if (!$user) {
                return ['status' => 'Not registered', 'schedule' => null, 'registerLink' => url('/')];
            }
        
            $vaccinationSchedule = $scheduleVaccinationService->findVaccinationScheduleByUserId($user->id);
        
            if (!$vaccinationSchedule) {
                return ['status' => 'Not scheduled', 'schedule' => null];
            }
        
            $scheduledDate = Carbon::parse($vaccinationSchedule->scheduled_date);
            if (Carbon::now()->gt($scheduledDate)) {
                return ['status' => 'Vaccinated', 'schedule' => $scheduledDate];
            }
        
            return ['status' => 'Scheduled', 'schedule' => $scheduledDate];
        });

    }
   
    

    
}
