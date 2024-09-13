<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <style>
        h1{
            font-family: 'Krona One',sans-serif;
            margin-top: 20%;
        }    
        .back-button {
    display: block;
    background-color: black; /* Changed to 'background-color' for consistency */
    color: white;
    border: none;
    padding: 15px 20px; /* Adjusted padding for a more balanced look */
    text-align: center;
    text-decoration: none;
    border-radius: 30px;
    cursor: pointer;
    max-width: 150px; /* Set a specific max width */
    font-size: 1.0em; /* Adjusted font size */
    position: fixed;
    top: 5%; /* Center vertically */
    left: 3%; /* Distance from the left side */
    transform: translateY(-50%); /* Center alignment adjustment */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Added shadow for better visibility */
    z-index: 1000; /* Ensures the button is above other elements */
    margin: 0;
}
.confirm_button{
    background-color: #21d5b6;
    color: white;
    padding: 5%;
    border: none;
    border-radius: 20px;
    font-weight: bolder;
    margin-left: 30%;
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Profile</h1>
        
        <!-- SweetAlert2 -->
        @if(session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    showConfirmButton: true,
                    timer: 1000 // Time in milliseconds (1000 ms = 1 second)
                });
            </script>
        @endif

        <!-- Profile Edit Form -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" required>
            </div>
            <div class="form-group">
                <label for="emergency_contact">Emergency Contact</label>
                <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ $user->emergency_contact }}" pattern="[0-9\s\-\+\(\)]*" placeholder="eg:0712312345" >
            </div>
            <div class="form-group">
                <label for="nic">NIC</label>
                <input type="text" class="form-control" id="nic" name="nic" value="{{ $user->nic }}" readonly>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
            </div>
            <button type="submit" class="confirm_button">Update Profile</button>
        </form>
    </div>

    <!-- Back Button -->
    <button class="back-button" onclick="window.location.href='{{ route('home') }}'">&larr;</button>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>
