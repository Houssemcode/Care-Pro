<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Panel | Care Services Management</title>

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

        /* ─── Badges ─── */
        .status-badge {
            @apply inline-flex px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg ring-1 ring-inset items-center gap-1.5 whitespace-nowrap;
        }
        .status-pending { @apply bg-amber-50 text-amber-700 ring-amber-500/20; }
        .status-approved { @apply bg-emerald-50 text-emerald-700 ring-emerald-500/20; }
        .status-rejected { @apply bg-rose-50 text-rose-700 ring-rose-500/20; }

        /* ─── Buttons ─── */
        .btn-approve { @apply px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95; }
        .btn-reject { @apply px-3 py-1.5 bg-white hover:bg-rose-50 border border-slate-200 hover:border-rose-200 text-rose-600 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95; }

        /* ─── Report Cards ─── */
        .report-card {
            @apply p-4 border-b border-slate-100 hover:bg-slate-50/80 transition-colors flex flex-col gap-1.5 cursor-pointer;
        }

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

        /* ─── Stat Cards ─── */
        .stat-card {
            @apply bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-shadow;
        }
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
            <!-- Logo -->
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-5 overflow-y-auto custom-scrollbar">
                <p class="px-6 mb-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main</p>
                <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                    <span class="nav-badge" id="sidebar-pending">0</span>
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
                <a href="{{ route('admin.reports') }}" class="nav-item">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Reports/Disputes</span>
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

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-white/5 space-y-3">
                <a href="{{ route('admin.profile') }}"
                    class="flex items-center gap-3 p-2 rounded-xl hover:bg-white/5 transition group">
                    <div
                        class="w-9 h-9 rounded-lg bg-brand-500/20 text-brand-400 flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
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
                <span class="font-display font-bold text-slate-800">System Oversight</span>
                <a href="{{ route('admin.profile') }}"
                    class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</a>
            </div>

            <!-- Page Header -->
            <header
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Dashboard</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">System
                        Oversight</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Platform administration and moderation.</p>
                </div>
                <div
                    class="hidden lg:flex items-center gap-3 bg-white p-2 pr-5 rounded-full shadow-sm border border-slate-100">
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center gap-2 hover:bg-slate-50 p-1 pr-3 rounded-full transition cursor-pointer">
                        <div
                            class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <span class="font-bold text-slate-800 text-sm">{{ Auth::user()->name }}</span>
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

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900" id="stat-pending">{{ $pendingCount }}</p>
                        <p class="text-xs font-semibold text-slate-400">Pending</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900">{{ $approvedCount }}</p>
                        <p class="text-xs font-semibold text-slate-400">Approved</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900">{{ $reportsCount }}</p>
                        <p class="text-xs font-semibold text-slate-400">Reports</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900">{{ $totalUsers }}</p>
                        <p class="text-xs font-semibold text-slate-400">Total Users</p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                <!-- Verification Table -->
                <section class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
                    <div class="bg-gradient-to-r from-slate-50 to-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-display font-bold text-slate-900">Pending Verifications</h3>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">Approve new caregiver accounts.</p>
                        </div>
                        <span class="bg-amber-100/50 text-amber-700 px-3 py-1.5 rounded-lg text-[11px] font-bold ring-1 ring-amber-500/20">
                            {{ $pendingCount }} Pending
                        </span>
                    </div>
                    <div class="overflow-x-auto custom-scrollbar flex-1 w-full">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Credentials</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingEmployees as $employee)
                                    <tr>
                                        <td><span class="font-bold text-slate-500">#{{ $employee->id }}</span></td>
                                        <td><span class="font-bold text-slate-900">{{ $employee->user->name }}</span></td>
                                        <td>{{ $employee->diploma ?? 'Awaiting Upload' }}</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <!-- Action buttons trigger the JS modal with real data -->
                                                <button class="btn-approve" onclick="openReviewModal({{ $employee->id }}, '{{ addslashes($employee->user->name) }}', '{{ addslashes($employee->diploma ?? 'Awaiting Upload') }}')">Approve</button>
                                                <button class="btn-reject">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-slate-500 font-medium">No pending verifications at this time.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Reports Section -->
                <section class="xl:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col h-[400px] sm:h-[500px] xl:h-auto">
                    <div class="bg-gradient-to-r from-rose-50/50 to-white px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-display font-bold text-slate-900">Active Reports</h3>
                            <p class="text-[11px] font-medium text-slate-500 mt-0.5">Platform disputes and alerts.</p>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-2 custom-scrollbar">
                        @forelse ($activeReports as $report)
                            <div class="report-card">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-bold text-slate-900">{{ $report->report_reason }}</span>
                                    <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded uppercase tracking-wider">High</span>
                                </div>
                                
                                <!-- This replaces the hardcoded names -->
                                <p class="text-xs font-semibold text-slate-600">
                                    {{ $report->employee->user->name ?? 'Unknown Employee' }} ↔ {{ $report->family->user->name ?? 'Unknown Family' }}
                                </p>
                                
                                <p class="text-xs text-slate-500 italic mt-1 pb-2">"{{ $report->description }}"</p>
                                
                                <button class="mt-auto self-end px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95" onclick="openResolveConfirm({{ $report->id }})">
                                    Resolve Issue
                                </button>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-500 font-medium text-sm">No active reports.</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- ════════════ MODALS ════════════ -->
    <!-- Review Employee Modal -->
    <div id="modal-review" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-review')">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 class="font-display font-bold text-lg text-slate-800">Review Caregiver</h3>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5" id="review-emp-name">Employee Name</p>
                </div>
                <button onclick="closeModal('modal-review')" class="text-slate-400 hover:text-slate-600 transition"><svg
                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>
            <div class="modal-body space-y-4">
                <div class="p-4 bg-white border border-slate-100 rounded-xl shadow-sm text-center">
                    <div class="w-16 h-16 rounded-full bg-brand-100 text-brand-600 text-xl font-bold flex items-center justify-center mx-auto mb-3"
                        id="review-avatar">EN</div>
                    <h4 class="font-bold text-slate-800 text-lg" id="review-name">Employee Name</h4>
                    <p class="text-xs text-slate-500" id="review-creds">Credentials</p>
                </div>
                <!-- Docs -->
                <div class="space-y-3">
                    <div
                        class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <span class="text-sm font-bold text-slate-600">ID Verification</span>
                        <a href="#" class="text-xs font-bold text-brand-600 hover:underline">View PDF</a>
                    </div>
                    <div
                        class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <span class="text-sm font-bold text-slate-600">Certificates</span>
                        <a href="#" class="text-xs font-bold text-brand-600 hover:underline">View PDF</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-reject mr-auto" onclick="rejectEmployeeFromModal()">Reject</button>
                <button onclick="closeModal('modal-review')" class="btn-action">Cancel</button>
                <button onclick="approveEmployeeFromModal()" class="btn-approve px-6">Approve</button>
            </div>
            <!-- Hidden inputs tracking current ID -->
            <input type="hidden" id="review-emp-id">
        </div>
    </div>

    <!-- Confirm Report Resolve -->
    <div id="modal-confirm-resolve" class="modal-overlay"
        onclick="if(event.target===this) closeModal('modal-confirm-resolve')">
        <div class="modal-content max-w-sm">
            <div class="px-6 py-6 text-center flex flex-col items-center">
                <div
                    class="w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-emerald-100 text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-display font-bold text-xl text-slate-800 mb-2">Resolve Dispute</h3>
                <p class="text-sm text-slate-500">Are you sure this issue is resolved and should be closed?</p>
            </div>
            <div class="modal-footer justify-center bg-transparent border-t-0 pt-0">
                <button onclick="closeModal('modal-confirm-resolve')" class="btn-action w-full">Cancel</button>
                <button class="btn-action w-full text-white bg-emerald-500 border-emerald-500 hover:bg-emerald-600"
                    onclick="confirmResolveAction()">Mark Resolved</button>
            </div>
            <form id="resolve-report-form" method="POST" class="hidden">
                @csrf
                @method('PATCH')
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/modules/admin.js') }}"></script>
    <script>
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

        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

        // Triggered from admin.js
        window.openReviewModal = function (id, name, creds) {
            document.getElementById('review-emp-id').value = id;
            document.getElementById('review-emp-name').textContent = name;
            document.getElementById('review-name').textContent = name;
            document.getElementById('review-avatar').textContent = name.split(' ').map(n => n[0]).join('').substring(0, 2);
            document.getElementById('review-creds').textContent = creds;
            openModal('modal-review');
        };

        window.approveEmployeeFromModal = function () {
            const id = parseInt(document.getElementById('review-emp-id').value);
            if (window.updateStatus) window.updateStatus(id, 'approved');
            closeModal('modal-review');
        };

        window.rejectEmployeeFromModal = function () {
            const id = parseInt(document.getElementById('review-emp-id').value);
            if (window.updateStatus) window.updateStatus(id, 'rejected');
            closeModal('modal-review');
        };

        window.openResolveConfirm = function (id) {
            document.getElementById('resolve-report-id').value = id;
            openModal('modal-confirm-resolve');
        };

        window.confirmResolveAction = function () {
            const id = document.getElementById('resolve-report-id').value;
            const form = document.getElementById('resolve-report-form');
            
            // Dynamically set the action URL using the ID
            form.action = `/admin/reports/${id}/resolve`;
            
            // Submit the form
            form.submit();
        };
    </script>
</body>

</html>