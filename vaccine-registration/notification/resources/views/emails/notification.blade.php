<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Notification</title>
</head>
<html>
<head>
    <title>Vaccination Notification</title>
</head>
<body>
    <h1>{{ $messageContent }}</h1>
    <p>Your vaccination is scheduled on <strong>{{ $notificationData->date }}</strong> at <strong>{{ $notificationData->center }}</strong>.</p>

</body>
</html>