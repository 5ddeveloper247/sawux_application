<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Reset Password OTP</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #F4F4F4;">
    <div style="max-width: 600px; margin: auto; background-color: #FFFFFF; border: 1px solid #DDDDDD;">
        <div style="background-color: #359f3a; color: #333333; padding: 20px; text-align: center;">
            <h2 style="max-width: 100%;">Your Account Credentials - SAWUX</h2>
        </div>
        <div style="padding: 20px;">
            <h2 style="color: #333333;">Your Account Credentials</h2>
            <p style="color: #555555;">Dear <strong>{{@$username}}</strong>,</p>
            <p>Here are your account details:</p>


            <p style="color: #555555;">Username: <strong>{{ @$username }}</strong></p>
            <p style="color: #555555;">Password: <strong>{{ @$password }}</strong></p>

            <p>If you did not request these credentials, please contact support immediately.</p>
            <p style="color: #555555;">Best regards, <br> The Admin Team</p>
        </div>
        <div style="background-color: #F4F4F4; padding: 10px; text-align: center; color: #999999;">
            &copy; {{ date('Y') }} SAWUX System. All rights reserved.
        </div>
    </div>
</body>
</html>
