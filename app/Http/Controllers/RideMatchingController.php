<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\PickupLocation; // Add this import


class RideMatchingController extends Controller
{
    /**
     * Display a listing of the matched rides.
     *
     * @return \Illuminate\Http\Response
     */
    
     
// In RideMatchingController

public function showRideRequestPage(Request $request)
{
    // Retrieve ride details using the ride_id passed as a query parameter
    $rideId = $request->query('ride_id');
    $ride = Ride::findOrFail($rideId);

    // Fetch pickup locations for the specific ride
    $pickupLocations = PickupLocation::where('ride_id', $rideId)->get();
    // Pass ride details to the view
    return view('riderequest', compact('ride','pickupLocations'));
}
    
    public function showUserRides()
{
   // Get the currently authenticated user
   $user = Auth::user();
    
   // Debug: Check the logged-in user's email
   // dd($user->email);

   // Ensure you have a 'shared_email' column or adjust the column name accordingly
   $rides = Ride::where('email', $user->$email)->get();

   // Debug: Check the rides fetched
   // dd($rides);

   // Pass the rides to the view
   return view('ridesmatch', ['rides' => $rides]);}
  

}

