<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
</head>
<body>

    <h2>Password Reset Request</h2>

    <p>Hello {{ $user->name }},</p>

    <p>We received a request to reset your password.</p>

    <p>
        <a href="{{ url('reset-password/'.$token) }}">
            Click here to reset your password
        </a>
    </p>

    <p>If you did not request a password reset, please ignore this email.</p>

    <p>Thank you.</p>

</body>
</html>