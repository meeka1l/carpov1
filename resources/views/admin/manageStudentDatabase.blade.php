<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Database</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="manage-student-db">
        <div class="admin-header">
            <h1>CARPO</h1>
            <div class="admin-button-group2">
                <form action="{{ route('upload.student.data') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="student_data" required>
                    <button type="submit" class="admin-btn black-btn">Upload Student Data *.csv</button>
                </form>
                <a href="{{ route('admin.download-student-data') }}"><button class="admin-btn green-btn">Download Current Student Data *.csv</button></a>
            </div>
            
        </div>
        <a href="{{ route('admin.dashboard') }}"><button class="admin-btn green-btn2">Home</button></a>
    </div>
    
</body>
</html>
