<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\User;
use App\Models\PickupLocation;
use Illuminate\Support\Facades\Auth;
class RideController extends Controller
{
    public function showNavigator()
    {
        return view('home', ['mode' => 'navigator']);
    }

    public function showCommuter()
    {
        // Fetch available rides for the commuter view
        $rides = Ride::all(); // Modify this as needed for your use case
        return view('home', ['mode' => 'commuter', 'rides' => $rides]);
    }
    public function rules()
    {
        return [
            'description' => ['required', function ($attribute, $value, $fail) {
                if (!preg_match('/^https:\/\/maps\.app\.goo\.gl\/[^\s]+$/', $value)) {
                    $fail('The ' . $attribute . ' must be a valid Google Maps link.');
                }
            }],
            // other rules...
        ];
    }
    public function store(Request $request)
{
    $user = auth()->user();
    // Check if the user already has a ride
    $existingRide = Ride::where('email', $user->email)->first();

    if ($existingRide) {
        return redirect()->back()->with('error', 'You can only share one ride at a time. Please delete your current ride to share a new one.');
    }

    // Validate the incoming request
    $validated = $request->validate([
        'vehicle_number' => 'required|string|max:255',
        'vehicle_color' => 'required|string|max:255',
        'vehicle_model' => 'required|string|max:255',
        'start_location' => 'required|string',
        'end_location' => 'required|string',
        'description' => 'required|string',
        'email' => 'requied|string', // Validate description
    ]);

    // Add the navigator_id (assuming the authenticated user is the navigator)
    $validated['navigator_id'] = auth()->id();

    // Create the ride using the validated data
    Ride::create([
        'vehicle_number' => $validated['vehicle_number'],
        'vehicle_color' => $validated['vehicle_color'],
        'vehicle_model' => $validated['vehicle_model'],
        'start_location' => $validated['start_location'],
        'end_location' => $validated['end_location'],
        'description' => $validated['description'],
        'navigator_id' => $user->id, // Save navigator ID
        'email' => $user->email,  // Save the user's email for checking ride uniqueness
  
    ]);
    $validated = $request->validate([
        'id' => 'required|exists:rides,id',
        
    ]);
    $validated['email'] = $user->email;
    $ride = Ride::findOrFail($validated['id']);
    // Redirect to the rides index with a success message
    return redirect()->route('rides.index')->with('status', 'Ride joined successfully!');
}


public function joinRide(Request $request)
{
    // Validate the input
    $request->validate([
        'ride_id' => 'required|exists:rides,id',
        'pickup_location' => 'required|string|max:255',
    ]);

    // Get the currently authenticated user
    $user = Auth::user();

    // Get the ride details
    $ride = Ride::findOrFail($request->ride_id);

    // Check if the user is a navigator for any ride
    $isNavigator = Ride::where('navigator_id', $user->id)->exists();

    if ($isNavigator) {
        return redirect()->back()->with('error', 'As a navigator, you cannot join any rides.');
    }

    // Check if the user is the navigator of the specific ride
    if ($ride->navigator_id == $user->id) {
        return redirect()->back()->with('error', 'You cannot join your own ride.');
    }

    // Check if the user already has a pickup location for this ride
    $existingPickupLocation = PickupLocation::where('ride_id', $request->ride_id)
                                           ->where('user_id', $user->id)
                                           ->first();

    if ($existingPickupLocation) {
        return redirect()->back()->with('error', 'You have already added a pickup location for this ride.');
    }

    // Check if the user already has 3 pickup locations in total
    if ($user->pickupLocations()->count()) {
        return redirect()->back()->with('error', 'You can only have up to 3 pickup locations.');
    }

    // Save the pickup location
    PickupLocation::create([
        'user_id' => $user->id,
        'ride_id' => $request->ride_id,
        'pickup_location' => $request->pickup_location,
    ]);

    // Return to the previous page without a message
    return redirect()->back();
}

public function accept($rideId)
{
    $ride = Ride::findOrFail($rideId);
    $ride->status = 'Accepted';
    $ride->save();

    return redirect()->back()->with('success', 'Ride accepted.');
}

public function reject($rideId)
{
    $ride = Ride::findOrFail($rideId);
    $ride->status = 'Rejected';
    $ride->save();

    return redirect()->back()->with('success', 'Ride rejected.');
}





    public function locate(Request $request)
    {
        // Handle location setting
        $validated = $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'location' => 'required|string',
        ]);

        // Logic to update location for a ride
        $ride = Ride::findOrFail($validated['ride_id']);
        // Update ride location logic here

        return response()->json(['status' => 'Location updated successfully!']);
    }
    
    
    public function searchRides(Request $request)
{
    $query = $request->input('query');

    // Search rides by description
    $rides = Ride::where('description', 'like', '%' . $query . '%')->get();

    // Return the results as JSON for AJAX request
    return response()->json($rides);
}


public function show()
{
    // Get the currently authenticated user
    $user = Auth::user();
    
    // Fetch rides where the logged-in user is the navigator
    $sharedRides = Ride::where('navigator_id', $user->id)->get();

    // Fetch all pickup locations for these rides
    $pickupLocations = PickupLocation::whereIn('ride_id', $sharedRides->pluck('id'))->get();

    // Fetch users who joined these rides
    $commuters = User::whereIn('id', $pickupLocations->pluck('user_id'))->get()->keyBy('id');

    // Pass the rides, pickup locations, and commuters to the view
    return view('ridematch', compact('sharedRides', 'pickupLocations', 'commuters', 'user'));
}

}


