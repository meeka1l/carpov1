<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Carpo</h1>
        </header>
        <h2>Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
            <div class="form-group">
                <a href="{{ route('login') }}" class="register-button">Login</a>
            </div>
        </form>
    </div>
</body>
</html>
