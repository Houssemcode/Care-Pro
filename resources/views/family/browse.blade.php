<x-layouts.family active="browse">
    @section('title', 'Browse Caregivers')

    <x-family.page-header 
        breadcrumb="Search" 
        title="Find a Caregiver" 
        subtitle="Browse available professionals, filter by your needs, and request a booking." 
    />

    {{-- Notifications --}}
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ $errors->first() }}
        </div>
    @endif

    @php $selectClass = "w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10"; @endphp

    <form action="{{ route('family.browse') }}" method="GET" id="filter-form" class="mb-8">
        <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-5 space-y-4">
            {{-- Row 1: Search + Service --}}
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or location..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm">
                </div>
                <div class="md:w-48">
                    <select name="service_type" onchange="this.form.submit()" class="{{ $selectClass }}">
                        <option value="">All Services</option>
                        @foreach($service_types as $type)
                            <option value="{{ $type }}" {{ request('service_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 2: Wilaya + Arrangement + Radius + Near Me + Clear --}}
            <div class="flex flex-col md:flex-row gap-3 items-end flex-wrap">
                <div class="w-full md:w-44">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Wilaya</label>
                    <select name="wilaya" onchange="this.form.submit()" class="{{ $selectClass }}">
                        <option value="">All Wilayas</option>
                        @foreach($wilayas as $w)
                            <option value="{{ $w }}" {{ request('wilaya') == $w ? 'selected' : '' }}>{{ $w }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-44">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Arrangement</label>
                    <select name="working_house" onchange="this.form.submit()" class="{{ $selectClass }}">
                        <option value="">Any</option>
                        <option value="1" {{ request('working_house') === '1' ? 'selected' : '' }}>Live-in</option>
                        <option value="0" {{ request('working_house') === '0' ? 'selected' : '' }}>Live-out</option>
                    </select>
                </div>
                <input type="hidden" name="nearby" id="nearby-input" value="{{ request('nearby') }}">
                <button type="button" onclick="findNearby()" id="nearby-btn"
                    class="inline-flex items-center gap-2 px-5 py-3 {{ $isNearby ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/30' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }} font-bold rounded-xl text-sm transition-all active:scale-95 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span id="nearby-btn-text">{{ $isNearby ? '✓ Near Me' : 'Near Me' }}</span>
                </button>
                @if(request()->hasAny(['search','service_type','wilaya','working_house','nearby']))
                    <a href="{{ route('family.browse') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-slate-200 hover:bg-rose-50 text-rose-600 font-bold rounded-xl text-sm transition-all whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Clear
                    </a>
                @endif
            </div>
        </div>
    </form>

    @if($isNearby)
        <div class="mb-6 p-4 rounded-xl bg-brand-50 border border-brand-100 text-brand-800 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Showing caregivers sorted by distance from your saved home location.
        </div>
    @endif

    {{-- Offers Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-8 gap-6">
        @forelse($offers as $offer)
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col transition-all hover:-translate-y-1 hover:shadow-xl hover:border-brand-200">
                <div class="p-6 border-b border-slate-50 flex items-start gap-4">
                    <div class="w-14 h-14 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xl shadow-md shrink-0">
                        {{ strtoupper(substr($offer->employee->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('family.employee.profile', $offer->employee->id) }}" class="group">
                            <h3 class="font-display font-bold text-lg text-slate-900 group-hover:text-brand-600 transition-colors truncate">{{ $offer->employee->user->name ?? 'Caregiver' }}</h3>
                        </a>
                        <span class="inline-flex px-2.5 py-1 mt-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-md ring-1 ring-inset ring-brand-500/20">{{ $offer->service_type }}</span>
                    </div>
                    @if($isNearby && isset($offer->distance))
                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20 whitespace-nowrap shrink-0">
                            {{ number_format($offer->distance, 1) }} km
                        </span>
                    @endif
                </div>
                <div class="p-6 flex-1 space-y-4">
                    <div class="flex items-center gap-3 text-sm font-medium text-slate-600">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>{{ $offer->working_house ? 'Live-in' : 'Live-out' }} Arrangement</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-medium text-slate-600">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Serves: {{ $offer->commune }}, {{ $offer->wilaya }}</span>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('family.employee.profile', $offer->employee->id) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1 transition-colors">
                            View Profile & Reviews
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
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
                <p class="text-slate-500 font-medium text-sm">Try adjusting your filters or expanding the search radius.</p>
            </div>
        @endforelse
    </div>

    @if($offers->hasPages())
        <div class="mt-8">{{ $offers->links() }}</div>
    @endif

    {{-- Booking Modal --}}
    <div id="modal-booking" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeBookingModal()">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-content">
            <form id="booking-form" method="POST" action="">
                @csrf
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Request Caregiver</h3>
                    <button type="button" onclick="closeBookingModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="p-8 space-y-6">
                    <div class="bg-brand-50 border border-brand-100 rounded-2xl p-4 text-brand-800">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-brand-600 mb-1">Booking Details</p>
                        <p class="text-sm font-medium">You are requesting <strong id="modal-service" class="font-bold text-brand-900">...</strong> from <strong id="modal-name" class="font-bold text-brand-900">...</strong>.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Start Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="start_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">End Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="end_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest text-center">Dates are subject to caregiver approval.</p>
                </div>
                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeBookingModal()" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-500/30 active:scale-95">Send Request</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Booking modal
        const modal = document.getElementById('modal-booking');
        const modalContent = document.getElementById('modal-content');
        const bookingForm = document.getElementById('booking-form');

        function openBookingModal(offreId, caregiverName, serviceType) {
            document.getElementById('modal-name').textContent = caregiverName;
            document.getElementById('modal-service').textContent = serviceType;
            bookingForm.action = `/family/book/${offreId}`;
            modal.classList.remove('invisible', 'opacity-0');
            setTimeout(() => modalContent.classList.remove('scale-95', 'opacity-0'), 50);
        }

        function closeBookingModal() {
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('invisible', 'opacity-0'), 200);
        }

        // Live search debounce
        let searchTimer;
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => { document.getElementById('filter-form').submit(); }, 500); 
            });
        }

        // Near Me geolocation
        function findNearby() {
            const nearbyInput = document.getElementById('nearby-input');

            // Toggle off
            if (nearbyInput.value === '1') {
                nearbyInput.value = '';
                document.getElementById('filter-form').submit();
                return;
            }

            @if($familyLoc && $familyLoc->latitude && $familyLoc->logitude)
                nearbyInput.value = '1';
                document.getElementById('filter-form').submit();
            @else
                alert('Please set your home coordinates in Settings first to use Near Me.');
            @endif
        }
    </script>
    @endpush
</x-layouts.family>