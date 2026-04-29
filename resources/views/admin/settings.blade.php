<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Settings | Care Services Management</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ resource_path('js/tailwind-config.js') }}"></script>

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

        /* ─── Scrollbar ─── */
        .custom-scrollbar::-webkit-scrollbar { height: 5px; width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }

        /* ─── Toggle Switch ─── */
        .toggle-track {
            @apply relative w-11 h-6 bg-slate-200 rounded-full cursor-pointer transition-colors duration-200;
        }
        .toggle-track.on { @apply bg-emerald-500; }
        .toggle-knob {
            @apply absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200;
        }
        .toggle-track.on .toggle-knob { transform: translateX(20px); }

        /* ─── Toast Notification ─── */
        .toast {
            @apply fixed bottom-6 right-6 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-semibold z-[100] translate-y-20 opacity-0 transition-all duration-300;
        }
        .toast.show { @apply translate-y-0 opacity-100; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-[100dvh]">

    <!-- Mobile Nav Overlay -->
    <div id="mobile-overlay"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden opacity-0 invisible transition-all duration-300"
        onclick="toggleSidebar()"></div>

    <!-- Toast -->
    <div id="toast" class="toast">
        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span id="toast-msg">Saved!</span>
    </div>

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
                <a href="{{ route('admin.settings') }}" class="nav-item active">
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
                <a href="{{ route('admin.logout') }}"
                    class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition-all font-bold text-sm active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </a>
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
                <span class="font-display font-bold text-slate-800">System Settings</span>
                <a href="{{ route('admin.profile') }}"
                    class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                    AD</a>
            </div>

            <!-- Page Header -->
            <header
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Account</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">System
                        Settings</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Configure platform behavior & security.</p>
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
                </div>
            </header>

            <!-- Settings Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-5xl">

                <!-- Change Password -->
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-bold text-slate-900">Change Password</h3>
                    </div>
                    <form class="space-y-4" onsubmit="event.preventDefault(); showToast('Password updated!')">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Current Password</label>
                            <input type="password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">New Password</label>
                            <input type="password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Confirm New Password</label>
                            <input type="password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm">
                        </div>
                        <button type="submit"
                            class="mt-2 py-3 px-6 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-sm shadow-md active:scale-95 transition-all">
                            Update Password
                        </button>
                    </form>
                </div>

                <!-- Notifications -->
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-bold text-slate-900">Notifications</h3>
                    </div>

                    <div class="space-y-5">
                        <div
                            class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition -mx-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Email Alerts</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Receive emails for new disputes/reports.</p>
                            </div>
                            <div class="toggle-track on" onclick="this.classList.toggle('on')">
                                <div class="toggle-knob"></div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition -mx-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">New Caregiver Approvals</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Ping when verification is required.</p>
                            </div>
                            <div class="toggle-track on" onclick="this.classList.toggle('on')">
                                <div class="toggle-knob"></div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition -mx-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Booking Updates</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Alerts when requests change status.</p>
                            </div>
                            <div class="toggle-track" onclick="this.classList.toggle('on')">
                                <div class="toggle-knob"></div>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-slate-100">
                            <button type="button"
                                class="w-full py-3 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-800 rounded-xl font-bold text-sm shadow-sm active:scale-95 transition-all"
                                onclick="showToast('Preferences saved!')">
                                Save Preferences
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

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

        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-msg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }
    </script>
</body>

</html>