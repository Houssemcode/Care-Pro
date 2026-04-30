<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manage Requests | Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>

    <style type="text/tailwindcss">
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }
        .sidebar { @apply w-[270px] bg-slate-900 flex flex-col fixed h-[100dvh] z-50 text-slate-300 transition-transform duration-300; }
        @media (max-width: 1023px) { .sidebar { transform: translateX(-100%); } .sidebar.mobile-open { transform: translateX(0); box-shadow: 20px 0 60px rgba(0,0,0,0.6); } }
        .nav-item { @apply flex items-center gap-3 px-4 py-3 mx-3 mb-1 rounded-xl font-semibold text-sm transition-all duration-200 cursor-pointer hover:bg-white/5 hover:text-white border border-transparent; }
        .nav-item.active { @apply bg-brand-500/10 text-brand-400 border-brand-500/20 shadow-sm; }
        .nav-item .nav-badge { @apply ml-auto text-[10px] font-bold bg-white/10 text-slate-400 px-2 py-0.5 rounded-md; }
        .nav-item.active .nav-badge { @apply bg-brand-500/20 text-brand-400; }
        .data-table { @apply w-full text-left border-collapse min-w-[800px]; }
        .data-table th { @apply bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap; }
        .data-table td { @apply py-3.5 px-5 border-b border-slate-50 text-sm font-medium text-slate-700 bg-white transition-colors; }
        .data-table tbody tr:hover td { @apply bg-slate-50/60; }
        .badge { @apply inline-block px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg ring-1 ring-inset; }
        .badge-pending { @apply bg-amber-50 text-amber-700 ring-amber-500/20; }
        .badge-active { @apply bg-emerald-50 text-emerald-700 ring-emerald-500/20; }
        .badge-rejected { @apply bg-rose-50 text-rose-700 ring-rose-500/20; }
        .btn-action { @apply px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95; }
        .btn-approve { @apply px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95 border border-brand-100; }
        .custom-scrollbar::-webkit-scrollbar { height: 5px; width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
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
        <!-- SIDEBAR -->
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
                <a href="{{ route('admin.requests') }}" class="nav-item active">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>Manage Requests</span>
                    <span class="nav-badge">{{ $pendingRequestsCount }}</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Reports/Disputes</span>
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 lg:ml-[270px] w-full p-4 sm:p-6 lg:p-10 xl:p-12 max-w-full overflow-x-hidden border-l border-slate-200">
            <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Requests</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Booking Requests</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Monitor, approve, and finalize prices for bookings.</p>
                </div>
            </header>
            <!-- Filters Section -->
            <form action="{{ route('admin.requests') }}" method="GET" id="filter-form" class="mb-6">
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
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Requests Table -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
                <div class="overflow-x-auto custom-scrollbar flex-1 w-full relative min-h-[400px]">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Family</th>
                                <th>Requested Offre</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $req)
                                <tr>
                                    <td>
                                        <span class="font-bold">#REQ-{{ $req->id }}</span><br>
                                        <span class="text-slate-400 text-[10px]">Start: {{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</span>
                                    </td>
                                    <td>
                                        <div class="font-semibold">{{ $req->family->user->name ?? 'Unknown Family' }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $req->family->address ?? 'No Location Provided' }}</div>
                                    </td>
                                    <td>
                                        <div class="font-semibold text-brand-600">{{ $req->offre->service_type ?? 'Service Offre' }}</div>
                                        <div class="text-[10px] text-slate-500">Caregiver: {{ $req->offre->employee->user->name ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        @if($req->status === 'pending')
                                            <span class="badge badge-pending">Pending</span>
                                        @elseif($req->status === 'assigned')
                                            <span class="badge badge-active">Assigned</span>
                                        @else
                                            <span class="badge badge-rejected">{{ ucfirst($req->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right space-x-1">
                                        @if($req->status === 'pending')
                                            <button class="btn-approve" title="Approve & Set Price"
                                                onclick="openAssignModal(
                                                    {{ $req->id }}, 
                                                    '{{ addslashes($req->family->user->name ?? 'Family') }}',
                                                    '{{ addslashes($req->offre->employee->user->name ?? 'Caregiver') }}'
                                                )">
                                                Set Price
                                            </button>
                                        @endif
                                        <button class="btn-action" title="View Details"
                                            onclick="viewRequestDetails(
                                                '{{ $req->id }}', 
                                                '{{ addslashes($req->offre->service_type ?? 'Service') }}', 
                                                '{{ addslashes($req->offre->working_house ?? 'N/A') }}', 
                                                '{{ $req->status }}',
                                                '{{ $req->offre->employee->user->name ?? '' }}'
                                            )">
                                            Details
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-slate-500 font-medium">No booking requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($requests->hasPages())
                <div class="py-4 px-6 border-t border-slate-100 bg-slate-50">
                    {{ $requests->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- MODALS -->
    <!-- Assign Modal -->
    <div id="modal-assign" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-assign')">
        <div class="modal-content">
            <form id="form-assign-caregiver" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <div>
                        <h3 class="font-display font-bold text-lg text-slate-800">Finalize Assignment</h3>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5" id="assign-req-title">Request #XXXX</p>
                    </div>
                    <button type="button" onclick="closeModal('modal-assign')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="modal-body space-y-5">
                    <div class="bg-brand-50 border border-brand-100 p-4 rounded-xl">
                        <p class="text-xs text-brand-800 mb-1">Requested Caregiver:</p>
                        <p class="text-sm font-bold text-brand-900" id="assign-caregiver-name">Caregiver Name</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Set Final Price (DZD)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-brand-500 font-bold">DA</div>
                            <input type="number" name="price" required min="0" placeholder="Enter amount" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white outline-none transition-all placeholder:text-slate-400 font-bold text-slate-800">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-assign')" class="btn-action">Cancel</button>
                    <button type="submit" class="btn-approve py-2">Confirm & Assign</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Request Details Modal -->
    <div id="modal-details" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-details')">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="font-display font-bold text-lg text-slate-800">Request Information</h3>
                <button onclick="closeModal('modal-details')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="modal-body space-y-4">
                <div class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">ID</span>
                    <span class="font-bold text-brand-600" id="detail-req-id">#REQ-xxxx</span>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Service Type</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-req-service">Type</p>
                    </div>
                    <div class="p-4 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Working House</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-req-location">Location</p>
                    </div>
                </div>
                
                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm" id="detail-contract" style="display: none;">
                    <h4 class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-2">Active Contract</h4>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-medium text-emerald-800">Assigned To:</span>
                        <span class="text-xs font-bold text-emerald-900" id="detail-contract-emp">Employee Name</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="form-reject-request" method="POST" action="" class="mr-auto" onsubmit="return confirm('Are you sure you want to reject this request?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-action text-rose-500 hover:bg-rose-50 hover:border-rose-200" id="btn-reject-req">Reject Request</button>
                </form>
                <button onclick="closeModal('modal-details')" class="btn-action">Close</button>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() { document.getElementById('sidebar').classList.toggle('mobile-open'); }
        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

        function openAssignModal(reqId, familyName, caregiverName) {
            document.getElementById('assign-req-title').textContent = `Request #${reqId} - ${familyName}`;
            document.getElementById('assign-caregiver-name').textContent = caregiverName;
            document.getElementById('form-assign-caregiver').action = `/admin/requests/${reqId}/assign`;
            openModal('modal-assign');
        }

        function viewRequestDetails(reqId, service, location, status, employeeName) {
            document.getElementById('detail-req-id').textContent = `#REQ-${reqId}`;
            document.getElementById('detail-req-service').textContent = service;
            document.getElementById('detail-req-location').textContent = location;
            document.getElementById('form-reject-request').action = `/admin/requests/${reqId}/reject`;
            document.getElementById('btn-reject-req').style.display = (status === 'pending') ? 'block' : 'none';

            const contractPanel = document.getElementById('detail-contract');
            if (status === 'assigned') {
                contractPanel.style.display = 'block';
                document.getElementById('detail-contract-emp').textContent = employeeName;
            } else {
                contractPanel.style.display = 'none';
            }
            openModal('modal-details');
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