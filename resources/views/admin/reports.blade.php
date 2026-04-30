<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Reports & Disputes | Admin Panel</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>

    <style type="text/tailwindcss">
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }

        /* ─── Sidebar ─── */
        .sidebar { @apply w-[270px] bg-slate-900 flex flex-col fixed h-[100dvh] z-50 text-slate-300 transition-transform duration-300; }
        @media (max-width: 1023px) { .sidebar { transform: translateX(-100%); } .sidebar.mobile-open { transform: translateX(0); box-shadow: 20px 0 60px rgba(0,0,0,0.6); } }

        .nav-item { @apply flex items-center gap-3 px-4 py-3 mx-3 mb-1 rounded-xl font-semibold text-sm transition-all duration-200 cursor-pointer hover:bg-white/5 hover:text-white border border-transparent; }
        .nav-item.active { @apply bg-brand-500/10 text-brand-400 border-brand-500/20 shadow-sm; }
        .nav-item .nav-badge { @apply ml-auto text-[10px] font-bold bg-white/10 text-slate-400 px-2 py-0.5 rounded-md; }
        .nav-item.active .nav-badge { @apply bg-brand-500/20 text-brand-400; }

        /* ─── Data Table ─── */
        .data-table { @apply w-full text-left border-collapse min-w-[900px]; }
        .data-table th { @apply bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap; }
        .data-table td { @apply py-3.5 px-5 border-b border-slate-50 text-sm font-medium text-slate-700 bg-white transition-colors; }
        .data-table tbody tr:hover td { @apply bg-slate-50/60; }

        /* ─── Buttons ─── */
        .btn-action { @apply px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95; }
        .btn-reject { @apply px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95 border border-rose-100; }
        .btn-resolve { @apply px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95 border border-brand-100; }

        /* ─── Badges ─── */
        .badge { @apply inline-block px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg ring-1 ring-inset; }
        .badge-pending { @apply bg-amber-50 text-amber-700 ring-amber-500/20; }
        .badge-active { @apply bg-emerald-50 text-emerald-700 ring-emerald-500/20; }

        /* ─── Scrollbar ─── */
        .custom-scrollbar::-webkit-scrollbar { height: 5px; width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }

        /* ─── Modals ─── */
        .modal-overlay { @apply fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4; }
        .modal-overlay.open { @apply opacity-100 visible; }
        .modal-content { @apply bg-white rounded-2xl shadow-xl w-full max-w-lg transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col overflow-hidden; }
        .modal-overlay.open .modal-content { @apply scale-100 opacity-100; }
        .modal-header { @apply px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-white; }
        .modal-body { @apply px-6 py-5 overflow-y-auto custom-scrollbar bg-slate-50; }
        .modal-footer { @apply px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-3 bg-white shrink-0; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-[100dvh]">

    <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden opacity-0 invisible transition-all duration-300" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">
        <!-- ════════════ SIDEBAR ════════════ -->
        <aside id="sidebar" class="sidebar">
            <div class="p-5 border-b border-white/5 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <span class="font-display font-bold tracking-tight text-xl text-white">Admin Hub</span>
                </a>
            </div>

            <nav class="flex-1 py-5 overflow-y-auto custom-scrollbar">
                <p class="px-6 mb-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main</p>
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Users Directory</span>
                </a>
                <a href="{{ route('admin.requests') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>Manage Requests</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item active">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Reports/Disputes</span>
                    <span class="nav-badge">{{ $activeReportsCount ?? 0 }}</span>
                </a>
            </nav>
        </aside>

        <!-- ════════════ MAIN CONTENT ════════════ -->
        <main class="flex-1 lg:ml-[270px] w-full p-4 sm:p-6 lg:p-10 xl:p-12 max-w-full overflow-x-hidden border-l border-slate-200">
            <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Reports</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">System Reports</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Review disputes initiated by families against caregivers.</p>
                </div>
            </header>

            <!-- Filters Section -->
            <form action="{{ route('admin.reports') }}" method="GET" id="filter-form" class="mb-6">
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID, Family, or Caregiver..."
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                        </div>

                        <!-- Status Dropdown -->
                        <div>
                            <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active (Unresolved)</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Reports Table -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
                <div class="bg-gradient-to-r from-rose-50/50 to-white px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-display font-bold text-slate-900">Submitted Reports</h3>
                </div>

                <div class="overflow-x-auto custom-scrollbar flex-1 w-full relative min-h-[300px]">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID & Date</th>
                                <th>Family (Reporter)</th>
                                <th>Caregiver (Reported)</th>
                                <th>Reason & Details</th>
                                <th>Status</th>
                                <th class="text-right">Admin Interventions</th>
                            </tr>
                        </thead>
                        <tbody id="reports-table-body">
                            @forelse ($reports as $report)
                            <tr>
                                <td>
                                    <span class="font-bold">#RPT-{{ $report->id }}</span><br>
                                    <span class="text-slate-400 text-[10px]">{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="font-bold text-slate-800">{{ $report->family->user->name ?? 'Unknown Family' }}</span><br>
                                    <span class="text-slate-500 text-[10px]">ID: {{ $report->family_id }}</span>
                                </td>
                                <td>
                                    <span class="font-bold text-slate-800">{{ $report->employee->user->name ?? 'Unknown Caregiver' }}</span><br>
                                    <span class="text-slate-500 text-[10px]">ID: {{ $report->employee_id }}</span>
                                </td>
                                <td class="max-w-[200px]">
                                    <span class="font-bold text-rose-600/90 text-xs">{{ $report->rapport_reason ?? $report->report_reason ?? 'Dispute' }}</span>
                                    <p class="text-xs text-slate-500 truncate" title="{{ $report->description ?? $report->description }}">{{ $report->description ?? $report->description }}</p>
                                </td>
                                <td>
                                    @if($report->status === 'active')
                                        <span class="badge badge-pending">Active</span>
                                    @else
                                        <span class="badge badge-active">Resolved</span>
                                    @endif
                                </td>
                                <td class="text-right space-x-1">
                                    <button class="btn-action text-xs px-2 py-1" 
                                        onclick="viewReportDetails(
                                            '{{ $report->id }}',
                                            '{{ addslashes($report->family->user->name ?? 'Unknown Family') }}',
                                            '{{ addslashes($report->employee->user->name ?? 'Unknown Caregiver') }}',
                                            '{{ addslashes($report->rapport_reason ?? $report->report_reason ?? 'Dispute') }}',
                                            '{{ addslashes(str_replace(["\r", "\n"], ' ', $report->description ?? $report->description ?? '')) }}'
                                        )">
                                        View Details
                                    </button>
                                    
                                    @if($report->status === 'active')
                                        <button class="btn-resolve" onclick="openResolveModal('{{ $report->id }}')">Mark Resolved</button>
                                    @endif
                                    
                                    <!-- Ban uses Employee User ID -->
                                    <button class="btn-reject" onclick="openConfirm('ban', '{{ $report->employee->user->id ?? 0 }}', '{{ addslashes($report->employee->user->name ?? 'Caregiver') }}')">Ban Employee</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-slate-500 font-medium">No reports match your current filters.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($reports->hasPages())
                <div class="py-4 px-6 border-t border-slate-100 bg-slate-50">
                    {{ $reports->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- ════════════ MODALS ════════════ -->
    <!-- View Report Modal -->
    <div id="modal-details" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-details')">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 class="font-display font-bold text-lg text-slate-800">Report Details</h3>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5" id="detail-id">#RPT-001</p>
                </div>
                <button onclick="closeModal('modal-details')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="modal-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Reporter (Family)</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-family">Family Doe</p>
                    </div>
                    <div class="p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Reported (Caregiver)</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-caregiver">Sarah Jenkins</p>
                    </div>
                </div>
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl shadow-sm">
                    <h4 class="text-[10px] font-bold text-rose-500 uppercase tracking-wider mb-2">Complaint Reason</h4>
                    <p class="text-sm font-bold text-rose-900 mb-2" id="detail-reason">No Show</p>
                    <p class="text-xs text-rose-700/80 leading-relaxed" id="detail-comment">Caregiver did not show up...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal('modal-details')" class="btn-action">Close</button>
            </div>
        </div>
    </div>

    <!-- Resolve Modal -->
    <div id="modal-resolve" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-resolve')">
        <div class="modal-content">
            <form id="form-resolve-report" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h3 class="font-display font-bold text-lg text-slate-800">Mark Report Resolved</h3>
                    <button type="button" onclick="closeModal('modal-resolve')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="modal-body space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Resolution Note/Decision (Optional)</label>
                        <textarea name="admin_note" rows="4" placeholder="Enter findings or resolution details..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm"></textarea>
                        <p class="text-[10px] text-slate-500 mt-2 font-medium">This resolves the ticket and clears it from the active queue.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-resolve')" class="btn-action">Cancel</button>
                    <button type="submit" class="btn-action text-emerald-600 border-emerald-200 bg-emerald-50 hover:bg-emerald-100">Submit Resolution</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Ban Modal -->
    <div id="modal-confirm" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-confirm')">
        <div class="modal-content max-w-sm">
            <form id="form-ban-employee" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="px-6 py-6 text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-rose-100 text-rose-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-800 mb-2" id="confirm-title">Suspend Employee</h3>
                    <p class="text-sm text-slate-500" id="confirm-message">Are you sure you want to ban this employee? They will lose access to the platform.</p>
                </div>
                <div class="modal-footer justify-center bg-transparent border-t-0 pt-0">
                    <button type="button" onclick="closeModal('modal-confirm')" class="btn-action w-full">Cancel</button>
                    <button type="submit" class="btn-action w-full text-white bg-rose-500 border-rose-500 hover:bg-rose-600" id="confirm-btn">Yes, Ban Employee</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sidebar Logic
        function toggleSidebar() { document.getElementById('sidebar').classList.toggle('mobile-open'); }
        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

        // Populate Details Modal
        function viewReportDetails(reportId, family, caregiver, reason, comment) {
            document.getElementById('detail-id').textContent = `#RPT-${reportId}`;
            document.getElementById('detail-family').textContent = family;
            document.getElementById('detail-caregiver').textContent = caregiver;
            document.getElementById('detail-reason').textContent = reason;
            document.getElementById('detail-comment').textContent = comment || "No additional comments provided.";
            openModal('modal-details');
        }

        // Setup Resolve Modal Route
        function openResolveModal(reportId) {
            document.getElementById('form-resolve-report').action = `/admin/reports/${reportId}/resolve`;
            openModal('modal-resolve');
        }

        // Setup Ban Modal Route
        function openConfirm(action, employeeUserId, name) {
            document.getElementById('confirm-message').textContent = `Are you sure you want to ban ${name} from the platform? This action is serious and logs will be generated.`;
            
            // Reusing the toggle-status route we built for the Users Directory
            document.getElementById('form-ban-employee').action = `/admin/users/${employeeUserId}/toggle-status`;
            
            openModal('modal-confirm');
        }

        // Live Search Debounce Logic
        let searchTimer;
        const searchInput = document.querySelector('input[name="search"]');
        const filterForm = document.getElementById('filter-form');

        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    filterForm.submit();
                }, 500); // Waits half a second after the user stops typing
            });
        }
    </script>
</body>
</html>