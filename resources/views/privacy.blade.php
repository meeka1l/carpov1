<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
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
    <h1>Privacy Policy</h1>
    <p>At CARPO, your privacy is important to us. This policy outlines how we collect, use, and protect your personal information:</p>
    <ul>
        <li>We collect personal information when you register, use our services, or contact us.</li>
        <li>We use your information to provide, improve, and maintain our services.</li>
        <li>We do not share your personal information with third parties, except as required by law.</li>
        <li>We use industry-standard security measures to protect your data.</li>
        <li>You have the right to access, correct, or delete your personal information at any time.</li>
    </ul>
    <p>If you have any questions or concerns about our privacy practices, please contact us.</p>
    <div class="buttons">
        <a href="{{ route('login') }}" class="button">Back to Login</a>
        <a href="{{ route('register.step.one') }}" class="button">Back to Register</a>
    </div>
</body>
</html>
