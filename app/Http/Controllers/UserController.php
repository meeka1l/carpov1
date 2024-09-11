<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Show the edit profile form
    public function editProfile()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Return the view with user data
        return view('user.profile', compact('user'));
    }

    // Update the user profile
    public function updateProfile(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'required|string|max:15',
            'nic' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        // Update the authenticated user's profile
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'nic' => $request->nic,
            'address' => $request->address,
        ]);

        // Redirect back to profile page with a success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
