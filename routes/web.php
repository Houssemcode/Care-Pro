<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SettingsController;

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

// Register Routes
Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('register.admin.submit');
Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email');

// Reset Password Routes
Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Family Routes (Protected: Must be logged in AND have a Family profile)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:family'])->prefix('family')->name('family.')->group(function () {
    Route::get('/dashboard', [FamilyController::class, 'dashboard'])->name('dashboard');
    Route::get('/browse', [FamilyController::class, 'browse'])->name('browse');
    Route::post('/book/{offre_id}', [FamilyController::class, 'storeBooking'])->name('book.store');
    
    Route::get('/reports', [FamilyController::class, 'reports'])->name('reports');
    Route::post('/reports', [FamilyController::class, 'storeReport'])->name('reports.store');
    
    Route::get('/requests', [FamilyController::class, 'requests'])->name('requests');
    Route::post('/ratings', [FamilyController::class, 'storeRating'])->name('ratings.store');
    // Settings & Profile
    Route::get('/settings',  function () { return view('family.settings'); })->name('settings');
    Route::post('/settings/info', [SettingsController::class, 'updateInfo'])->name('settings.info');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    
    Route::get('/profile', [FamilyController::class, 'profile'])->name('profile');
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
    Route::post('/offres', [EmployeeController::class, 'storeOffre'])->name('offres.store');
    Route::get('/offers', [EmployeeController::class, 'offers'])->name('offers');    
    
    // Employee Pages
    Route::get('/reports', [EmployeeController::class, 'reports'])->name('reports');
    
    // Settings & Profile
    Route::get('/settings',  function () { return view('employee.settings'); })->name('settings');
    Route::post('/settings/info', [SettingsController::class, 'updateInfo'])->name('settings.info');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');
    Route::post('/documents/upload', [EmployeeController::class, 'uploadDocument'])->name('documents.upload');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected: Must be logged in AND be an Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');    
    Route::get('/users',     [AdminController::class, 'users'])->name('users');   
    
    Route::patch('/users/{user}/approve', [AdminController::class, 'approveEmployee'])->name('users.approve');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::patch('/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('reports.resolve');
    
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
    Route::patch('/requests/{id}/assign', [AdminController::class, 'assignRequest'])->name('requests.assign');
    Route::patch('/requests/{id}/reject', [AdminController::class, 'rejectRequest'])->name('requests.reject');
    
    // Settings & Profile
    Route::get('/settings',  function () { return view('admin.settings'); })->name('settings');    
    Route::post('/settings/info', [SettingsController::class, 'updateInfo'])->name('settings.info');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
});