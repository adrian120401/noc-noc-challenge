<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>

    <p>Welcome to our platform. We are excited to have you as part of our team.</p>

    <p>Please click on the following link to set your password:</p>

    <p><a href="{{ $passwordResetUrl }}">Set Password</a></p>

    <p>Thank you!</p>
</body>
</html>

