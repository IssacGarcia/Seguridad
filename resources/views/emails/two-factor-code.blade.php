<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #333;">Two-Factor Authentication</h2>
        <p style="font-size: 16px; color: #555;">Your <strong style="color: #007BFF;">2FA code</strong> is:</p>
        <p style="font-size: 24px; font-weight: bold; text-align: center; color: #28a745;">
            {{ $code }}
        </p>
        <p style="font-size: 14px; color: #555;">This code will expire in <strong style="color: #dc3545;">3 minutes</strong>.</p>
        <p style="text-align: center; font-size: 14px; color: #777;">If you didn't request this, please ignore this email.</p>
    </div>

</body>
</html>

