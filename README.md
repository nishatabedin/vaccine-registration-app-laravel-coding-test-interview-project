# Vaccine Registration App

This application is designed to handle COVID-19 vaccine registration and scheduling using Laravel and a modular architecture. It allows users to register for vaccination, select a vaccine center, and receive notifications about their vaccination schedule. Users can also search for their vaccination status.

## Features

-   **User Registration**: Users can register for vaccination by providing their NID, name, and email, and selecting a vaccine center.
-   **Vaccination Scheduling**: Automatically schedules users for vaccination based on the center's daily limit.
-   **Vaccination Reminders**: Sends notifications to users at 9 PM the night before their vaccination date.
-   **Search**: Users can search for their vaccination status by NID and check if they are registered, scheduled, or vaccinated.

## Requirements

-   PHP 8.2 or higher
-   MySQL
-   Composer
-   Laravel 11.x
-   A mail service (SMTP, Mailgun, AWS SES, etc.) for email notifications

## Setup Instructions

Follow these steps to set up and run the project locally.

### 1. Clone the Repository

First, clone the repository and navigate into the project directory:

```bash
git clone https://github.com/nishatabedin/vaccine-registration-app-laravel-coding-test-interview-project.git
cd vaccine-registration-app-laravel-coding-test-interview-project
```

### 2. Install Dependencies

Run the following command to install the required PHP and Laravel packages:

```bash
composer install
```

### 3. Set Up Environment

Copy the .env.example file to .env and update it with your environment variables, especially for the database and mail configuration:

```bash
cp .env.example .env
```

Then, update the following variables in the .env file to match your environment setup:

```bash

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vaccine_registration
DB_USERNAME=your_user_here
DB_PASSWORD=your_password_here

MAIL_MAILER=smtp  # Or any mail driver you want to use (smtp, mailgun, ses, etc.)
MAIL_HOST=your_mail_host
MAIL_PORT=your_mail_port
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls  # Or ssl depending on your configuration
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Vaccine Registration App"

# if you use ses  mail driver
AWS_ACCESS_KEY_ID_SES=
AWS_SECRET_ACCESS_KEY_SES=
AWS_DEFAULT_REGION_SES=

# setup the value as you want
VACCINATION_REMINDER_TIME="21:00"
VACCINATION_REMINDER_TIMEZONE=Asia/Dhaka
CACHE_TTL=60

```

### 4. Generate Application Key

Generate the application key by running the following Artisan command:

```bash
php artisan key:generate
```

### 5. Set Up Database

Make sure your .env file has the correct database credentials. Then run the database migrations:

```bash
php artisan migrate
```

### 6. Seed the Database

Seed the vaccine centers by running the following command:

```bash
php artisan db:seed --class=VaccineCenterSeeder --module=vaccine-center
```

### 7. Running the Application

Run the application using Laravel's built-in development server:

```bash
php artisan serve

```

After running this command, the application will be available at:

```bash
http://localhost:8000

```

### 8. Running the Vaccination Reminder Command

The application includes a command that sends vaccination reminders at 9 PM the day before the scheduled vaccination. To manually trigger the command, run:

```bash
php artisan vaccination:remind

```

### 9. Running the Queue Worker

To send emails in the background, you need to run the queue worker. This will process any queued jobs, such as sending vaccination notifications:

```bash
php artisan queue:work
```

### 10. Ensure the Queue is Configured Properly

Make sure your `.env` file has the correct queue connection, like `database`, `redis`, etc.

Example for `database` queue driver:

```bash
QUEUE_CONNECTION=database
```

### 11. Update .env for Cache

Add or modify the following environment variables in your .env file to configure the cache driver

Example for `database` cache driver:

```bash
CACHE_STORE=database
```

### 11. Future Requirement: Adding SMS Notifications

11.1) Extend the NotificationInterface: The current NotificationInterface supports email notifications. To include SMS, extend the interface to add an additional method for sending SMS notifications. This ensures that any service implementing the interface will also handle SMS.

```bash
interface NotificationInterface
{
    public function notify(int $userId, string $message, NotificationDataDTO $notificationData);
    public function notifySMS(int $userId, string $message);
}

```

11.2) Update NotificationService: Modify the NotificationService class to implement the notifySMS method. This method will handle the actual logic of sending SMS notifications.

```bash
public function notifySMS(int $userId, string $message)
{
    $user = $this->userService->findUserDataByUserId($userId);

    if ($user && $user->phone) {
        // Logic to send SMS
    }
}

```

11.3) Modify the notify Method: In the current notify method, after sending the email notification, you can optionally trigger the notifySMS method to send the SMS.

```bash
public function notify(int $userId, string $message, NotificationDataDTO $notificationData)
{
    $user = $this->userService->findUserDataByUserId($userId);

    if ($user && $user->email) {
        // Send email notification
        Mail::to($user->email)->queue(new VaccinationNotificationMail($message, $notificationData));
    }

    if ($user && $user->phone) {
        // Send SMS notification
        $this->notifySMS($userId, $message);
    }
}


```
