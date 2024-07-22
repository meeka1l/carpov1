<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARPO Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-dashboard">
        <div class="admin-header">
            <h1>CARPO</h1>
            <div class="admin-subheader">
                <h2>Earning Stats</h2>
                <canvas id="adminChart"></canvas>
                <h2>More Details</h2>
            </div>
            <div class="admin-button-group">
                <a href="#"><button class="admin-btn black-btn">Manage Users</button></a>
                <a href="#"><button class="admin-btn green-btn">View Analytics</button></a>
                <a href="#"><button class="admin-btn green-btn">View & Manage Complaints</button></a>
                <a href="{{ route('admin.manageStudentDatabase') }}"><button class="admin-btn black-btn">Manage Student Database File</button></a>
            </div>
             <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="text-align: center; margin-top: 20px;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('adminChart').getContext('2d');
        const adminChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Earnings',
                    data: [12, 19, 3, 5, 2, 3, 7],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
