<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Carpo</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>CARPO</h1>
        </header>
        <h2>Welcome to Carpo</h2>
        
        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="text-align: center; margin-top: 20px;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>
</html>
