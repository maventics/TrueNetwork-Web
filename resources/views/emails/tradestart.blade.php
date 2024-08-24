<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Confirmation</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>Your {{ $user->name }} has been invested in {{ $investment->scheme->title }} on {{ now()->format('Y-m-d H:i:s') }}. This trade will auto expire on {{ $investment->end_date_timestamp }}, then you will be able to claim the profits.</p>

    <p>This is a computer-generated email. Please do not reply to this email. For more queries, contact us at info@pakistanstockexchangeinvestor.com.</p>
</body>
</html>
