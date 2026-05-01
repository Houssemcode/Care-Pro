<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Family;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- 1. Handle Registration ---
    public function register(Request $request)
    {
        // Validate the incoming form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:family,employee'
        ]);

        // Create the core User record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Always hash passwords!
        ]);

        // Create their specific role profile and redirect
        if ($request->role === 'family') {
            Family::create([
                'user_id' => $user->id,
            ]);
            // Create a default localization record for the user
            \App\Models\Localization::create([
                'user_id' => $user->id,
                'wilaya' => '',
                'commune' => '',
                'latitude' => 0,
                'logitude' => 0,
            ]);
            Auth::login($user);
            return redirect()->route('family.dashboard');
        } else {
            Employee::create([
                'user_id' => $user->id
            ]);
            // Create a default localization record for the user
            \App\Models\Localization::create([
                'user_id' => $user->id,
                'wilaya' => '',
                'commune' => '',
                'latitude' => 0,
                'logitude' => 0,
            ]);
            Auth::login($user);
            return redirect()->route('employee.dashboard');
        }
    }

    // --- 2. Handle Login ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Determine their role by checking the related tables and redirect
            if (Admin::where('user_id', $user->id)->exists()) {
                return redirect()->route('admin.dashboard');
            } elseif (Employee::where('user_id', $user->id)->exists()) {
                return redirect()->route('employee.dashboard');
            } else {
                return redirect()->route('family.dashboard');
            }
        }

        // If login fails, send them back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // --- 3. Handle Logout ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
    // --- 4. Handle Admin Registration ---
    public function registerAdmin(Request $request)
    {
        // 1. Validate the form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'security_key' => 'required|string'
        ]);

        // 2. Verify the Master Security Key
        $masterKey = config('services.admin.master_key'); 
        
        if ($request->security_key !== $masterKey) {
            return back()->withErrors(['security_key' => 'Invalid Master Security Key. Access Denied.']);
        }

        // 3. Create the User record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 4. Create the Admin profile
        Admin::create([
            'user_id' => $user->id
        ]);

        // 5. Log them in and redirect to the admin dashboard
        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }
}