<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2em;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 1.5em;
            color: #1e8573;
            margin-bottom: 1em;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1em;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: .5em;
        }
        input[type="email"] {
            width: 100%;
            padding: .75em;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            display: block;
            width: 100%;
            padding: .75em;
            background-color: #1e8573;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            background-color: #177a63;
        }
        .alert {
            margin-bottom: 1em;
            padding: .75em;
            border-radius: 4px;
            color: white;
            text-align: center;
        }
        .alert-success {
            background-color: #28a745;
        }
        .alert-danger {
            background-color: #dc3545;
        }
        .logo {
            font-family: 'Krona One', sans-serif;
            font-size: 2em; 
            color: black;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: transform 0.6s ease-in-out, color 0.3s ease-in-out;
        }
        .logo:hover {
            transform: rotateY(360deg);
            color: #177a63;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('login') }}" class="logo">CARPO</a>
        <h1>Reset Password</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn">
                {{ __('Send Password Reset Link') }}
            </button>
        </form>
    </div>
</body>
</html>
