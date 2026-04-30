<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'Browse Caregivers')
    <x-family.head /> <!-- Reusing your head component for styling -->
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    {{-- Make sure you create a Family Navbar component! --}}
    <x-family.navbar active="browse" />

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">

        {{-- Page Header & Filters --}}
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-2">Find a Caregiver</h1>
            <p class="text-sm sm:text-base text-slate-500 font-medium mb-8">Browse available professionals, filter by your needs, and request a booking.</p>

            {{-- Notifications --}}
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('family.browse') }}" method="GET" id="filter-form">
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-4 sm:p-5 flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or location (e.g. Algiers)..."
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm">
                    </div>

                    <!-- Service Dropdown -->
                    <div class="md:w-64">
                        <select name="service_type" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer">
                            <option value="">All Services</option>
                            @foreach($service_types as $type)
                                <option value="{{ $type }}" {{ request('service_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        {{-- Offers Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-8 gap-6">
            @forelse($offers as $offer)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col transition-all hover:-translate-y-1 hover:shadow-xl hover:border-brand-200">
                    <!-- Caregiver Header -->
                    <div class="p-6 border-b border-slate-50 flex items-start gap-4">
                        <div class="w-14 h-14 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xl shadow-md shrink-0">
                            {{ strtoupper(substr($offer->employee->user->name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg text-slate-900">{{ $offer->employee->user->name ?? 'Caregiver' }}</h3>
                            <span class="inline-flex px-2.5 py-1 mt-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-md ring-1 ring-inset ring-brand-500/20">
                                {{ $offer->service_type }}
                            </span>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 flex-1 space-y-4">
                        <div class="flex items-center gap-3 text-sm font-medium text-slate-600">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>{{ $offer->working_house ? 'Live-in' : 'Live-out' }} Arrangement</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm font-medium text-slate-600">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Serves: {{ $offer->address_service }}</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="p-6 pt-0 mt-auto">
                        <button onclick="openBookingModal({{ $offer->id }}, '{{ addslashes($offer->employee->user->name ?? 'Caregiver') }}', '{{ $offer->service_type }}')" 
                            class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">
                            Request Booking
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 py-16 text-center w-full bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">No Caregivers Found</h3>
                    <p class="text-slate-500 font-medium text-sm">We couldn't find any offers matching your current search criteria.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($offers->hasPages())
            <div class="mt-8">
                {{ $offers->links() }}
            </div>
        @endif

    </main>

    {{-- Booking Modal (Hidden by default) --}}
    <div id="modal-booking" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeBookingModal()">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-content">
            
            <form id="booking-form" method="POST" action="">
                @csrf
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Request Caregiver</h3>
                    <button type="button" onclick="closeBookingModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-6 space-y-5">
                    <div class="bg-brand-50 border border-brand-100 rounded-xl p-4 text-brand-800">
                        <p class="text-xs font-bold uppercase tracking-wider text-brand-600 mb-1">Booking Details</p>
                        <p class="text-sm font-medium">You are requesting <strong id="modal-service" class="font-bold">...</strong> from <strong id="modal-name" class="font-bold">...</strong>.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Start Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="start_date" required min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none text-sm font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">End Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="end_date" required min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none text-sm font-medium">
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-500 font-medium">The caregiver will review your dates and confirm if they are available.</p>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeBookingModal()" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm active:scale-95">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-500/30 active:scale-95">Send Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal Logic
        const modal = document.getElementById('modal-booking');
        const modalContent = document.getElementById('modal-content');
        const bookingForm = document.getElementById('booking-form');

        function openBookingModal(offreId, caregiverName, serviceType) {
            // Update Modal UI
            document.getElementById('modal-name').textContent = caregiverName;
            document.getElementById('modal-service').textContent = serviceType;
            
            // Set Form Action Route
            bookingForm.action = `/family/book/${offreId}`;
            
            // Show Modal
            modal.classList.remove('invisible', 'opacity-0');
            setTimeout(() => modalContent.classList.remove('scale-95', 'opacity-0'), 50);
        }

        function closeBookingModal() {
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('invisible', 'opacity-0'), 200);
        }

        // Live Search Debounce
        let searchTimer;
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    document.getElementById('filter-form').submit();
                }, 500); 
            });
        }
    </script>
</body>
</html>