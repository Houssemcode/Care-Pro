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

        $query = BookingRequest::with(['family.user', 'offre'])
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
    public function acceptRequest($id)
    {
        $employeeId = Auth::user()->employee->id;

        $request = BookingRequest::whereHas('offre', function ($q) use ($employeeId) {
            $q->where('employee_id', $employeeId);
        })->findOrFail($id);

        // Change status from pending to assigned
        $request->update(['status' => 'assigned']);

        return back()->with('success', 'You have accepted the care request!');
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

    public function storeOffre(Request $request)
    {
        // 1. Validate the incoming form data
        $request->validate([
            'service_type' => 'required|string|max:255',
            'working_house' => 'required|string|max:255', // e.g., "Live-in" or "Live-out"
            'address_service' => 'required|string|max:255', // Target working areas
            'address' => 'required|string|max:255', // Caregiver's base address
        ]);

        // 2. Create the new Offer linked to the authenticated employee
        Offre::create([
            'employee_id' => Auth::user()->employee->id,
            'service_type' => $request->service_type,
            'working_house' => $request->working_house,
            'address_service' => $request->address_service,
            'address' => $request->address,
        ]);

        // 3. Redirect back to the dashboard with a success message
        return redirect()->route('employee.dashboard')
            ->with('success', 'Your new care service offer has been published successfully!');
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
}