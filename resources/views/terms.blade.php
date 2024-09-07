<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        h1 {
            font-family: 'Krona One', sans-serif;
            color: #1e8573;
        }
        .buttons {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            margin-right: 10px;
            color: white;
            background-color: #1e8573;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }
        .button:hover {
            background-color: #177a63;
        }
    </style>
</head>
<body>
    <h1>Terms of Service</h1>
    <p>Welcome to CARPO! By using our service, you agree to comply with the following terms:</p>
    <ul>
        <li>You must be at least 18 years old to use our service.</li>
        <li>You are responsible for the accuracy of the information you provide.</li>
        <li>Our service is provided "as is," and we do not guarantee uninterrupted or error-free operation.</li>
        <li>We reserve the right to modify or terminate our service at any time without prior notice.</li>
        <li>Use of our service is at your own risk, and we are not liable for any damages arising from your use of our service.</li>
    </ul>
    <p>For further details, please contact our support team.</p>
    <div class="buttons">
        <a href="{{ route('login') }}" class="button">Back to Login</a>
        <a href="{{ route('register.step.one') }}" class="button">Back to Register</a>
    </div>
</body>
</html>
