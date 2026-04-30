<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'My Active Offers')
    <x-employee.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-employee.navbar :active="'offers'" />

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        {{-- Account Status Alert --}}
        @if(Auth::user()->employee->status === 'active')
            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row justify-between lg:items-end mb-8 sm:mb-10 gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">My Active Offers</h1>
                    <p class="text-sm sm:text-base text-slate-500 font-medium">Manage and track the caregiving services you are currently advertising.</p>
                </div>
                <a href="{{ route('employee.offres.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-500/30 active:scale-95 w-fit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create New Offer
                </a>
            </div>

            {{-- Offers Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="offers-grid">
                @forelse($offers as $offer)
                    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-6 flex flex-col relative overflow-hidden group hover:border-brand-200 transition-colors">
                        
                        <!-- Decorative Background Blob -->
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-brand-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        
                        <div class="relative z-10 flex flex-col h-full">
                            <!-- Header & Badge -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="inline-flex px-3 py-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-lg ring-1 ring-inset ring-brand-500/20">
                                    {{ $offer->service_type ?? 'Care Service' }}
                                </span>
                                <span class="text-xs font-bold text-slate-400">#OFF-{{ $offer->id }}</span>
                            </div>

                            <!-- Details List -->
                            <div class="space-y-4 flex-1 mt-2">
                                
                                <!-- Work Arrangement -->
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Arrangement</p>
                                        <p class="text-sm font-bold text-slate-700">{{ $offer->working_house ? 'Live-in' : 'Live-out' }}</p>
                                    </div>
                                </div>

                                <!-- Target Areas -->
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Target Areas</p>
                                        <p class="text-sm font-medium text-slate-600 leading-snug">{{ $offer->address_service ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Base Address -->
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Base Address</p>
                                        <p class="text-sm font-medium text-slate-600 leading-snug">{{ $offer->address ?? 'N/A' }}</p>
                                    </div>
                                </div>

                            </div>
                            
                            <!-- Created Date Footer -->
                            <div class="mt-6 pt-4 border-t border-slate-50 text-[11px] font-medium text-slate-400 flex items-center justify-between">
                                <span>Posted on {{ \Carbon\Carbon::parse($offer->created_at)->format('M d, Y') }}</span>
                                <!-- Example of an action button you might want later -->
                                <!-- <button class="text-rose-500 hover:text-rose-700 font-bold transition-colors">Delete</button> -->
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 py-16 text-center w-full bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">No Active Offers</h3>
                        <p class="text-slate-500 font-medium text-sm mb-6">You haven't posted any caregiving services yet.</p>
                        <a href="{{ route('employee.offres.create') }}" class="inline-flex px-5 py-2.5 bg-brand-50 text-brand-700 font-bold rounded-xl text-sm transition-all hover:bg-brand-100">
                            Create Your First Offer
                        </a>
                    </div>
                @endforelse
            </div>
        </main>

        {{-- FAB (Mobile only since we added a desktop button at the top) --}}
        <button onclick="window.location.href='{{ route('employee.offres.create') }}'"
            class="lg:hidden fixed md:bottom-10 md:right-10 bottom-[90px] right-4 sm:right-6 w-14 h-14 bg-slate-900 text-white rounded-full flex items-center justify-center shadow-xl shadow-slate-900/30 hover:scale-110 active:scale-95 transition-transform z-50 group"
            title="Create New Offer">
            <svg class="w-6 h-6 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>

        <script src="{{ asset('js/modules/employee-offers.js') }}"></script>
    @else
        <div class="mb-8 p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-start gap-3">
            <svg class="w-6 h-6 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h3 class="text-sm font-bold text-amber-800">Account Pending Approval</h3>
                <p class="text-sm text-amber-700 mt-1">Your account is currently under review by our administration team. You will not appear in search results or receive booking requests until your account is activated.</p>
            </div>
        </div>
    @endif
</body>

</html>