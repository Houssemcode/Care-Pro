<?php

namespace App\Http\Controllers;

use App\Models\Request as BookingRequest;
use App\Models\AssignmentService;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    // ==========================================
    // OVERVIEW DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $employeeId = Auth::user()->employee->id;

        // 1. Calculate Quick Stats
        $pendingCount = BookingRequest::whereHas('offre', fn($q) => $q->where('employee_id', $employeeId))
            ->where('status', 'pending')
            ->count();

        $activeContractsCount = BookingRequest::whereHas('offre', fn($q) => $q->where('employee_id', $employeeId))
            ->where('status', 'assigned')
            ->count();

        $activeOffersCount = Offre::where('employee_id', $employeeId)->count();

        // Calculate total earnings from Assignment Services
        $totalEarnings = AssignmentService::whereHas('offre', fn($q) => $q->where('employee_id', $employeeId))
            ->sum('price');

        // 2. Fetch Recent Upcoming Assignments
        $recentAssignments = BookingRequest::with(['family.user', 'offre'])
            ->whereHas('offre', fn($q) => $q->where('employee_id', $employeeId))
            ->where('status', 'assigned')
            ->latest()
            ->take(5)
            ->get();

        return view('employee.dashboard', compact(
            'pendingCount', 'activeContractsCount', 'activeOffersCount', 'totalEarnings', 'recentAssignments'
        ));
    }

    // ==========================================
    // MANAGE REQUESTS
    // ==========================================
    public function requests(Request $request)
    {
        $employeeId = Auth::user()->employee->id;
        
        $search = $request->input('search');
        $status = $request->input('status', 'pending'); // Default to pending

        $query = BookingRequest::with(['family.user', 'offre', 'messages.user'])
            ->whereHas('offre', function ($q) use ($employeeId) {
                $q->where('employee_id', $employeeId);
            });

        // Apply Live Search
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('id', 'like', "%{$search}%")
                    ->orWhereHas('family.user', function ($f) use ($search) {
                        $f->where('name', 'like', "%{$search}%");
                    });
            });
        });

        // Apply Status Filter
        if (!empty($status)) {
            $query->where('status', $status);
        }

        $requests = $query->latest()->paginate(10)->withQueryString();

        return view('employee.requests', compact('requests'));
    }

    // Accept a Request
    // ==========================================
    // ACCEPT A BOOKING REQUEST
    // ==========================================
    public function acceptRequest(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        $employeeId = Auth::user()->employee->id;

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $id, $employeeId) {
            // Use lockForUpdate to prevent other requests from modifying this booking simultaneously
            $bookingRequest = \App\Models\Request::where('id', $id)
                ->whereHas('offre', function($q) use ($employeeId) {
                    $q->where('employee_id', $employeeId);
                })
                ->lockForUpdate()
                ->firstOrFail();

            if ($bookingRequest->status !== 'pending') {
                return back()->withErrors('This request is no longer pending.');
            }

            // Check for overlapping active assignments for this employee
            $hasOverlap = \App\Models\AssignmentService::whereHas('offre', function($q) use ($employeeId) {
                    $q->where('employee_id', $employeeId);
                })
                ->where('status', 'active')
                ->where(function ($query) use ($bookingRequest) {
                    $query->where(function ($q) use ($bookingRequest) {
                        $q->where('start_date', '<=', $bookingRequest->end_date)
                          ->where('end_date', '>=', $bookingRequest->start_date);
                    });
                })
                ->exists();

            if ($hasOverlap) {
                return back()->withErrors('This employee is already booked for some or all of these dates.');
            }

            $bookingRequest->update(['status' => 'assigned']);

            \App\Models\AssignmentService::create([
                'family_id' => $bookingRequest->family_id,
                'offre_id' => $bookingRequest->offre_id,
                'price' => $request->price,
                'assigned_at' => now(),
                'start_date' => $bookingRequest->start_date,
                'end_date' => $bookingRequest->end_date,
                'status' => 'active'
            ]);

            return back()->with('success', 'You have accepted the request and set the price at ' . $request->price . ' DA.');
        });
    }

    // Reject a Request
    public function rejectRequest($id)
    {
        $employeeId = Auth::user()->employee->id;

        $request = BookingRequest::whereHas('offre', function ($q) use ($employeeId) {
            $q->where('employee_id', $employeeId);
        })->findOrFail($id);

        $request->update(['status' => 'rejected']);

        return back()->with('success', 'Request declined.');
    }
    // ==========================================
    // OFFERS MANAGEMENT
    // ==========================================
    public function createOffre()
    {
        return view('employee.offres.create');
    }

    // ==========================================
    // STORE A NEW OFFER
    // ==========================================
    public function storeOffre(Request $request)
    {
        $request->validate([
            'wilaya' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            // Strict ENUM validation:
            'service_type' => 'required|in:"Child Care","Elderly Care"',
            // Boolean validation (accepts true, false, 1, 0, "1", and "0"):
            'working_house' => 'required|boolean',
        ]);

        \App\Models\Offre::create([
            'employee_id' => Auth::user()->employee->id,
            'wilaya' => $request->wilaya,
            'commune' => $request->commune,
            'service_type' => $request->service_type,
            'working_house' => $request->working_house,
        ]);

        return redirect()->route('employee.offers')->with('success', 'Your caregiving offer has been published!');
    }
    
    public function offers()
    {
        $employeeId = Auth::user()->employee->id;
        
        $offers = Offre::where('employee_id', $employeeId)
            ->latest()
            ->get();

        return view('employee.offers', compact('offers'));
    }
    public function reports()
    {
        $employeeId = Auth::user()->employee->id;
        
        // Fetch reports linked to this employee, loading the family relation
        $reports = \App\Models\Report::with('family.user')
            ->where('employee_id', $employeeId)
            ->latest()
            ->paginate(10);

        return view('employee.reports', compact('reports'));
    }
    public function profile()
    {
        $employee = Auth::user()->employee;
        
        // Calculate stats
        $activeOffers = \App\Models\Offre::where('employee_id', $employee->id)->count();
        $assignedJobs = \App\Models\Request::whereHas('offre', function($q) use ($employee) {
            $q->where('employee_id', $employee->id);
        })->where('status', 'assigned')->count();

        return view('employee.profile', compact('employee', 'activeOffers', 'assignedJobs'));
    }
    // ==========================================
    // UPLOAD VERIFICATION DOCUMENTS
    // ==========================================
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|in:id_card,certificate',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $employee = Auth::user()->employee;

        // Store the file in the storage/app/public/documents folder
        $path = $request->file('file')->store('documents', 'public');

        // Save the record to the database
        \App\Models\EmployeeDocument::create([
            'employee_id' => $employee->id,
            'document_type' => $request->document_type,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Document uploaded successfully. Awaiting Admin review.');
    }

    public function editOffre($id)
    {
        $offre = Offre::where('id', $id)
            ->where('employee_id', Auth::user()->employee->id)
            ->firstOrFail();

        // Check if it has active assignments
        $isActive = \App\Models\Request::where('offre_id', $id)->where('status', 'assigned')->exists();
        if ($isActive) {
            return back()->withErrors('You cannot edit an offer that has active assignments.');
        }

        return view('employee.offres.edit', compact('offre'));
    }

    public function updateOffre(Request $request, $id)
    {
        $request->validate([
            'wilaya' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            'service_type' => 'required|in:"Child Care","Elderly Care"',
            'working_house' => 'required|boolean',
        ]);

        $offre = Offre::where('id', $id)
            ->where('employee_id', Auth::user()->employee->id)
            ->firstOrFail();

        $isActive = \App\Models\Request::where('offre_id', $id)->where('status', 'assigned')->exists();
        if ($isActive) {
            return back()->withErrors('You cannot edit an offer that has active assignments.');
        }

        $offre->update([
            'wilaya' => $request->wilaya,
            'commune' => $request->commune,
            'service_type' => $request->service_type,
            'working_house' => $request->working_house,
        ]);

        return redirect()->route('employee.offers')->with('success', 'Offer updated successfully.');
    }

    // ==========================================
    // VIEW FAMILY PROFILE
    // ==========================================
    public function familyProfile($id)
    {
        $family = \App\Models\Family::with(['user.localization'])->findOrFail($id);

        // Get the booking history between this employee and this family
        $employeeId = Auth::user()->employee->id;
        $bookingHistory = \App\Models\AssignmentService::where('family_id', $family->id)
            ->whereHas('offre', function ($q) use ($employeeId) {
                $q->where('employee_id', $employeeId);
            })
            ->with('offre')
            ->latest()
            ->get();

        // Count stats for this family's interactions with the current employee
        $totalBookings = $bookingHistory->count();
        $activeBookings = $bookingHistory->where('status', 'active')->count();

        return view('employee.family_profile', compact('family', 'bookingHistory', 'totalBookings', 'activeBookings'));
    }
}