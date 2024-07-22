<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Admin Dashboard</h1>
        </header>
        <h2>Welcome to the Admin Dashboard</h2>
        
        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>
</html>
