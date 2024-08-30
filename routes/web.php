<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentDataController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\RideMatchingController;
use App\Http\Controllers\ChatController;


// Redirect root to registration step one
Route::get('/', function () {
    return redirect()->route('login');
});

// Home Page Route - Use HomeController and apply auth middleware
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Admin Dashboard Route - Use HomeController and apply auth middleware
Route::get('/admin/dashboard', [HomeController::class, 'admin'])->name('admin.dashboard')->middleware('auth');

// Manage Student Database Route - Use AdminController and apply auth middleware
Route::get('/admin/manage-student-database', [AdminController::class, 'manageStudentDatabase'])->name('admin.manageStudentDatabase')->middleware('auth');

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showStepOneForm'])->name('register.step.one');
Route::post('/register', [RegisterController::class, 'postStepOneForm'])->name('register.step.one.post');
Route::get('/register/step-two', [RegisterController::class, 'showStepTwoForm'])->name('register.step.two');
Route::post('/register/step-two', [RegisterController::class, 'postStepTwoForm'])->name('register.step.two.post');


// Upload Student Data Route
Route::post('/upload-student-data', [StudentDataController::class, 'uploadStudentData'])->name('upload.student.data');

// Route for downloading student data as CSV
Route::get('/admin/download-student-data', [StudentDataController::class, 'downloadStudentData'])->name('admin.download-student-data');



Route::get('/navigator', [RideController::class, 'showNavigator'])->name('navigator');
Route::get('/commuter', [RideController::class, 'showCommuter'])->name('commuter');
Route::post('/rides', [RideController::class, 'store'])->name('rides.store');

Route::post('/rides/join', [RideController::class, 'joinRide'])->name('rides.join');
Route::post('/rides/locate', [RideController::class, 'locate'])->name('rides.locate');

Route::post('/rides/end', [RideController::class, 'endRide'])->name('rides.end');
Route::get('/rides/search', [RideController::class, 'searchRides']);

//Route::get('/rides/match', [RideMatchingController::class, 'store'])->name('ride.match');
Route::get('/rides/match', [RideController::class, 'show'])->name('rides.index');
Route::get('/rides/request', [RideMatchingController::class, 'showRideRequestPage'])->name('rides.request');
Route::get('/ridematch', [RideController::class, 'show'])->name('ridematch');

Route::post('/rides/{ride}/accept', [RideController::class, 'accept'])->name('rides.accept');
Route::post('/rides/{ride}/reject', [RideController::class, 'reject'])->name('rides.reject');
Route::delete('/rides/{id}/delete', [RideController::class, 'delete'])->name('rides.delete');
Route::delete('/ride-requests/{id}/delete', [RideController::class, 'deleteRequest'])->name('rideRequests.delete');
Route::post('/rides/{ride}/start', [RideController::class, 'start'])->name('rides.start');
Route::post('/rides/end/{ride}', [RideController::class, 'end'])->name('rides.end'); // Add this line

Route::get('/chat/{ride_id}', [ChatController::class, 'showChat'])->name('chat');
Route::post('/chat/{ride_id}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/chat/{ride_id}/messages', [ChatController::class, 'getMessages'])->name('chat.getMessages');