<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <style>
        h1{
            font-family: 'Krona One', sans-serif;
            color: #70d5c3;
        }
        .logo{
            font-size: 2em;
            color: black;
        }    
        .editbtn{
            background-color: #e09a4e;
            border: none;
        }
        .backbtn {
    background-color: black;
    color: white;
    font-size: 1.2em;
    border: none;
    border-radius: 20px;
    width: 100%;
    margin-bottom: 5%;
    margin-top: 5%;
}
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 logo">CARPO</h1>
        <h1 class="mt-5">User Management</h1>
        
        <!-- Add User Button -->
        <button class="btn btn-success mt-3" data-toggle="modal" data-target="#addUserModal">Add User</button>

        <!-- Search Bar -->
        <input type="text" id="search" class="form-control mt-3" placeholder="Search by name, email, phone, or NIC">

        <!-- Users Table -->
        <table class="table table-striped mt-3" id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>NIC</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->nic }}</td>
                    <td>
                        <!-- View Details Button -->
                        <button class="btn btn btn-info btn-sm" data-toggle="modal" data-target="#viewUserModal{{ $user->id }}">View Details</button>
                        <!-- Edit Button -->
                        <button class="editbtn btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">Edit</button>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- View User Details Modal -->
                <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">User Details: {{ $user->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p><strong>ID:</strong> {{ $user->id }}</p>
                                <p><strong>Name:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Role:</strong> {{ $user->role }}</p>
                                <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                                <p><strong>NIC:</strong> {{ $user->nic }}</p>
                                <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
                                <p><strong>Emergency Contact:</strong> {{ $user->emergency_contact ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User: {{ $user->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" name="role">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ $user->phone_number }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nic">NIC</label>
                                        <input type="text" class="form-control" name="nic" value="{{ $user->nic }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.storeUser') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" name="role">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="nic">NIC</label>
                                <input type="text" class="form-control" name="nic" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="form-group">
                                <span>Default Password: password</span>
                            </div>
                            <button type="submit" class="btn btn-success">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Back Button -->
        <button class="backbtn btn btn-secondary mt-3" onclick="window.location.href='{{ route('admin.dashboard') }}'">&larr;Back</button>


    </div>

    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                showConfirmButton: true,
                timer: 3000
            });
        </script>
    @endif

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => 
                    cell.textContent.toLowerCase().includes(searchTerm)
                );
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
</body>
</html>
