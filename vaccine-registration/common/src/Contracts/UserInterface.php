<?php

namespace VaccineRegistration\Common\Contracts;

interface UserInterface
{
    public function findUserDataByUserId(int $userId);
    
    public function updateUserStatus(int $userId, string $status);

}