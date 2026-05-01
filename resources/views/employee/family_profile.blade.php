<x-layouts.employee active="requests">
    @section('title', $family->user->name . ' - Family Profile')

    {{-- Profile Header Card --}}
    <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden mb-8">
        <div class="h-32 bg-gradient-to-r from-indigo-600 to-purple-700"></div>
        <div class="px-8 pb-8">
            <div class="relative flex flex-col md:flex-row gap-6 -mt-12 items-end md:items-center">
                <div class="w-32 h-32 rounded-[2rem] bg-white p-1.5 shadow-xl">
                    <div class="w-full h-full rounded-[1.75rem] bg-slate-900 text-white flex items-center justify-center font-bold text-4xl shadow-inner">
                        {{ strtoupper(substr($family->user->name, 0, 2)) }}
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-display font-extrabold text-slate-900">{{ $family->user->name }}</h1>
                    <div class="flex flex-wrap items-center gap-4 mt-2">
                        <span class="inline-flex px-3 py-1 text-[10px] font-bold text-indigo-700 bg-indigo-50 rounded-full ring-1 ring-inset ring-indigo-500/20 uppercase tracking-widest">
                            Family Client
                        </span>
                        <span class="text-slate-300 font-medium">|</span>
                        <span class="text-slate-600 text-sm font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $family->user->phone ?? 'Phone not provided' }}
                        </span>
                        <span class="text-slate-300 font-medium">|</span>
                        <span class="text-slate-600 text-sm font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $family->user->email }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Info & History --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Bookings With You</p>
                        <h3 class="text-2xl font-display font-bold text-slate-900">{{ $totalBookings }}</h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Currently Active</p>
                        <h3 class="text-2xl font-display font-bold text-slate-900">{{ $activeBookings }}</h3>
                    </div>
                </div>
            </div>

            {{-- Booking History --}}
            <section class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 pb-0">
                    <h2 class="text-xl font-display font-bold text-slate-900 mb-1 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </span>
                        Booking History
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mb-6 ml-11">Your shared booking history with this family.</p>
                </div>

                @if($bookingHistory->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80">
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Service</th>
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Start Date</th>
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Price</th>
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookingHistory as $booking)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-8 border-b border-slate-50">
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-lg ring-1 ring-inset ring-brand-500/20">
                                                {{ $booking->offre->service_type ?? 'Care Service' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-8 border-b border-slate-50 text-sm font-medium text-slate-600">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 px-8 border-b border-slate-50 text-sm font-bold text-slate-800">
                                            {{ number_format($booking->price ?? 0) }} DA
                                        </td>
                                        <td class="py-4 px-8 border-b border-slate-50 text-right">
                                            @php
                                                $statusClass = match($booking->status ?? 'active') {
                                                    'active' => 'text-emerald-700 bg-emerald-50 ring-emerald-500/20',
                                                    'completed' => 'text-slate-700 bg-slate-50 ring-slate-500/20',
                                                    default => 'text-amber-700 bg-amber-50 ring-amber-500/20',
                                                };
                                            @endphp
                                            <span class="inline-flex px-3 py-1 text-[10px] font-bold {{ $statusClass }} rounded-lg ring-1 ring-inset uppercase tracking-wider">
                                                {{ ucfirst($booking->status ?? 'active') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-8 pb-8">
                        <div class="py-12 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                            <div class="w-12 h-12 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <p class="text-slate-400 font-medium text-sm">No booking history with this family yet.</p>
                        </div>
                    </div>
                @endif
            </section>
        </div>

        {{-- Right Column: Contact & Location --}}
        <div class="space-y-8">
            {{-- Contact Info --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-display font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    Contact Information
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->email }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Phone</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Member Since</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Location --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-display font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </span>
                    Home Location
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Wilaya</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->localization->wilaya ?? 'Not set' }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Commune</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->localization->commune ?? 'Not set' }}</p>
                    </div>

                    @if($family->user->localization && $family->user->localization->latitude && $family->user->localization->logitude)
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $family->user->localization->latitude }},{{ $family->user->localization->logitude }}" target="_blank" rel="noopener"
                            class="flex items-center justify-center gap-3 w-full py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-brand-500/20 active:scale-95 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Get Directions on Google Maps
                        </a>
                    @else
                        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 text-center">
                            <p class="text-sm font-bold text-amber-700">GPS coordinates not available</p>
                            <p class="text-[10px] text-amber-600 mt-1 font-medium">The family hasn't set their location yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('employee.requests') }}" class="flex items-center justify-center gap-3 w-full py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl transition-all shadow-lg shadow-slate-900/10 active:scale-95 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Requests
            </a>
        </div>
    </div>
</x-layouts.employee>
