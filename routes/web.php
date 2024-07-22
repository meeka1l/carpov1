<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

// Redirect root to registration step one
Route::get('/', function () {
    return redirect()->route('register.step.one');
});

// Home Page Route - Use HomeController and apply auth middleware
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showStepOneForm'])->name('register.step.one');
Route::post('/register', [RegisterController::class, 'postStepOneForm'])->name('register.step.one.post');
Route::get('/register/step-two', [RegisterController::class, 'showStepTwoForm'])->name('register.step.two');
Route::post('/register/step-two', [RegisterController::class, 'postStepTwoForm'])->name('register.step.two.post');
