<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Documents - Carpo</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
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
        <h3>Upload images of the following:</h3>
        </div>
        <form method="POST" action="{{ route('register.step.two.post') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group2">
                <label for="nic_front">NIC Front:</label>
                <input id="nic_front" type="file" name="nic_front" accept="image/*" required>
            </div>
            <div class="form-group2">
                <label for="nic_back">NIC Back:</label>
                <input id="nic_back" type="file" name="nic_back" accept="image/*" required>
            </div>
            <div class="form-group2">
                <label for="student_id_front">Student ID Front:</label>
                <input id="student_id_front" type="file" name="student_id_front" accept="image/*" required>
            </div>
            <div class="submit-group2">
                <button type="submit">Complete Registration</button>
            </div>
        </form>
    </div>
</body>
</html>
