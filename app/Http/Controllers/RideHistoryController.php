<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ride;

class RideHistoryController extends Controller
{
    public function index()
    {
        // Get the logged-in user's email
        $userEmail = Auth::user()->email;

        // Fetch all rides for the logged-in user, including soft-deleted ones
        $rides = Ride::withTrashed()->where('email', $userEmail)->get();

        
        // Pass the rides data to the view
        return view('ride-history', compact('rides'));
    }
    
}
