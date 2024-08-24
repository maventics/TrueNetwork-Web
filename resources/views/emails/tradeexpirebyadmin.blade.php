<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Confirmation</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>Your trade has been completed  {{ $investment->scheme->title }}  by the admin on {{ \Carbon\Carbon::now()->format('Y-m-d h:i:s A') }}. Now you can claim the profits.</p>

    <p>This is a computer-generated email. Please do not reply to this email. For more queries, contact us at info@pakistanstockexchangeinvestor.com.</p>
</body>
</html>

