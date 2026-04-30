<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Report;
use App\Models\Request as BookingRequest;
use App\Models\AssignmentService;

class AdminController extends Controller
{
    // ==========================================
    // USERS DIRECTORY
    // ==========================================
    public function users(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $status = $request->input('status');

        $query = User::whereDoesntHave('admin')->with(['family', 'employee']);

        // Apply Search Filter
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) { 
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        });

        // Apply Role Filter
        $query->when($role, function ($q) use ($role) {
            if ($role === 'family') $q->has('family');
            if ($role === 'employee') $q->has('employee');
        });

        // Apply Status Filter
        $query->when($status, function ($q) use ($status) {
            $q->where(function ($sub) use ($status) {
                // Filter Employees by their actual DB status
                $sub->whereHas('employee', function ($e) use ($status) {
                    $e->where('status', $status);
                });

                // Families are only shown if the filter is "active" 
                // (Since they don't have a status column, they are implicitly always active)
                if ($status === 'active') {
                    $sub->orHas('family');
                }
            });
        });

        $users = $query->latest()->paginate(10)->withQueryString();
        
        // Load pending employees WITH their uploaded documents
        $pendingEmployees = \App\Models\User::whereHas('employee', function($q) {
            $q->where('status', 'pending');
        })->with('employee.documents')->get();
        
        return view('admin.users', compact('users', 'pendingEmployees'));
    }

    // ==========================================
    // USER ACTIONS (Approve / Suspend)
    // ==========================================
    public function approveEmployee(User $user)
    {
        if ($user->employee && $user->employee->status === 'pending') {
            $user->employee->update(['status' => 'active']);
            return back()->with('success', 'Employee approved successfully.');
        }
        return back()->withErrors('Invalid request or user is not a pending employee.');
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->employee) {
            $newStatus = $user->employee->status === 'suspended' ? 'active' : 'suspended';
            $user->employee->update(['status' => $newStatus]);
            return back()->with('success', "User has been {$newStatus}.");
        }
        
        return back()->with('success', 'Action completed.');
    }

    // ==========================================
    // DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $totalUsers = User::whereDoesntHave('admin')->count();
        $pendingCount = Employee::where('status', 'pending')->count();
        $approvedCount = Employee::where('status', 'active')->count();
        $reportsCount = Report::where('status', 'active')->count();
        
        $pendingEmployees = Employee::with(['user', 'documents'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        $activeReports = Report::with(['employee.user', 'family.user'])
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'pendingCount', 'approvedCount', 'reportsCount', 
            'pendingEmployees', 'activeReports'
        ));
    }

    // ==========================================
    // MANAGE BOOKING REQUESTS
    // ==========================================
    public function requests(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = BookingRequest::with(['family.user', 'offre.employee.user']);

        // Apply Live Search (ID, Family Name, Caregiver Name)
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('id', 'like', "%{$search}%")
                    ->orWhereHas('family.user', function ($f) use ($search) {
                        $f->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('offre.employee.user', function ($e) use ($search) {
                        $e->where('name', 'like', "%{$search}%");
                    });
            });
        });

        // Apply Status Filter
        $query->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        });

        // Execute query & paginate
        $requests = $query->latest()->paginate(10)->withQueryString();
        $pendingRequestsCount = BookingRequest::where('status', 'pending')->count();

        return view('admin.requests', compact('requests', 'pendingRequestsCount'));
    }

    public function assignRequest(Request $request, $id)
    {
        $request->validate(['price' => 'required|numeric|min:0']);

        $booking = BookingRequest::findOrFail($id);
        
        // Create the official Assignment record
        AssignmentService::create([
            'family_id' => $booking->family_id,
            'offre_id' => $booking->offre_id,
            'assigned_at' => now(),
            'price' => $request->price
        ]);

        // Mark the request as assigned
        $booking->update(['status' => 'assigned']);

        return back()->with('success', 'Caregiver assigned and price set successfully.');
    }

    public function rejectRequest($id)
    {
        BookingRequest::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Request rejected.');
    }

    // ==========================================
    // MANAGE REPORTS PAGE
    // ==========================================
    public function reports(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Report::with(['family.user', 'employee.user']);

        // Apply Live Search (Search by Report ID, Family Name, or Caregiver Name)
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('id', 'like', "%{$search}%")
                    ->orWhereHas('family.user', function ($f) use ($search) {
                        $f->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('employee.user', function ($e) use ($search) {
                        $e->where('name', 'like', "%{$search}%");
                    });
            });
        });

        // Apply Status Filter
        $query->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        });

        // Execute query, paginate, and remember query strings
        $reports = $query->latest()->paginate(10)->withQueryString();

        // Count only active reports for the sidebar badge
        $activeReportsCount = Report::where('status', 'active')->count();

        return view('admin.reports', compact('reports', 'activeReportsCount'));
    }

    public function resolveReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $report->update([
            'status' => 'resolved',
            'admin_id' => auth()->user()->admin->id, // Logs which Admin resolved it
            // If you added an admin_note column to your DB, you can uncomment this:
            // 'admin_note' => $request->input('admin_note') 
        ]);

        return back()->with('success', 'Report marked as resolved successfully.');
    }

    // ==========================================
    // ADMIN PROFILE
    // ==========================================
    public function profile()
    {
        $admin = auth()->user();
        
        // System Stats for the Admin Profile
        $totalFamilies = \App\Models\Family::count();
        $totalEmployees = \App\Models\Employee::count();
        $totalOffres = \App\Models\Offre::count();
        $totalRequests = BookingRequest::count();

        return view('admin.profile', compact(
            'admin', 'totalFamilies', 'totalEmployees', 'totalOffres', 'totalRequests'
        ));
    }
}