<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Users Directory | Admin Panel</title>

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
        .data-table { @apply w-full text-left border-collapse min-w-[900px]; }
        .data-table th {
            @apply bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap z-10;
        }
        .data-table td {
            @apply py-3.5 px-5 border-b border-slate-50 text-sm font-medium text-slate-700 bg-white transition-colors;
        }
        .data-table tbody tr:hover td { @apply bg-slate-50/60; }

        /* ─── Badges ─── */
        .badge {
            @apply inline-flex px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg ring-1 ring-inset items-center gap-1.5 whitespace-nowrap;
        }
        .badge-active { @apply bg-emerald-50 text-emerald-700 ring-emerald-500/20; }
        .badge-pending { @apply bg-amber-50 text-amber-700 ring-amber-500/20; }
        .badge-suspended { @apply bg-rose-50 text-rose-700 ring-rose-500/20; }

        .role-badge { @apply inline-flex px-2 py-0.5 text-[10px] font-bold rounded ring-1 ring-inset; }
        .role-family { @apply bg-indigo-50 text-indigo-700 ring-indigo-500/20; }
        .role-employee { @apply bg-cyan-50 text-cyan-700 ring-cyan-500/20; }

        /* ─── Buttons ─── */
        .btn-action { @apply px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-600 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95 flex items-center justify-center; }

        /* ─── Scrollbar ─── */
        .custom-scrollbar::-webkit-scrollbar { height: 5px; width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }

        /* ─── Modals ─── */
        .modal-overlay { @apply fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4; }
        .modal-overlay.open { @apply opacity-100 visible; }
        .modal-content { @apply bg-white rounded-2xl shadow-xl w-full max-w-lg transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col; }
        .modal-overlay.open .modal-content { @apply scale-100 opacity-100; }
        .modal-header { @apply px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0; }
        .modal-body { @apply px-6 py-5 overflow-y-auto custom-scrollbar; }
        .modal-footer { @apply px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-3 bg-slate-50 rounded-b-2xl shrink-0; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-[100dvh]">

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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
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
                <a href="{{ route('admin.users') }}" class="nav-item active">
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
        <main
            class="flex-1 lg:ml-[270px] w-full p-4 sm:p-6 lg:p-10 xl:p-12 max-w-full overflow-x-hidden border-l border-slate-200">

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
                <span class="font-display font-bold text-slate-800">Users Directory</span>
                <a href="{{ route('admin.profile') }}"
                    class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</a>
            </div>

            <!-- Page Header -->
            <header
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Directory</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">All Users
                    </h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Consult and manage all registered accounts.</p>
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
                </div>
            </header>

            <!-- Filters Section -->
            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-5 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2 relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search by name, email, or ID..."
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <!-- Role Dropdown -->
                    <div>
                        <select
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                            <option value="">All Roles</option>
                            <option value="family">Family (Client)</option>
                            <option value="employee">Employee (Caregiver)</option>
                        </select>
                    </div>

                    <!-- Status Dropdown -->
                    <div>
                        <select
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div
                class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col w-full">
                <div class="overflow-x-auto custom-scrollbar flex-1 w-full relative min-h-[500px]">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="w-16">Acc ID</th>
                                <th>User Information</th>
                                <th>Role & Location</th>
                                <th>Joined</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    // Determine Role
                                    $roleName = 'Family';
                                    $roleClass = 'role-family';
                                    $location = 'Pending Update'; // Assuming this gets added to profiles later

                                    if ($user->admin) {
                                        $roleName = 'Admin';
                                        $roleClass = 'bg-slate-100 text-slate-700 ring-slate-500/20'; // Gray badge
                                    } elseif ($user->employee) {
                                        $roleName = 'Employee';
                                        $roleClass = 'role-employee';
                                    } elseif ($user->family) {
                                        $location = $user->family->address ?? 'Pending Update';
                                    }
                                @endphp

                                <tr>
                                    <td>
                                        <span class="font-bold text-slate-500">#U-{{ $user->id }}</span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                                <div class="text-[11px] text-slate-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="role-badge {{ $roleClass }} mb-1">{{ $roleName }}</span>
                                        <div class="text-[11px] text-slate-500 font-medium">{{ $location }}</div>
                                    </td>
                                    <td class="text-sm font-medium text-slate-600">
                                        <!-- Formats the created_at timestamp to "Jan 01, 2026" -->
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <span class="badge badge-active">🟢 Active</span>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button class="btn-action" title="View Profile"
                                                onclick="viewProfile('{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ strtoupper(substr($user->name, 0, 2)) }}', '{{ $roleName }}', false)">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button
                                                class="btn-action text-rose-500 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50"
                                                title="Suspend User" onclick="openConfirm('suspend', '{{ addslashes($user->name) }}')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="py-4 px-6 border-t border-slate-100 bg-slate-50">
                        {{ $users->links() }}
                    </div>
                </div>

                <!-- Pagination Mockup -->
                <div class="py-4 px-6 border-t border-slate-100 flex items-center justify-between bg-slate-50">
                    <span class="text-xs font-semibold text-slate-500">Showing 1-4 of 27 users</span>
                    <div class="flex gap-1">
                        <button
                            class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-400 shadow-sm disabled cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            class="w-8 h-8 rounded-lg border-brand-500 bg-brand-500 text-white font-bold text-xs shadow-sm shadow-brand-500/20">1</button>
                        <button
                            class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-bold text-xs shadow-sm">2</button>
                        <button
                            class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-bold text-xs shadow-sm">3</button>
                        <button
                            class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-slate-600 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- ════════════ MODALS ════════════ -->
    <!-- View Profile / Review Modal -->
    <div id="modal-profile" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-profile')">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="font-display font-bold text-lg text-slate-800" id="profile-modal-title">User Profile</h3>
                <button onclick="closeModal('modal-profile')"
                    class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>
            <div class="modal-body">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-xl"
                        id="profile-avatar">SD</div>
                    <div>
                        <h4 class="font-bold text-xl text-slate-900" id="profile-name">Sarah Doe</h4>
                        <p class="text-sm text-slate-500" id="profile-email">sarah.doe@example.com</p>
                        <span class="role-badge role-employee mt-2" id="profile-role">Employee</span>
                    </div>
                </div>
                <!-- Details -->
                <div class="space-y-4">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Verification
                            Documents</h5>
                        <div class="flex items-center justify-between py-2 border-b border-slate-100">
                            <span class="text-sm font-medium text-slate-600">ID Card</span>
                            <span class="badge badge-active">Verified</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-slate-100" id="doc-nursing"
                            style="display: none;">
                            <span class="text-sm font-medium text-slate-600">Nursing Certificate</span>
                            <span class="badge badge-pending">Pending Review</span>
                            <button class="ml-2 btn-action py-1 px-2 text-[10px]">View</button>
                        </div>
                        <div class="flex items-center justify-between py-2" id="doc-criminal" style="display: none;">
                            <span class="text-sm font-medium text-slate-600">Criminal Record</span>
                            <span class="badge badge-active">Verified</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs font-bold text-slate-400 mb-1">Phone</p>
                            <p class="text-sm font-semibold text-slate-700">+213 555 123 456</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs font-bold text-slate-400 mb-1">Location</p>
                            <p class="text-sm font-semibold text-slate-700">Algiers, Algeria</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal('modal-profile')" class="btn-action">Close</button>
                <button class="btn-action text-brand-600 border-brand-200 bg-brand-50 hover:bg-brand-100"
                    id="profile-action-btn" onclick="approveEmployee()">Approve Employee</button>
            </div>
        </div>
    </div>

    <!-- Logs Modal -->
    <div id="modal-logs" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-logs')">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="font-display font-bold text-lg text-slate-800">Activity Logs</h3>
                <button onclick="closeModal('modal-logs')" class="text-slate-400 hover:text-slate-600 transition"><svg
                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>
            <div class="modal-body">
                <div
                    class="space-y-4 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    <div
                        class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 text-slate-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-100 bg-white shadow-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-slate-800 text-sm">Account Suspended</span>
                                <span class="font-medium text-[10px] text-slate-400">Jan 15, 2024</span>
                            </div>
                            <div class="text-xs text-slate-500">Suspended by Super Admin due to platform guideline
                                violations.</div>
                        </div>
                    </div>
                    <div
                        class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 text-slate-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-100 bg-white shadow-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-slate-800 text-sm">Account Created</span>
                                <span class="font-medium text-[10px] text-slate-400">Jan 02, 2024</span>
                            </div>
                            <div class="text-xs text-slate-500">Registered as an Employee.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal('modal-logs')" class="btn-action">Close</button>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div id="modal-confirm" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-confirm')">
        <div class="modal-content max-w-sm">
            <div class="px-6 py-6 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" id="confirm-icon-bg">
                    <svg class="w-8 h-8" id="confirm-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
                </div>
                <h3 class="font-display font-bold text-xl text-slate-800 mb-2" id="confirm-title">Confirm Action</h3>
                <p class="text-sm text-slate-500" id="confirm-message">Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer justify-center bg-transparent border-t-0 pt-0">
                <button onclick="closeModal('modal-confirm')" class="btn-action w-full">Cancel</button>
                <button class="btn-action w-full text-white" id="confirm-btn">Confirm</button>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle

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
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        function viewProfile(name, email, initials, role, isEmployeePending) {
            document.getElementById('profile-name').textContent = name;
            document.getElementById('profile-email').textContent = email;
            document.getElementById('profile-avatar').textContent = initials;

            const roleBadge = document.getElementById('profile-role');
            roleBadge.textContent = role;
            roleBadge.className = `role-badge mt-2 ${role === 'Employee' ? 'role-employee' : 'role-family'}`;

            // Show employee specific docs
            if (role === 'Employee') {
                document.getElementById('doc-nursing').style.display = 'flex';
                document.getElementById('doc-criminal').style.display = 'flex';
            } else {
                document.getElementById('doc-nursing').style.display = 'none';
                document.getElementById('doc-criminal').style.display = 'none';
            }

            const actionBtn = document.getElementById('profile-action-btn');
            if (isEmployeePending) {
                actionBtn.style.display = 'block';
                actionBtn.textContent = 'Approve Employee';
            } else {
                actionBtn.style.display = 'none';
            }

            openModal('modal-profile');
        }

        function approveEmployee() {
            closeModal('modal-profile');
            // Toast logic could go here
            alert("Employee Approved Successfully!");
        }

        function openConfirm(type, name) {
            document.getElementById('confirm-title').textContent = type === 'suspend' ? 'Suspend User' : 'Restore User';
            document.getElementById('confirm-message').textContent = type === 'suspend' ? `Are you sure you want to suspend ${name}? They will lose access to the platform.` : `Are you sure you want to restore ${name}? They will regain access to the platform.`;

            const btn = document.getElementById('confirm-btn');
            const iconBg = document.getElementById('confirm-icon-bg');
            const icon = document.getElementById('confirm-icon');

            if (type === 'suspend') {
                btn.className = 'btn-action w-full text-white bg-rose-500 border-rose-500 shadow-rose-500/20 hover:bg-rose-600';
                btn.textContent = 'Yes, Suspend';
                iconBg.className = 'w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-rose-100 text-rose-500';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
            } else {
                btn.className = 'btn-action w-full text-white bg-emerald-500 border-emerald-500 shadow-emerald-500/20 hover:bg-emerald-600';
                btn.textContent = 'Yes, Restore';
                iconBg.className = 'w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-emerald-100 text-emerald-500';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            }

            btn.onclick = () => {
                closeModal('modal-confirm');
                alert(type === 'suspend' ? 'User Suspended' : 'User Restored');
            };

            openModal('modal-confirm');
        }
    </script>
</body>

</html>