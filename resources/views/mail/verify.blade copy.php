<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:30px;">
    <div style="max-width:600px; margin:auto; background:#fff; padding:30px; border-radius:8px;">
        <h2>Hello, {{ $user->name }}!</h2>
        <p>Thanks for registering. Please use the code below to verify your email:</p>

        <div style="font-size:32px; font-weight:bold; letter-spacing:8px; text-align:center;
                    padding:20px; background:#f0f0f0; border-radius:6px; margin:20px 0;">
            {{ $user->code }}
        </div>

        <p>Or click the button below to verify directly:</p>

        <div style="text-align:center; margin:20px 0;">
            <a href="{{ url('/register-verify-email?code=' . $user->code . '&email=' . urlencode($user->email)) }}"
               style="background:#4F46E5; color:#fff; padding:12px 24px;
                      border-radius:6px; text-decoration:none; font-size:16px;">
                Verify My Email
            </a>
        </div>

        <p style="color:#888; font-size:13px;">This code expires in 24 hours. If you didn't register, ignore this email.</p>
    </div>
</body>
</html>