<x-layouts.admin active="profile" title="Admin Profile">
    @section('title', 'Admin Profile')

    <x-admin.page-header 
        breadcrumb="Account" 
        title="Admin Profile" 
        subtitle="Manage your personal admin account." 
    />

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
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Families</span>
                        <span class="text-lg font-display font-black text-slate-900">{{ $totalFamilies }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Caregivers</span>
                        <span class="text-lg font-display font-black text-slate-900">{{ $totalEmployees }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Active Offers</span>
                        <span class="text-lg font-display font-black text-slate-900">{{ $totalOffres }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Bookings</span>
                        <span class="text-lg font-display font-black text-slate-900">{{ $totalRequests }}</span>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-brand-50 text-brand-600 font-bold text-xs hover:bg-brand-600 hover:text-white transition-all group">
                        Back to Dashboard
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Specific profile logic can go here
    </script>
    @endpush
</x-layouts.admin>