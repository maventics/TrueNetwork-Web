<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    @if($id)
        <p>Referral ID: {{ $id }}</p>
    @else
        <p>No Referral ID provided.</p>
    @endif
    <form action="/submit-signup" method="post">
        @csrf
        <!-- form fields here -->
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
