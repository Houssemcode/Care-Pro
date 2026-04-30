<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'Family Dashboard')
    <x-family.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    {{-- You will need to create this navbar component next! --}}
    <x-family.navbar active="dashboard" />

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">

        {{-- Page Header --}}
        <div class="flex flex-col lg:flex-row justify-between lg:items-end gap-4 sm:gap-6 mb-8 lg:pr-8">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Overview</p>
                <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">Welcome, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
                <p class="text-sm sm:text-base text-slate-500 font-medium">Manage your caregiving requests and active contracts.</p>
            </div>
        </div>

        {{-- Quick Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <!-- Active Contracts -->
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center mb-4 relative z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-slate-500 font-semibold text-xs uppercase tracking-wider mb-1 relative z-10">Active Caregivers</p>
                <h3 class="text-3xl font-display font-extrabold text-slate-900 relative z-10">{{ $activeContractsCount }}</h3>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-4 relative z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-slate-500 font-semibold text-xs uppercase tracking-wider mb-1 relative z-10">Pending Approvals</p>
                <h3 class="text-3xl font-display font-extrabold text-slate-900 relative z-10">{{ $pendingCount }}</h3>
            </div>

            <!-- Total Spent -->
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 relative z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-slate-500 font-semibold text-xs uppercase tracking-wider mb-1 relative z-10">Total Spent</p>
                <div class="flex items-baseline gap-2 relative z-10">
                    <h3 class="text-3xl font-display font-extrabold text-slate-900">{{ number_format($totalSpent, 0) }}</h3>
                    <span class="text-sm font-bold text-emerald-600">DA</span>
                </div>
            </div>
        </div>

        {{-- Main Dashboard Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            
            {{-- Left Column: Recent Requests --}}
            <div class="lg:col-span-2 flex flex-col">
                <div class="bg-white rounded-2xl sm:rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex-1">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-display font-bold text-lg text-slate-900">Recent Bookings</h3>
                        <a href="{{ route('family.requests') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition">View All →</a>
                    </div>
                    
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="bg-slate-50 py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Caregiver</th>
                                    <th class="bg-slate-50 py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Service</th>
                                    <th class="bg-slate-50 py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentRequests as $req)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-6 border-b border-slate-50">
                                            <div class="font-bold text-sm text-slate-800">{{ $req->offre->employee->user->name ?? 'Unknown Caregiver' }}</div>
                                        </td>
                                        <td class="py-4 px-6 border-b border-slate-50">
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-slate-600 bg-slate-100 rounded-lg ring-1 ring-inset ring-slate-500/10">
                                                {{ $req->offre->service_type ?? 'Service' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 border-b border-slate-50 text-right">
                                            @if($req->status === 'pending')
                                                <span class="inline-flex px-2 py-1 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-md">Pending</span>
                                            @elseif($req->status === 'assigned')
                                                <span class="inline-flex px-2 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-md">Assigned</span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-[10px] font-bold text-rose-700 bg-rose-50 rounded-md">Declined</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-10 text-center text-slate-400 text-sm font-medium">
                                            You haven't made any booking requests yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column: Action Banner --}}
            <div class="flex flex-col gap-6">
                <!-- Find a Caregiver CTA -->
                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-[2rem] p-6 text-white shadow-lg shadow-indigo-500/20 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/20 rounded-xl backdrop-blur flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-display font-bold mb-2">Find a Caregiver</h3>
                        <p class="text-white/80 text-sm mb-6 leading-relaxed">Browse available offers from verified professionals in your area.</p>
                        <a href="{{ route('family.browse') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-white text-indigo-700 font-bold rounded-xl text-sm transition-transform hover:scale-[1.02] active:scale-95 shadow-sm">
                            Browse Offers
                        </a>
                    </div>
                </div>

                <!-- Post a Request CTA -->
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-brand-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Can't find a match?</h3>
                        <p class="text-slate-500 text-sm mb-6 leading-relaxed">Post a specific request and let qualified caregivers come to you.</p>
                        <button id="open-request-modal" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">
                            Post a Request
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>