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
        $wilaya = $request->input('wilaya');
        $workingHouse = $request->input('working_house');
        $nearby = $request->input('nearby');

        // 1. Get unique filter options from the database
        $service_types = Offre::pluck('service_type')->unique()->toArray();
        $wilayas = Offre::pluck('wilaya')->unique()->sort()->values()->toArray();

        // 2. Fetch offers, including the employee and user data
        $query = Offre::with(['employee.user.localization']);

        // Security/Quality check: Only show offers from active employees!
        $query->whereHas('employee', function ($q) {
            $q->where('status', 'active');
        });

        // Filter out offers that have an active assignment TODAY
        // This ensures families don't see caregivers who are currently working
        $today = now()->toDateString();
        $query->whereNotExists(function ($q) use ($today) {
            $q->selectRaw(1)
              ->from('assignment_services')
              ->whereColumn('assignment_services.offre_id', 'offres.id')
              ->where('status', 'active')
              ->where('start_date', '<=', $today)
              ->where('end_date', '>=', $today);
        });

        // Apply Text Search (caregiver name, commune, wilaya)
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('commune', 'like', "%{$search}%")
                    ->orWhere('wilaya', 'like', "%{$search}%")
                    ->orWhereHas('employee.user', function ($userQ) use ($search) {
                        $userQ->where('name', 'like', "%{$search}%");
                    });
            });
        });

        // Apply Service Type Filter
        $query->when($serviceType, function ($q) use ($serviceType) {
            $q->where('service_type', $serviceType);
        });

        // Apply Wilaya Filter
        $query->when($wilaya, function ($q) use ($wilaya) {
            $q->where('wilaya', $wilaya);
        });

        // Apply Working House Filter
        if ($workingHouse !== null && $workingHouse !== '') {
            $query->where('working_house', (bool) $workingHouse);
        }

        // Nearby — sort by distance using the family's saved coordinates
        $familyLoc = Auth::user()->localization;
        $isNearby = false;

        if ($nearby && $familyLoc && $familyLoc->latitude && $familyLoc->logitude) {
            $userLat = (float) $familyLoc->latitude;
            $userLng = (float) $familyLoc->logitude;
            $isNearby = true;

            $query->whereHas('employee.user.localization', function ($q) {
                $q->whereRaw('latitude != 0 AND logitude != 0');
            });

            $query->selectRaw("offres.*, (
                SELECT 6371 * acos(
                    cos(radians(?)) * cos(radians(l.latitude))
                    * cos(radians(l.logitude) - radians(?))
                    + sin(radians(?)) * sin(radians(l.latitude))
                )
                FROM localizations l
                JOIN users u ON u.id = l.user_id
                JOIN employees e ON e.user_id = u.id
                WHERE e.id = offres.employee_id
                LIMIT 1
            ) as distance", [$userLat, $userLng, $userLat])
            ->orderBy('distance', 'asc');
        } else {
            $query->latest();
        }

        $offers = $query->paginate(12)->withQueryString();

        return view('family.browse', compact('offers', 'service_types', 'wilayas', 'familyLoc', 'isNearby'));
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
        $requests = BookingRequest::with(['offre.employee.user', 'messages.user'])
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

    public function employeeProfile($id)
    {
        $employee = \App\Models\Employee::with(['user', 'offres'])->findOrFail($id);
        
        // Fetch all ratings for this employee across all their offers
        $ratings = Rating::whereHas('assignmentService.offre', function($q) use ($id) {
            $q->where('employee_id', $id);
        })->with('assignmentService.family.user')->latest()->get();

        $averageRating = $ratings->avg('stars');

        return view('family.employee_profile', compact('employee', 'ratings', 'averageRating'));
    }

    public function updateRequest(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $bookingRequest = BookingRequest::where('id', $id)
            ->where('family_id', Auth::user()->family->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $bookingRequest->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Request updated successfully.');
    }
}