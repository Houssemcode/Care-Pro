<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Offre;
use App\Models\Request as BookingRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // If user is already logged in, redirect to their dashboard
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isEmployee()) {
                return redirect()->route('employee.dashboard');
            } else {
                return redirect()->route('family.dashboard');
            }
        }

        $stats = [
            'verified_caregivers' => Employee::where('status', 'active')->count(),
            'families_joined' => \App\Models\Family::count(),
            'successful_bookings' => BookingRequest::where('status', 'assigned')->count(),
        ];

        // 2. Showcase top-rated caregivers
        $topCaregivers = Employee::with(['user', 'offres'])
            ->whereHas('offres')
            ->where('status', 'active')
            ->get()
            ->map(function ($employee) {
                $avgRating = Rating::whereHas('assignmentService.offre', function ($q) use ($employee) {
                    $q->where('employee_id', $employee->id);
                })->avg('stars') ?? 0;

                $employee->avg_rating = round($avgRating, 1);
                return $employee;
            })
            ->sortByDesc('avg_rating')
            ->take(3)
            ->values();

        return view('index', compact('stats', 'topCaregivers'));
    }
}
