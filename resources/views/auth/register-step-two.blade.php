<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Registration - Carpo</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="leftwrapper">
        <header class="header2">
            <h1>CARPO</h1>
        </header>
        <h2>Register Information</h2>
        <h3>Complete Registration</h3>
        </div>
        <form method="POST" action="{{ route('register.step.two.post') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="submit-group2">
                <button type="submit">Complete Registration</button>
            </div>
        </form>
    </div>
    
</body>
</html>
