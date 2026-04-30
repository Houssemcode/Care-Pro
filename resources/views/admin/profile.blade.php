<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'Admin Profile')
    <x-admin.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-[100dvh]">

    <x-admin.navbar active="profile" />

    <div class="flex min-h-screen">
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
                <span class="font-display font-bold text-slate-800">Admin Profile</span>
                <a href="{{ route('admin.profile') }}"
                    class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</a>
            </div>

            <!-- Page Header -->
            <header
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Account</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Admin
                        Profile</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Manage your personal admin account.</p>
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

            <!-- Profile Card -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                {{-- Main Profile Info --}}
                <div class="xl:col-span-2 space-y-8">
                    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                        <div class="p-8 border-b border-slate-100 flex flex-col sm:flex-row items-center gap-6 bg-slate-50/50">
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 text-white flex items-center justify-center font-bold text-2xl shadow-xl shadow-slate-900/20 flex-shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="text-center sm:text-left">
                                <h2 class="text-2xl font-display font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                                <p class="text-sm font-semibold text-brand-600 mt-1">Super Administrator</p>
                                <p class="text-xs text-slate-400 mt-2 font-medium italic">Managed via System Core</p>
                            </div>
                        </div>

                        {{-- Notifications --}}
                        <div class="px-8 pt-6">
                            @if (session('success'))
                                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-3">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-medium flex items-center gap-3">
                                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $errors->first() }}
                                </div>
                            @endif
                        </div>

                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Full Name</p>
                                    <p class="text-base font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Email Address</p>
                                    <p class="text-base font-bold text-slate-800">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Phone Number</p>
                                    <p class="text-base font-bold text-slate-800">{{ Auth::user()->phone ?? 'Not provided' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Member Since</p>
                                    <p class="text-base font-bold text-slate-800">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-slate-50 flex justify-between items-center">
                                <a href="{{ route('admin.settings') }}"
                                    class="py-3 px-8 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-sm shadow-xl shadow-slate-900/20 active:scale-95 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- System Statistics Sidebar --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 p-6">
                        <h3 class="font-display font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Platform Overview
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Families</span>
                                <span class="text-lg font-display font-black text-slate-900">{{ $totalFamilies }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Caregivers</span>
                                <span class="text-lg font-display font-black text-slate-900">{{ $totalEmployees }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Offers</span>
                                <span class="text-lg font-display font-black text-slate-900">{{ $totalOffres }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Bookings</span>
                                <span class="text-lg font-display font-black text-slate-900">{{ $totalRequests }}</span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-brand-50 text-brand-600 font-bold text-xs hover:bg-brand-600 hover:text-white transition-all group">
                                Back to Control Panel
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    </div>
</body>

</html>