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

     
    public function showUserRides()
{
   // Get the currently authenticated user
   $user = Auth::user();
    
   // Debug: Check the logged-in user's email
   // dd($user->email);

   // Ensure you have a 'shared_email' column or adjust the column name accordingly
   $rides = Ride::where('email', $user->$id->1)->get();

   // Debug: Check the rides fetched
   // dd($rides);

   // Pass the rides to the view
   return view('ridesmatch', ['rides' => $rides]);}
  

}

