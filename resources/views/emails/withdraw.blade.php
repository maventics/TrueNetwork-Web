<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Confirmation</title>
</head>
<body>
    <p>Congratulations {{ $user->name }},</p>
    
    <p>Your withdrawal request made on {{ $withdrawRequest->created_at->format('Y-m-d H:i:s') }} has been accepted. {{ $withdrawRequest->withdrawamount }} has been deposited into your account at {{ $withdrawRequest->bank->bank }} with the last four digits ********{{ substr($withdrawRequest->accountnumber, -4) }} </p>
  
    <p>This is a computer-generated email. Please do not reply to this email. For more queries, contact us at info@pakistanstockexchangeinvestor.com.</p>
</body>
</html>
