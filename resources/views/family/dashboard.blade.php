<x-layouts.family active="dashboard">
    @section('title', 'Family Dashboard')

    <x-family.page-header 
        breadcrumb="Overview" 
        title="Welcome, {{ explode(' ', Auth::user()->name)[0] }}!" 
        subtitle="Manage your caregiving requests and active contracts." 
    />

    {{-- Quick Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
        <x-family.stat-card
            label="Active Caregivers"
            value="{{ $activeContractsCount }}"
            color="brand"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        />

        <x-family.stat-card
            label="Pending Approvals"
            value="{{ $pendingCount }}"
            color="amber"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        />

        <x-family.stat-card
            label="Total Spent"
            value="{{ number_format($totalSpent, 0) }}"
            suffix="DA"
            color="emerald"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        />
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
                    <table class="hidden sm:table w-full text-left border-collapse">
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
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-lg ring-1 ring-inset ring-amber-500/20 uppercase tracking-wider">Pending</span>
                                        @elseif($req->status === 'assigned')
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20 uppercase tracking-wider">Assigned</span>
                                        @else
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-rose-700 bg-rose-50 rounded-lg ring-1 ring-inset ring-rose-500/20 uppercase tracking-wider">Declined</span>
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

                    {{-- Mobile Card View --}}
                    <div class="sm:hidden space-y-3">
                        @forelse ($recentRequests as $req)
                            <div class="p-4 border-b border-slate-50 last:border-0 flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-sm text-slate-800">{{ $req->offre->employee->user->name ?? 'Unknown Caregiver' }}</div>
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-0.5 text-[10px] font-bold text-slate-600 bg-slate-100 rounded-md ring-1 ring-inset ring-slate-500/10">
                                            {{ $req->offre->service_type ?? 'Service' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($req->status === 'pending')
                                        <span class="inline-flex px-2 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-md ring-1 ring-inset ring-amber-500/20 uppercase tracking-wider">Pending</span>
                                    @elseif($req->status === 'assigned')
                                        <span class="inline-flex px-2 py-0.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-md ring-1 ring-inset ring-emerald-500/20 uppercase tracking-wider">Assigned</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 text-[10px] font-bold text-rose-700 bg-rose-50 rounded-md ring-1 ring-inset ring-rose-500/20 uppercase tracking-wider">Declined</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center text-slate-400 text-sm font-medium">
                                You haven't made any booking requests yet.
                            </div>
                        @endforelse
                    </div>
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
        </div>
    </div>
</x-layouts.family>