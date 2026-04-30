<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;


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
// 1. The GET route: Shows the page to the user
// (If you moved your login page to auth/login.blade.php, change 'index' to 'auth.login')
Route::get('/login', function () { 
    return view('index'); 
})->name('login');

// 2. The POST route: Processes the secure form submission
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('register.admin.submit');
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
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');    
    Route::get('/users',     [AdminController::class, 'users'])->name('users');   
    Route::patch('/users/{user}/approve', [AdminController::class, 'approveEmployee'])->name('admin.users.approve');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    Route::get('/profile',   function () { return view('admin.profile'); })->name('profile');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::patch('/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('reports.resolve');
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
    Route::patch('/requests/{id}/assign', [AdminController::class, 'assignRequest'])->name('admin.requests.assign');
    Route::patch('/requests/{id}/reject', [AdminController::class, 'rejectRequest'])->name('admin.requests.reject');
    Route::get('/settings',  function () { return view('admin.settings'); })->name('settings');    
});