<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('index');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('register.admin.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register-admin', function () {
    return view('auth.register_admin');
})->name('register.admin');

/*
|--------------------------------------------------------------------------
| Family Routes
|--------------------------------------------------------------------------
*/
Route::prefix('family')->name('family.')->group(function () {
    Route::get('/dashboard', function () { return view('family.dashboard'); })->name('dashboard');
    Route::get('/profile',   function () { return view('family.profile'); })->name('profile');
    Route::get('/reports',   function () { return view('family.reports'); })->name('reports');
    Route::get('/requests',  function () { return view('family.requests'); })->name('requests');
    Route::get('/settings',  function () { return view('family.settings'); })->name('settings');
});

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
*/
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', function () { return view('employee.dashboard'); })->name('dashboard');
    Route::get('/offers',    function () { return view('employee.offers'); })->name('offers');
    Route::get('/profile',   function () { return view('employee.profile'); })->name('profile');
    Route::get('/reports',   function () { return view('employee.reports'); })->name('reports');
    Route::get('/settings',  function () { return view('employee.settings'); })->name('settings');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::get('/users',     function () { return view('admin.users'); })->name('users');
    Route::get('/profile',   function () { return view('admin.profile'); })->name('profile');
    Route::get('/reports',   function () { return view('admin.reports'); })->name('reports');
    Route::get('/requests',  function () { return view('admin.requests'); })->name('requests');
    Route::get('/settings',  function () { return view('admin.settings'); })->name('settings');
});