<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;

class HomeController extends Controller
{
    public function __construct()
    {
        // Apply the auth middleware to all methods in this controller
        $this->middleware('auth');
    }

    public function index()
    {
        $rides = Ride::all(); // Fetch all rides from the database
        return view('home', compact('rides'));
    }

    public function admin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.dashboard');
    }

}
