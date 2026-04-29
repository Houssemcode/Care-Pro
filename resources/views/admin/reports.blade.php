<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Reports & Disputes | Admin Panel</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>

    <style type="text/tailwindcss">
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }

        /* ─── Sidebar ─── */
        .sidebar {
            @apply w-[270px] bg-slate-900 flex flex-col fixed h-[100dvh] z-50 text-slate-300 transition-transform duration-300;
        }
        @media (max-width: 1023px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); box-shadow: 20px 0 60px rgba(0,0,0,0.6); }
        }

        .nav-item {
            @apply flex items-center gap-3 px-4 py-3 mx-3 mb-1 rounded-xl font-semibold text-sm transition-all duration-200 cursor-pointer hover:bg-white/5 hover:text-white border border-transparent;
        }
        .nav-item.active {
            @apply bg-brand-500/10 text-brand-400 border-brand-500/20 shadow-sm;
        }
        .nav-item .nav-badge {
            @apply ml-auto text-[10px] font-bold bg-white/10 text-slate-400 px-2 py-0.5 rounded-md;
        }
        .nav-item.active .nav-badge {
            @apply bg-brand-500/20 text-brand-400;
        }

        /* ─── Data Table ─── */
        .data-table { @apply w-full text-left border-collapse min-w-[700px]; }
        .data-table th {
            @apply bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap;
        }
        .data-table td {
            @apply py-3.5 px-5 border-b border-slate-50 text-sm font-medium text-slate-700 bg-white transition-colors;
        }
        .data-table tbody tr:hover td { @apply bg-slate-50/60; }

        /* ─── Buttons ─── */
        .btn-reject { @apply px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95; }
        .btn-resolve { @apply px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95; }

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

    <!-- Mobile Nav Overlay -->
    <div id="mobile-overlay"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden opacity-0 invisible transition-all duration-300"
        onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- ════════════ SIDEBAR ════════════ -->
        <aside id="sidebar" class="sidebar">
            <div class="p-5 border-b border-white/5 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-display font-bold tracking-tight text-xl text-white">Admin Hub</span>
                </a>
                <button class="lg:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition"
                    onclick="toggleSidebar()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 py-5 overflow-y-auto custom-scrollbar">
                <p class="px-6 mb-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main</p>
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span>Users Directory</span>
                </a>
                <a href="{{ route('admin.requests') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span>Manage Requests</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item active">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Reports/Disputes</span>
                    <span class="nav-badge">1</span>
                </a>

                <p class="px-6 mt-6 mb-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Account</p>
                <a href="{{ route('admin.profile') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>My Profile</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/5 space-y-3">
                <a href="{{ route('admin.profile') }}"
                    class="flex items-center gap-3 p-2 rounded-xl hover:bg-white/5 transition group">
                    <div
                        class="w-9 h-9 rounded-lg bg-brand-500/20 text-brand-400 flex items-center justify-center font-bold text-xs">
                        AD</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">Super Admin</p>
                        <p class="text-[11px] text-slate-500 truncate">admin@careservices.com</p>
                    </div>
                </a>
                <div class="mt-auto px-4 pb-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition-all font-bold text-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ════════════ MAIN CONTENT ════════════ -->
        <main class="flex-1 lg:ml-[270px] w-full p-4 sm:p-6 lg:p-10 xl:p-12 max-w-full overflow-x-hidden">

            <!-- Mobile Top Bar -->
            <div
                class="lg:hidden flex items-center justify-between bg-white px-5 py-4 rounded-2xl shadow-sm border border-slate-100 mb-6">
                <button onclick="toggleSidebar()"
                    class="p-2 -ml-2 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <span class="font-display font-bold text-slate-800">Active Reports</span>
                <a href="{{ route('admin.profile') }}"
                    class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                    AD</a>
            </div>

            <!-- Page Header -->
            <header
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Reports</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Active
                        Reports</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Review disputes initiated by families
                        against caregivers.</p>
                </div>
                <div
                    class="hidden lg:flex items-center gap-3 bg-white p-2 pr-5 rounded-full shadow-sm border border-slate-100">
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center gap-2 hover:bg-slate-50 p-1 pr-3 rounded-full transition cursor-pointer">
                        <div
                            class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                            AD</div>
                        <span class="font-bold text-slate-800 text-sm">Super Admin</span>
                    </a>
                    <a href="{{ route('admin.settings') }}"
                        class="text-slate-400 hover:text-slate-700 transition p-1.5 rounded-lg hover:bg-slate-100"
                        title="Settings">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Reports Table -->
            <div
                class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
                <div
                    class="bg-gradient-to-r from-rose-50/50 to-white px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
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
                                <th class="text-right">Admin Interventions</th>
                            </tr>
                        </thead>
                        <tbody id="reports-table-body">
                            @foreach ($reports as $report)
                            <tr>
                                <td>
                                    <span class="font-bold">#RPT-{{ $report->id }}</span><br>
                                    <span class="text-slate-400 text-[10px]">Date</span>
                                </td>
                                <td>Family ID: {{ $report->family_id }}</td>
                                <td>Employee ID: {{ $report->employee_id }}</td>
                                <td class="max-w-[200px]">
                                    <span class="font-bold text-rose-600/90 text-xs">{{ $report->rapport_reason }}</span>
                                    <p class="text-xs text-slate-500 truncate"
                                        title="{{ $report->comentaire }}">{{ $report->comentaire }}</p>
                                </td>
                                <td class="text-right space-x-1">
                                    <button class="btn-action text-xs px-2 py-1" onclick="viewReportDetails('#RPT-{{ $report->id }}')">View Details</button>
                                    <button class="btn-resolve" onclick="openResolveModal('#RPT-{{ $report->id }}')">Mark
                                        Resolved</button>
                                    <button class="btn-reject" onclick="openConfirm('ban', 'Employee ID: {{ $report->employee_id }}')">Ban
                                        Employee</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                        <p class="text-sm font-bold text-slate-800">Family Doe</p>
                    </div>
                    <div class="p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Reported (Caregiver)</h4>
                        <p class="text-sm font-bold text-slate-800">Sarah Jenkins</p>
                    </div>
                </div>
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl shadow-sm">
                    <h4 class="text-[10px] font-bold text-rose-500 uppercase tracking-wider mb-2">Complaint Reason</h4>
                    <p class="text-sm font-bold text-rose-900 mb-2">No Show</p>
                    <p class="text-xs text-rose-700/80 leading-relaxed">Caregiver did not show up at agreed time, and stopped answering phone calls. We were forced to cancel our plans. This is unacceptable behavior.</p>
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
            <div class="modal-header">
                <h3 class="font-display font-bold text-lg text-slate-800">Mark Report Resolved</h3>
                <button onclick="closeModal('modal-resolve')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="modal-body space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Resolution Note/Decision</label>
                    <textarea rows="4" placeholder="Enter findings or resolution details..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm"></textarea>
                    <p class="text-[10px] text-slate-500 mt-2 font-medium">This note will be saved in the system logs for future reference.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal('modal-resolve')" class="btn-action">Cancel</button>
                <button onclick="confirmResolve()" class="btn-action text-emerald-600 border-emerald-200 bg-emerald-50 hover:bg-emerald-100">Submit Resolution</button>
            </div>
        </div>
    </div>

    <!-- Confirm Action Modal -->
    <div id="modal-confirm" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-confirm')">
        <div class="modal-content max-w-sm">
            <div class="px-6 py-6 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-rose-100 text-rose-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="font-display font-bold text-xl text-slate-800 mb-2" id="confirm-title">Confirm Action</h3>
                <p class="text-sm text-slate-500" id="confirm-message">Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer justify-center bg-transparent border-t-0 pt-0">
                <button onclick="closeModal('modal-confirm')" class="btn-action w-full">Cancel</button>
                <button class="btn-action w-full text-white bg-rose-500 border-rose-500 hover:bg-rose-600" id="confirm-btn">Confirm</button>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Logic
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            sidebar.classList.toggle('mobile-open');
            if (sidebar.classList.contains('mobile-open')) {
                overlay.classList.remove('invisible', 'opacity-0');
            } else {
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('invisible'), 300);
            }
        }

        // Modals Logic
        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

        function viewReportDetails(reportId) {
            document.getElementById('detail-id').textContent = reportId;
            openModal('modal-details');
        }

        function openResolveModal(reportId) {
            openModal('modal-resolve');
        }

        function confirmResolve() {
            closeModal('modal-resolve');
            alert('Report Marked as Resolved successfully.');
        }

        function openConfirm(action, name) {
            document.getElementById('confirm-title').textContent = 'Suspend Employee';
            document.getElementById('confirm-message').textContent = `Are you sure you want to ban ${name} from the platform? This action is serious and logs will be generated.`;
            
            const btn = document.getElementById('confirm-btn');
            btn.textContent = 'Yes, Ban Employee';
            btn.onclick = () => {
                closeModal('modal-confirm');
                alert(`${name} has been banned.`);
            };
            openModal('modal-confirm');
        }
    </script>
</body>

</html>