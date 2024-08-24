<!DOCTYPE html>
<html>
<head>
    <title>Deposit Request Accepted</title>
</head>
<body>
    <p>Congratulations {{ $user->name }}</p>
    <p>Your deposit request made on {{ now()->toDateTimeString() }} has been accepted. Your deposit amount of PKR{{ $depositamount->depositamount }} can be invested in schemes.</p>
    <p>Enjoy the seamless experience of profiting from Pakistan Stock Exchange Investors network.</p>
    <br>
    <p>This is a computer-generated email. Please do not reply to this email. For more queries, contact us at info@pakistanstockexchangeinvestor.com.</p>
    
</body>
</html>
