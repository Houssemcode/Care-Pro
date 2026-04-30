<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

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
Route::get('/login', function () { 
    return view('index'); 
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register-admin', function () {
    return view('auth.register_admin');
})->name('register.admin');
Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('register.admin.submit');

/*
|--------------------------------------------------------------------------
| Family Routes (Protected: Must be logged in AND have a Family profile)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:family'])->prefix('family')->name('family.')->group(function () {
    Route::get('/dashboard', function () { return view('family.dashboard'); })->name('dashboard');
    Route::get('/profile',   function () { return view('family.profile'); })->name('profile');
    Route::get('/reports',   function () { return view('family.reports'); })->name('reports');
    Route::get('/requests',  function () { return view('family.requests'); })->name('requests');
    Route::get('/settings',  function () { return view('family.settings'); })->name('settings');
});

/*
|--------------------------------------------------------------------------
| Employee Routes (Protected: Must be logged in AND have an Employee profile)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    
    // Manage Requests
    Route::get('/requests', [EmployeeController::class, 'requests'])->name('requests');
    Route::patch('/requests/{id}/accept', [EmployeeController::class, 'acceptRequest'])->name('requests.accept');
    Route::patch('/requests/{id}/reject', [EmployeeController::class, 'rejectRequest'])->name('requests.reject');
    
    // Manage Offers
    Route::get('/offres/create', [EmployeeController::class, 'createOffre'])->name('offres.create');
    Route::get('/offers',    function () { return view('employee.offers'); })->name('offers');
    
    // Employee Pages
    Route::get('/profile',   function () { return view('employee.profile'); })->name('profile');
    Route::get('/reports',   function () { return view('employee.reports'); })->name('reports');
    Route::get('/settings',  function () { return view('employee.settings'); })->name('settings');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected: Must be logged in AND be an Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');    
    Route::get('/users',     [AdminController::class, 'users'])->name('users');   
    
    // Note: Removed 'admin.' from names inside the group to prevent duplicate prefixes
    Route::patch('/users/{user}/approve', [AdminController::class, 'approveEmployee'])->name('users.approve');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    
    Route::get('/profile',   function () { return view('admin.profile'); })->name('profile');
    
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::patch('/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('reports.resolve');
    
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
    Route::patch('/requests/{id}/assign', [AdminController::class, 'assignRequest'])->name('requests.assign');
    Route::patch('/requests/{id}/reject', [AdminController::class, 'rejectRequest'])->name('requests.reject');
    
    Route::get('/settings',  function () { return view('admin.settings'); })->name('settings');    
});