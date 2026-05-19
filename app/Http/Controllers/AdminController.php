<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\Report;
use App\Models\Request as BookingRequest;
use App\Models\AssignmentService;
use Illuminate\Support\Facades\Storage;

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
                $sub->whereHas('employee', function ($e) use ($status) {
                    $e->where('status', $status);
                })->orWhereHas('family', function ($f) use ($status) {
                    $f->where('status', $status);
                });
            });
        });

        $users = $query->latest()->paginate(10)->withQueryString();
        
        // Load pending employees WITH their uploaded documents
        // Only show employees who have actually uploaded at least one document
        $pendingEmployees = \App\Models\User::whereHas('employee', function($q) {
            $q->where('status', 'pending');
        })->whereHas('employee.documents')->with('employee.documents')->get();
        
        return view('admin.users', compact('users', 'pendingEmployees'));
    }

    // ==========================================
    // USER ACTIONS (Approve / Suspend)
    // ==========================================
    public function approveEmployee(User $user)
    {
        if (!$user->employee || $user->employee->status !== 'pending') {
            return back()->withErrors('Invalid request or user is not a pending employee.');
        }

        $employee = $user->employee;

        // Check mandatory documents exist
        $hasIdCard = $employee->documents()->where('document_type', 'id_card')->exists();
        $hasCriminalRecord = $employee->documents()->where('document_type', 'criminal_record')->exists();

        if (!$hasIdCard || !$hasCriminalRecord) {
            return back()->withErrors('Cannot approve: mandatory documents (ID Card and Criminal Record) are missing.');
        }

        // Check minimum points threshold
        if ($employee->total_points < 12) {
            return back()->withErrors('Cannot approve: employee has ' . $employee->total_points . '/15 points. Minimum 12 points required.');
        }

        $employee->update(['status' => 'active']);
        return back()->with('success', 'Employee approved and activated successfully.');
    }

    /**
     * Update points for all documents of an employee and recalculate total.
     */
    public function updateAllDocumentPoints(Request $request, Employee $employee)
    {
        $maxPoints = [
            'certificate' => 5,
            'resume' => 5,
            'medical_certificate' => 2,
            'criminal_record' => 2,
            'id_card' => 1,
        ];

        // Retrieve points array, e.g. points[doc_id] = value
        $pointsData = $request->input('points', []);

        foreach ($employee->documents as $doc) {
            $val = $pointsData[$doc->id] ?? null;

            // Treat empty/null as 0 so it's not strictly required
            $val = ($val === '' || $val === null) ? 0 : (int)$val;

            $max = $maxPoints[$doc->document_type] ?? 0;
            if ($val > $max) $val = $max;
            if ($val < 0) $val = 0;

            $doc->update(['points' => $val]);
        }

        // Recalculate total points for the employee
        $totalPoints = $employee->documents()->sum('points');
        $employee->update(['total_points' => $totalPoints]);

        return back()->with('success', 'All document points updated. Total: ' . $totalPoints . '/15');
    }

    /**
     * Reject an employee: delete all uploaded documents and reset status.
     */
    public function rejectEmployee(User $user)
    {
        if (!$user->employee) {
            return back()->withErrors('Invalid request.');
        }

        $employee = $user->employee;

        // Delete all document files from storage
        foreach ($employee->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }

        // Delete all document records
        $employee->documents()->delete();

        // Reset total points
        $employee->update(['total_points' => 0]);

        return back()->with('success', 'Employee rejected. All uploaded documents have been deleted.');
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->employee) {
            $newStatus = $user->employee->status === 'suspended' ? 'active' : 'suspended';

            // Block reactivation if employee doesn't meet the 12-point minimum
            if ($newStatus !== 'pending' && $user->employee->total_points < 12) {
                return back()->withErrors('Cannot modify status: employee has ' . $user->employee->total_points . '/15 points. Minimum 12 points required.');
            }

            $user->employee->update(['status' => $newStatus]);
            return back()->with('success', "Caregiver has been {$newStatus}.");
        } elseif ($user->family) {
            $newStatus = $user->family->status === 'suspended' ? 'active' : 'suspended';
            $user->family->update(['status' => $newStatus]);
            return back()->with('success', "Family has been {$newStatus}.");
        }
        
        return back()->with('success', 'Action completed.');
    }

    // ==========================================
    // DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $totalUsers = User::whereDoesntHave('admin')->count();
        $pendingCount = Employee::where('status', 'pending')->has('documents')->count();
        $approvedCount = Employee::where('status', 'active')->count();
        $reportsCount = Report::where('status', 'active')->count();
        
        // Only show pending employees who have uploaded at least one document
        $pendingEmployees = Employee::with(['user', 'documents'])
            ->where('status', 'pending')
            ->has('documents')
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