<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function manageStudentDatabase()
    {
        return view('admin.manageStudentDatabase');
    }
    // In AdminController.php
    public function manageUsers(Request $request)
    {
        $search = $request->input('search');
    
        // Fetch users based on search criteria
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('phone_number', 'like', "%{$search}%")
                          ->orWhere('nic', 'like', "%{$search}%");
                });
            })
            ->get();
    
        return view('admin.manage-users', compact('users'));
    }
    

    public function storeUser(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:user,admin',
            'phone' => 'required|string|max:15',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role' => $request->role,
            'phone_number' => $request->phone,
            'nic' => $request->nic,
            'address' =>  $request->address,
        ]);

            return redirect()->route('admin.manageUsers')->with('success', 'User added successfully!');
    }


    public function updateUser(Request $request, $id)
    {
        // Retrieve the user by ID
        $user = User::findOrFail($id);
    
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:user,admin',
        ]);
    
        // Update user data
        $user->update([
            'name' => $request->name,
            'role' => $request->role,
            'phone_number' => $request->phone,
            'nic' => $request->nic,
            
        ]);
    
        // Redirect back to the user management page with a success message
        return redirect()->route('admin.manageUsers')->with('success', 'User updated successfully!');
    }
    

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.manageUsers')->with('success', 'User deleted successfully!');
}




}

