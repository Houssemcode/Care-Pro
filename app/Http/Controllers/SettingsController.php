<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    // ==========================================
    // UPDATE PASSWORD
    // ==========================================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    // ==========================================
    // UPDATE PROFILE INFO
    // ==========================================
    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        // 1. Base Validation (For All Users)
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ];

        // 2. Role-Specific Validation
        if ($user->family) {
            $rules['wilaya'] = 'required|string|max:255';
            $rules['commune'] = 'required|string|max:255';
            $rules['latitude'] = 'required|numeric|between:-90,90';
            $rules['logitude'] = 'required|numeric|between:-180,180';
        } elseif ($user->employee) {
            $rules['experience'] = 'nullable|string|max:255';
            $rules['diploma'] = 'nullable|string|max:255';
            $rules['description'] = 'nullable|string|max:1000';
            $rules['wilaya'] = 'nullable|string|max:255';
            $rules['commune'] = 'nullable|string|max:255';
            $rules['latitude'] = 'nullable|numeric';
            $rules['logitude'] = 'nullable|numeric';
        }

        $request->validate($rules);

        // 3. Update the Main User Table
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // 4. Update the Associated Role Tables
        if ($user->family) {
            // Update localization
            $user->localization()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'wilaya' => $request->wilaya ?? '',
                    'commune' => $request->commune ?? '',
                    'latitude' => $request->latitude ?? 0,
                    'logitude' => $request->logitude ?? 0,
                ]
            );
        } elseif ($user->employee) {
            $user->employee->update([
                'experience' => $request->experience,
                'diploma' => $request->diploma,
                'description' => $request->description,
            ]);
            // Update localization
            $user->localization()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'wilaya' => $request->wilaya ?? '',
                    'commune' => $request->commune ?? '',
                    'latitude' => $request->latitude ?? 0,
                    'logitude' => $request->logitude ?? 0,
                ]
            );
        }

        return back()->with('success', 'Profile information updated successfully.');
    }
}