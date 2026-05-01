<x-layouts.employee active="dashboard">
    @section('title', 'Caregiver Overview')

    {{-- Account Status Alert --}}
    @if(Auth::user()->employee->status === 'active')
        <x-employee.page-header 
            breadcrumb="Overview" 
            title="Welcome Back!" 
            subtitle="Here is what's happening with your care services today." 
        />

        {{-- Quick Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <x-employee.stat-card 
                label="Total Earnings" 
                value="{{ number_format($totalEarnings, 0) }}" 
                suffix="DA"
                color="emerald"
                icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            />

            <x-employee.stat-card 
                label="Active Contracts" 
                value="{{ $activeContractsCount }}" 
                color="brand"
                icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            />

            <x-employee.stat-card 
                label="Pending Requests" 
                value="{{ $pendingCount }}" 
                color="amber"
                icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            />

            <x-employee.stat-card 
                label="My Active Offers" 
                value="{{ $activeOffersCount }}" 
                color="indigo"
                icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>'
            />
        </div>

        {{-- Main Dashboard Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            {{-- Left Column: Active Assignments --}}
            <div class="lg:col-span-2 flex flex-col">
                <div class="bg-white rounded-2xl sm:rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex-1">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-display font-bold text-lg text-slate-900">Recent Assignments</h3>
                        <a href="{{ route('employee.requests', ['status' => 'assigned']) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition">View All →</a>
                    </div>
                    
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="bg-slate-50 py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Family</th>
                                    <th class="bg-slate-50 py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Service</th>
                                    <th class="bg-slate-50 py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Start Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentAssignments as $assignment)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-6 border-b border-slate-50">
                                            <a href="{{ route('employee.family.profile', $assignment->family->id) }}" class="group">
                                                <div class="font-bold text-sm text-slate-800 group-hover:text-brand-600 transition-colors flex items-center gap-1.5">
                                                    {{ $assignment->family->user->name ?? 'Unknown' }}
                                                    <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                </div>
                                            </a>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <div class="text-[11px] text-slate-500 truncate max-w-[150px]">{{ $assignment->family->user->localization->commune ?? '' }}{{ $assignment->family->user->localization->wilaya ? ', ' . $assignment->family->user->localization->wilaya : '' }}</div>
                                                @if($assignment->family->user->localization && $assignment->family->user->localization->latitude && $assignment->family->user->localization->logitude)
                                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $assignment->family->user->localization->latitude }},{{ $assignment->family->user->localization->logitude }}" target="_blank" rel="noopener"
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 bg-brand-50 text-brand-700 rounded-md text-[10px] font-bold hover:bg-brand-100 transition-colors ring-1 ring-inset ring-brand-500/20 whitespace-nowrap" title="Get directions">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        Navigate
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 border-b border-slate-50">
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20">
                                                {{ $assignment->offre->service_type ?? 'Care Service' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 border-b border-slate-50 text-right text-sm font-medium text-slate-600">
                                            {{ \Carbon\Carbon::parse($assignment->start_date)->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-10 text-center text-slate-400 text-sm font-medium">
                                            No active assignments right now.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column: Action Banner & Info --}}
            <div class="flex flex-col gap-6">
                <!-- Create Offer CTA -->
                <div class="bg-gradient-to-br from-brand-600 to-indigo-700 rounded-[2rem] p-6 text-white shadow-lg shadow-brand-500/20 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/20 rounded-xl backdrop-blur flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h3 class="text-xl font-display font-bold mb-2">Create New Offer</h3>
                        <p class="text-white/80 text-sm mb-6 leading-relaxed">Expand your reach by posting a new care service offer for families to find.</p>
                        <a href="{{ route('employee.offres.create') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-white text-brand-700 font-bold rounded-xl text-sm transition-transform hover:scale-[1.02] active:scale-95 shadow-sm">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- Needs Attention Alert (If Pending Requests exist) -->
                @if($pendingCount > 0)
                <div class="bg-amber-50 rounded-[2rem] border border-amber-100 p-6 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-amber-900 text-sm mb-1">Action Required</h4>
                        <p class="text-amber-700 text-xs mb-3 leading-relaxed">You have {{ $pendingCount }} care request(s) waiting for your approval. Please review them promptly.</p>
                        <a href="{{ route('employee.requests') }}" class="text-xs font-bold text-amber-700 hover:text-amber-900 underline underline-offset-2">Review Requests</a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @push('scripts')
        <script src="{{ asset('js/modules/employee.js') }}"></script>
        @endpush

    @else
        <div class="mb-8 p-6 rounded-[2rem] bg-amber-50 border border-amber-200 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-amber-800 font-display">Account Pending Approval</h3>
                <p class="text-sm text-amber-700 mt-1 leading-relaxed">Your account is currently under review by our administration team. You will not appear in search results or receive booking requests until your account is activated. This typically takes 24-48 hours.</p>
                <div class="mt-4">
                    <a href="{{ route('employee.profile') }}" class="text-sm font-bold text-amber-800 hover:underline">Check Profile Status →</a>
                </div>
            </div>
        </div>
    @endif
</x-layouts.employee>