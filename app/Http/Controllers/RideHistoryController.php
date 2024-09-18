<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ride;
use App\Models\PickupLocation; // Import PickupLocation model

class RideHistoryController extends Controller
{
    public function index()
    {
        // Get the logged-in user's email
        $userEmail = Auth::user()->email;

        // Fetch all rides for the logged-in user, including soft-deleted ones
        $rides = Ride::withTrashed()->where('email', $userEmail)->get();

        // Fetch all commuter pickup locations for the logged-in user, including soft-deleted ones
        $pickupLocations = PickupLocation::withTrashed()->where('user_id', Auth::id())->get();

        // Pass the rides and pickup locations data to the view
        return view('ride-history', compact('rides', 'pickupLocations'));
    }
}
