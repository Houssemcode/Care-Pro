<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Report;

class AdminController extends Controller
{
    public function users()
    {
        // Fetch all users with their associated roles, paginated to 10 per page
        $users = User::with(['family', 'employee', 'admin'])->paginate(10);
        
        return view('admin.users', compact('users'));
    }
    public function dashboard()
    {
        // 1. Calculate the Quick Stats
        $totalUsers = User::count();
        $pendingCount = Employee::where('status', 'pending')->count();
        $approvedCount = Employee::where('status', 'active')->count();
        $reportsCount = Report::where('status', 'active')->count();
        
        // 2. Fetch the pending employees for the verification table
        $pendingEmployees = Employee::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(10) // Show the 10 most recent
            ->get();

        // 3. Fetch active reports (Mocking this for now until you build the Report model)
        $activeReports = Report::with(['employee.user', 'family.user'])
            ->where('status', 'active')
            ->latest()
            ->get();

        // 4. Send it all to the view
        return view('admin.dashboard', compact(
            'totalUsers', 'pendingCount', 'approvedCount', 'reportsCount', 
            'pendingEmployees', 'activeReports'
        ));
    }
    public function resolveReport(Report $report)
    {
        $report->update([
            'status' => 'resolved',
            'admin_id' => auth()->user()->admin->id // Assign the current admin
        ]);

        return back()->with('success', 'Report resolved successfully.');
    }
}