<?php

namespace App\Http\Controllers;

use App\Models\Request as BookingRequest;
use App\Models\AssignmentService;
use App\Models\Offre;
use App\Models\Report;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyController extends Controller
{
    // ==========================================
    // FAMILY DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $familyId = Auth::user()->family->id;

        // 1. Quick Stats
        $pendingCount = BookingRequest::where('family_id', $familyId)
            ->where('status', 'pending')
            ->count();

        $activeContractsCount = BookingRequest::where('family_id', $familyId)
            ->where('status', 'assigned')
            ->count();

        // Calculate total spent (Optional, but a nice touch)
        $totalSpent = AssignmentService::where('family_id', $familyId)->sum('price');

        // 2. Fetch Recent Requests/Bookings to show in the table
        $recentRequests = BookingRequest::with(['offre.employee.user'])
            ->where('family_id', $familyId)
            ->latest()
            ->take(5)
            ->get();

        return view('family.dashboard', compact(
            'pendingCount', 'activeContractsCount', 'totalSpent', 'recentRequests'
        ));
    }

    // ==========================================
    // BROWSE CAREGIVER OFFERS
    // ==========================================
    public function browse(Request $request)
    {
        $search = $request->input('search');
        $serviceType = $request->input('service_type');

        // 1. Get the available service types from the database
        $service_types = Offre::pluck('service_type')->unique()->toArray();

        // 2. Fetch offers, including the employee and user data
        $query = Offre::with(['employee.user']);

        // Security/Quality check: Only show offers from active employees!
        $query->whereHas('employee', function ($q) {
            $q->where('status', 'active');
        });

        // Apply Search (Search by caregiver name or service area)
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('address_service', 'like', "%{$search}%")
                    ->orWhereHas('employee.user', function ($userQ) use ($search) {
                        $userQ->where('name', 'like', "%{$search}%");
                    });
            });
        });

        // Apply Service Type Filter
        $query->when($serviceType, function ($q) use ($serviceType) {
            $q->where('service_type', $serviceType);
        });

        $offers = $query->latest()->paginate(12)->withQueryString();

        // 3. Pass BOTH $offers and $service_types to the view!
        return view('family.browse', compact('offers', 'service_types'));
    }

    // ==========================================
    // SUBMIT A BOOKING REQUEST
    // ==========================================
    public function storeBooking(Request $request, $offre_id)
    {
        // 1. Validate dates
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $familyId = Auth::user()->family->id;

        // 2. Prevent duplicate pending requests for the exact same offer
        $existingRequest = BookingRequest::where('family_id', $familyId)
            ->where('offre_id', $offre_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->withErrors('You already have a pending request for this caregiver.');
        }

        // 3. Create the Booking Request
        BookingRequest::create([
            'family_id' => $familyId,
            'offre_id' => $offre_id,
            'status' => 'pending',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Booking request sent successfully! The caregiver will review it shortly.');
    }
    public function requests()
    {
        $familyId = Auth::user()->family->id;

        // Fetch requests and load the nested relationships needed for the view
        $requests = BookingRequest::with(['offre.employee.user'])
            ->where('family_id', $familyId)
            ->latest()
            ->paginate(10);

        return view('family.requests', compact('requests'));
    }

    // ==========================================
    // VIEW MY SUBMITTED REPORTS
    // ==========================================
    public function reports()
    {
        $familyId = Auth::user()->family->id;

        // Fetch reports with caregiver user info so we can display their name
        $reports = \App\Models\Report::with(['employee.user'])
            ->where('family_id', $familyId)
            ->latest()
            ->paginate(10);

        return view('family.reports', compact('reports'));
    }

    // ==========================================
    // SUBMIT A NEW REPORT (From Modal)
    // ==========================================
    public function storeReport(Request $request)
    {
        // 1. Single Validation Block
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'report_reason' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        // 2. Create the report using the exact column names from your database
        Report::create([
            'family_id' => Auth::user()->family->id,
            'employee_id' => $request->employee_id,
            'report_reason' => $request->report_reason, 
            'description' => $request->description,         
            'status' => 'active',
        ]);

        return back()->with('success', 'Your report has been submitted. Our administrators will review it and get back to you.');
    }
    public function profile()
    {
        $family = Auth::user()->family;
        
        // Calculate stats
        $totalRequests = \App\Models\Request::where('family_id', $family->id)->count();
        $activeContracts = \App\Models\Request::where('family_id', $family->id)->where('status', 'assigned')->count();

        return view('family.profile', compact('family', 'totalRequests', 'activeContracts'));
    }
    // ==========================================
    // SUBMIT A CAREGIVER REVIEW
    // ==========================================
    public function storeRating(Request $request)
    {
        $request->validate([
            'assignment_service_id' => 'required|exists:assignment_services,id',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Ensure the family actually owns this contract before rating!
        $contract = AssignmentService::where('id', $request->assignment_service_id)
            ->where('family_id', Auth::user()->family->id)
            ->firstOrFail();

        // Check if already rated to prevent duplicates
        if ($contract->rating) {
            return back()->withErrors('You have already reviewed this caregiver for this contract.');
        }

        Rating::create([
            'assignment_service_id' => $contract->id,
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        // Optional: Automatically mark the contract as completed once reviewed
        $contract->update(['status' => 'completed']);

        return back()->with('success', 'Thank you! Your review has been published.');
    }
}