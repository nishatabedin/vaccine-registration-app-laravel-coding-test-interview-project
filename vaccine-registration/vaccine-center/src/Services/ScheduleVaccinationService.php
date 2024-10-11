<?php
namespace VaccineRegistration\VaccineCenter\Services;
use Exception;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use VaccineRegistration\Common\Contracts\UserInterface;
use VaccineRegistration\Common\DTO\NotificationDataDTO;
use VaccineRegistration\VaccineCenter\Models\VaccineCenter;
use VaccineRegistration\Common\Contracts\NotificationInterface;
use VaccineRegistration\VaccineCenter\Models\VaccinationSchedule;
use VaccineRegistration\VaccineCenter\Jobs\ScheduleVaccinationJob;
use VaccineRegistration\Common\Contracts\ScheduleVaccinationInterface;



class ScheduleVaccinationService implements ScheduleVaccinationInterface
{

    protected $userService;
    protected $notificationService;

    public function __construct(UserInterface $userService, NotificationInterface $notificationService)
    {
        $this->userService = $userService;
        $this->notificationService = $notificationService;
    }


    public function findVaccineCenterById(int $vaccineCenterId): ?VaccineCenter
    {
        return VaccineCenter::find($vaccineCenterId);
    }

   

    public function scheduleVaccination(int $userId, int $vaccineCenterId)
    {
        // Use the UserInterface to find the user data
        $user = $this->userService->findUserDataByUserId($userId);
        
        // Find the vaccine center by ID
        $center = $this->findVaccineCenterById($vaccineCenterId);

        if ($user && $center) {
            $scheduledDate = $this->findAvailableDateForCenter($center);
    
            if ($scheduledDate) {
                try {
                    // Use a transaction to ensure both operations succeed or fail together
                    DB::transaction(function() use ($userId, $center, $scheduledDate) {
                        // Create the vaccination schedule
                        VaccinationSchedule::create([
                            'user_id' => $userId,
                            'vaccine_center_id' => $center->id,
                            'scheduled_date' => $scheduledDate,
                        ]);
    
                        // Update the user's status using the UserInterface
                        $this->userService->updateUserStatus($userId, 'scheduled');

                        // Send email notification about the vaccination schedule
                        $notificationData = new NotificationDataDTO($scheduledDate, $center->name);
                        $this->notificationService->notify($userId, 'Your vaccination is scheduled!', $notificationData);

                    });
                } catch (Exception $e) {
                    // Handle the transaction failure, log the error
                    Log::error('Transaction failed: ' . $e->getMessage());
                   
                }
            }
        }
    }



    protected function findAvailableDateForCenter(VaccineCenter $center)
    {
        $weekOffset = 0;
        while (true) {
            // Get the valid weekdays (offset 0 for current week, 1 for next week, etc.)
            $validWeekdays = $this->getWeekdaysForVaccination($weekOffset);

            // Try to find an available date in the current week
            $scheduledDate = collect($validWeekdays)->first(function($date) use ($center) {
                return $center->schedules()->where('scheduled_date', $date)->count() < $center->daily_limit;
            });

            if ($scheduledDate) {
                return $scheduledDate;
            }

            // If no available date is found, move to the next week
            $weekOffset++;
        }
    }

    

    protected function getWeekdaysForVaccination(int $weekOffset = 0)
    {
        // Start the week on Sunday and end on Thursday, with an optional offset for future weeks
        $startOfWeek = Carbon::now()->addWeeks($weekOffset)->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->addWeeks($weekOffset)->endOfWeek(Carbon::THURSDAY);

        // Create a period from Sunday to Thursday
        return collect(CarbonPeriod::create($startOfWeek, $endOfWeek))
            ->map(function ($date) {
                return $date->format('Y-m-d');
            })
            ->toArray();
    }


    
    public function scheduleVaccinationJob(int $userId, int $vaccineCenterId)
    {
        ScheduleVaccinationJob::dispatch($userId, $vaccineCenterId);
    }


    public function sendVaccinationReminders()
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
       
        VaccinationSchedule::with('center')  // Eager load the center relationship
            ->where('scheduled_date', $tomorrow)
            ->chunkById(100, function ($schedules) {
              
                foreach ($schedules as $schedule) {
                    $user = $this->userService->findUserDataByUserId($schedule->user_id);
                    
                    // Log::info('Vaccination Schedule ID: ' . $schedule->id . ' - Center: ' . json_encode($schedule->center));

                    if ($user && $schedule->center) {
                        $notificationData = new NotificationDataDTO(
                            $schedule->scheduled_date,
                            $schedule->center->name
                        );

                        // Send reminder notification
                        $this->notificationService->notify(
                            $schedule->user_id,
                            'Reminder: Your vaccination is tomorrow!',
                            $notificationData
                        );
                    } else {
                        Log::warning('Missing center or user for schedule ID: ' . $schedule->id);
                    }
                }
            });
    }



}


