<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\User;
use App\Models\PickupLocation;
use Illuminate\Support\Facades\Auth;
class RideController extends Controller
{

    public function index(Request $request)
{
    $user = auth()->user(); // Get the authenticated user

    // Get the filter value from the request
    $apiitRoute = $request->query('apiit_route');

    // Initialize the query
    $query = Ride::query();

    // Apply the filter if provided
    if ($apiitRoute) {
        $query->where('apiit_route', $apiitRoute);
    }

    // Fetch the filtered rides
    $rides = $query->get();

    // Return the view with filtered rides and user
    return view('home', compact('rides', 'user'));
}


    public function acceptCommuter($rideId, $locationId)
{
    $pickupLocation = PickupLocation::where('id', $locationId)->where('ride_id', $rideId)->firstOrFail();

    if ($pickupLocation->status !== 'pending') {
        return redirect()->back()->with('error', 'Commuter has already been processed.');
    }

    $pickupLocation->status = 'accepted';
    $pickupLocation->save();

    // Optionally, you can add notifications or other logic here.

    return redirect()->back()->with('status', 'Commuter accepted successfully.');
}

public function rejectCommuter($rideId, $locationId)
{
    $pickupLocation = PickupLocation::where('id', $locationId)->where('ride_id', $rideId)->firstOrFail();

    if ($pickupLocation->status !== 'pending') {
        return redirect()->back()->with('error', 'Commuter has already been processed.');
    }

    $pickupLocation->status = 'rejected';
    $pickupLocation->save();

    // Optionally, you can add notifications or other logic here.

    return redirect()->back()->with('status', 'Commuter rejected successfully.');
}

