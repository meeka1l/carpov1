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

    public function store(Request $request)
    {
        // Validate and store the ride
        $validated = $request->validate([
            'vehicle_number' => 'required|string|max:255',
            'vehicle_color' => 'required|string|max:255',
            'vehicle_model' => 'required|string|max:255',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
        ]);
         // Add the navigator_id to the validated data
    $validated['navigator_id'] = auth()->id(); // Assuming the authenticated user is the navigator


        $ride = Ride::create($validated);

        return redirect()->route('home')->with('status', 'Ride shared successfully!');
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

        return redirect()->route('home')->with('status', 'Ride joined successfully!');
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
}
