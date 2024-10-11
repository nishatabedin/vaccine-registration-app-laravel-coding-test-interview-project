<?php
namespace VaccineRegistration\Notification\Services;

use Illuminate\Support\Facades\Mail;
use VaccineRegistration\Common\Contracts\UserInterface;
use VaccineRegistration\Common\DTO\NotificationDataDTO;
use VaccineRegistration\Common\Contracts\NotificationInterface;
use VaccineRegistration\Notification\Mail\VaccinationNotificationMail;

class NotificationService implements NotificationInterface
{

    protected $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Notify a user via email (can be extended to SMS, push notifications, etc.)
     *
     * @param int $userId
     * @param string $message
     * @param NotificationDataDTO $notificationData
     */
    public function notify(int $userId, string $message, NotificationDataDTO $notificationData)
    {
        // Use the UserInterface to find the user data
        $user = $this->userService->findUserDataByUserId($userId);

        if ($user && $user->email) {
            // Dispatch the email as a queued job
            Mail::to($user->email)
                ->queue(new VaccinationNotificationMail($message, $notificationData));
        }
    }
}
