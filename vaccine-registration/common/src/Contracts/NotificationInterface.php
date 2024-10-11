<?php
namespace VaccineRegistration\Common\Contracts;

use VaccineRegistration\Common\DTO\NotificationDataDTO;

interface NotificationInterface
{
    /**
     * Notify a user.
     *
     * @param int $userId
     * @param string $message
     * @param NotificationDataDTO $data (for structured dynamic content)
     */
    public function notify(int $userId, string $message, NotificationDataDTO $data);
}
