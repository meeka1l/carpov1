<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;

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
   return '/rides/match';
}

    public function join(Request $request)
    {
        // Handle joining a ride
        $validated = $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'pickup_location' => 'required|string',
        ]);

        $ride = Ride::findOrFail($validated['ride_id']);
        // Logic to join the ride (e.g., updating ride status, adding commuter info, etc.)

        return redirect()->route('rides.match')->with('status', 'Ride joined successfully!');
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



}
