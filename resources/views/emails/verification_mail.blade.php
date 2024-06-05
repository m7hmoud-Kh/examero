<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
            <h2>Email Verification</h2>
            <p>Hello, {{$emailData->first_name}}  {{$emailData->last_name}}</p>
            <p>Welcome to our platform! Please click the button below to verify your email address:</p>
            <p><a  href="{{config('app.frontAppUrl')}}/verify-account?token={{$emailData->remember_token}}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none;">Verify Email</a></p>
            <p>If you didn't create an account with us, you can safely ignore this email.</p>
            <p>Thank you,</p>
            <p>Examero</p>
        </div>

    </div>
</body>

</html>
