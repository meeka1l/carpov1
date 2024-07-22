<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Carpo</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1 class="carpo-heading">CARPO</h1>
        </header>
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <input id="password" type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <p>Don't have an account? <a href="{{ route('register.step.one') }}">Register</a></p>
        </form>
    </div>
</body>
</html>
