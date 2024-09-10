<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    // Pass ride details to the view
    return view('riderequest', compact('ride'));
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

