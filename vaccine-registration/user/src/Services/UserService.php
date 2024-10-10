<?php

namespace VaccineRegistration\User\Services;

use Exception;
use ValueError;
use VaccineRegistration\User\Models\User;
use VaccineRegistration\User\Enums\UserStatus;
use VaccineRegistration\Common\Contracts\UserInterface;

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
    
}
