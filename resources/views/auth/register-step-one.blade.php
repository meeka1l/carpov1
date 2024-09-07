<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Carpo</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>CARPO</h1>
        </header>
        <h2>Sign Up</h2>
        <p>Fill in the below details to sign up.</p>
        <form method="POST" action="{{ route('register.step.one.post') }}">
            @csrf
            <div class="form-group">
                <input id="name" type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" onkeypress="return /[a-zA-Z ]/.test(event.key)" onpaste="return false;" required autofocus>
            </div>
            <div class="form-group">
                <input id="phone_number" type="text" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}" pattern="\d{10}" title="Phone number must be 10 digits" maxlength="10" onkeypress="return /[0-9]/.test(event.key)" onpaste="return false;" required>
            </div>
            <div class="form-group">
                <input id="nic" type="text" name="nic" placeholder="NIC" value="{{ old('nic') }}" maxlength="12" minlength="9" onkeypress="return /[a-zA-Z 0-9]/.test(event.key)" onpaste="return false;" required>
              <br>
                @error('nic')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input id="address" type="text" name="address" placeholder="Address" value="{{ old('address') }}" onkeypress="return /[a-zA-Z 0-9 , -]/.test(event.key)" onpaste="return false;" required>
            </div>
            <div class="form-group">
                <input id="email" type="email" name="email" placeholder="Student Email" value="{{ old('email') }}" onpaste="return false;" required pattern="^[cC][bB]\d{6}@students\.apiit\.lk$" title="Email must be in the format: cbxxxxxx@students.apiit.lk" oninput="checkEmailFormat()">
            </div><br>
            @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            <div class="form-group">
                <input id="password" type="password" name="password" placeholder="Password" required minlength="12" onpaste="return false;">
            </div>
            <div class="form-group">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" required minlength="12" onpaste="return false;" oninput="checkPasswordMatch();">
            </div>
            <div class="form-group">
                <button type="submit">Proceed</button>
            </div>
            <p>By clicking continue, you agree to our <a href="{{ route('terms') }}">Terms of Service</a> and <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>
            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </form>
    </div>
    <script>
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("password_confirmation").value;

            if (password !== confirmPassword) {
                document.getElementById("password_confirmation").setCustomValidity("Passwords do not match.");
            } else {
                document.getElementById("password_confirmation").setCustomValidity("");
            }
        }

        function checkEmailFormat() {
            var email = document.getElementById("email").value;
            var emailPattern = /^[cC][bB]\d{6}@students\.apiit\.lk$/;

            if (!emailPattern.test(email)) {
                document.getElementById("email").setCustomValidity("Email must be in the format: cb000000@students.apiit.lk");
            } else {
                document.getElementById("email").setCustomValidity("");
            }
        }
    </script>
</body>
</html>
