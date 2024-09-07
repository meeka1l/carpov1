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
            font-family: sans-serif;
        }
        .logo{
            font-size: 2em;
            font-family: 'Krona One', sans-serif;
            color: black;
        }
        .form-group {
            margin-bottom: 1em;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: .5em;
        }
        input {
            width: 100%;
            padding: .75em;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: .5em;
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
    </style>
</head>
<body>
    <div class="container">
        <h1 class="logo">CARPO</h1>
        <h1>Reset Password</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn">
                {{ __('Reset Password') }}
            </button>
        </form>
    </div>
</body>
</html>
