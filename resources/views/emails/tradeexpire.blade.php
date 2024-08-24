<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Confirmation</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>Your trade has expired in {{ $investment->scheme->title }} on {{ \Carbon\Carbon::now()->format('Y-m-d h:i:s A') }}. This trade will automatically expire on {{ \Carbon\Carbon::parse($investment->end_date_timestamp)->format('Y-m-d h:i:s A') }}, after which you will be able to claim the profits.</p>

    <p>This is a computer-generated email. Please do not reply to this email. For more queries, contact us at info@pakistanstockexchangeinvestor.com.</p>
</body>
</html>
