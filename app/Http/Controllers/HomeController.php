<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        // Apply the auth middleware to all methods in this controller
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function admin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.dashboard');
    }
}