    public function endJourney(Request $request, Ride $ride)
    {
        // Get the commuter's user ID (assuming it's stored in $request or $ride)
        $commuterId = auth()->id(); // Or replace with the correct method to fetch commuter's ID

        // Delete the commuter's pickup location associated with the ride
        PickupLocation::where('ride_id', $ride->id)
                      ->where('user_id', $commuterId) // Assumes there's a user_id column in pickup_locations
                      ->delete();

        // Optionally, update the ride status to 'Ended'
        //$ride->update(['status' => 'Ended']);

        // Redirect back with a success message
        return redirect()->route('home')->with('success', 'The ride has ended and your pickup location has been deleted.');
    }

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
        'departure_datetime' => 'required|date|after:now',
        'apiit_route' => 'required|string|in:from,to',
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
        'user_name' => Auth::user()->name, // Automatically populate user_name
        'planned_departure_time' => $validated[ 'departure_datetime'],
        'apiit_route' => $validated['apiit_route'],    
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
        'pickup_location' => 'required|string',
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
    if ($user->pickupLocations()->count() >= 3) {
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

    // Check the number of accepted rides for this navigator
    $acceptedRidesCount = Ride::where('navigator_id', $ride->navigator_id)
                              ->where('status', 'Accepted')
                              ->count();

    if ($acceptedRidesCount >= 3) {
        return redirect()->back()->with('error', 'You have already accepted the maximum number of rides.');
    }

    $ride->status = 'Accepted';
    $ride->save();

    // Optionally notify the user who made the request
    $this->notifyUser($ride->user_id, 'Your ride request has been accepted.');

    return redirect()->back()->with('success', 'Ride accepted.');
}


public function reject($rideId)
{
    $ride = Ride::findOrFail($rideId);
    $ride->status = 'Rejected';
    $ride->save();

    $pickupLocations = PickupLocation::where('ride_id', $rideId)->get();
    foreach ($pickupLocations as $pickupLocation) {
        $pickupLocation->delete();
    }
    // Optionally notify the user who made the request
    $this->notifyUser($ride->user_id, 'Your ride request has been rejected.');

    return redirect()->back()->with('success', 'Ride rejected.');
}

protected function notifyUser($userId, $message)
{
    $user = User::find($userId);
    // Here you could use a notification or just store a flash message or something in the database.
    // Example:
    // $user->notify(new RideStatusNotification($message));
}
public function delete($rideId)
{
    $ride = Ride::findOrFail($rideId);

    // Ensure that only the navigator who accepted the ride can delete it
    if ($ride->navigator_id != auth()->user()->id) {
        return redirect()->back()->with('error', 'You are not authorized to delete this ride.');
    }
    $pickupLocations = PickupLocation::where('ride_id', $rideId)->get();
    foreach ($pickupLocations as $pickupLocation) {
        $pickupLocation->delete();
    }
    // Delete the ride
    $ride->delete();

    // Optionally notify the commuter that the ride was deleted
    $this->notifyUser($ride->user_id, 'Your ride request has been deleted by the navigator.');

   // return redirect()->back()->with('success', 'Ride deleted successfully.');
    return redirect()->route('home')->with('status', 'Ride deleted successfully!');
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
    
    public function showPaymentPage($ride_id)
{
    $ride = Ride::find($ride_id);

    $distance_ = 0;
    $description = '';
    $pickup_locations = [];
    $user_descriptions = []; // Array to store commuter descriptions

    if ($ride) {
        // Get description from the ride
        $description = $ride->description;
        $pattern = '/(\d+(\.\d+)?)\s+km/i';
        
        if (preg_match($pattern, $description, $matches)) {
            $distance_ = (float) $matches[1];
        }

        // Get pickup locations and user descriptions for the ride_id
        $pickup_locations = PickupLocation::where('ride_id', $ride_id)->get();

        // Assuming 'description' is a column in 'pickup_locations' table
        foreach ($pickup_locations as $key => $pickup) {
            $user_descriptions[$key + 1] = $pickup->pickup_location?? 'N/A';  // Index starts from 1 for display
        }
    }

    return view('payment', compact('distance_', 'description', 'user_descriptions'));
}


    public function searchRides(Request $request)
{
    $query = $request->input('query');

    // Search rides by description
    $rides = Ride::where('description', 'like', '%' . $query . '%')->get();

    // Return the results as JSON for AJAX request
    return response()->json($rides);
}
public function start(Request $request, Ride $ride)
{
    $ride->status = 'Started';
    $ride->start_time = now();
    $ride->save();

    return redirect()->back()->with('status', 'Ride started successfully!');
}

public function show()
{
    // Get the currently authenticated user
    $user = Auth::user();
    
    // Fetch rides where the logged-in user is the navigator
    $sharedRides = Ride::where('navigator_id', $user->id)->get();

    // Debugging: Check if sharedRides is fetched correctly
    if ($sharedRides->isEmpty()) {
        //dd('No shared rides found for user: ' . $user->id);
        return redirect()->back()->with('error', 'There are no rides. (Refresh)');
    }

    // Fetch all pickup locations for these rides
    $pickupLocations = PickupLocation::whereIn('ride_id', $sharedRides->pluck('id'))->get();

    // Fetch users who joined these rides
    $commuters = User::whereIn('id', $pickupLocations->pluck('user_id'))->get()->keyBy('id');

    // Pass the rides, pickup locations, and commuters to the view
    return view('ridematch', compact('sharedRides', 'pickupLocations', 'commuters', 'user'));
}


public function end(Ride $ride)
{
    // Calculate the duration
    $startTime = \Carbon\Carbon::parse($ride->start_time);
    $endTime = now();
    $duration = $startTime->diff($endTime)->format('%H:%I:%S');

    // Update the ride status and end time
    $ride->status = 'Ended';
    $ride->end_time = $endTime;
    $ride->duration = $duration; // Assuming you have a 'duration' column in your 'rides' table
    $ride->save();

    // Redirect to the payment route with the ride_id parameter
    return redirect()->route('payment', ['ride_id' => $ride->id])->with('status', 'Ride ended successfully.');
}
}


