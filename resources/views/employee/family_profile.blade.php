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
                            {{ __('Family Client') }}
                        </span>
                        <span class="text-slate-300 font-medium">|</span>
                        <span class="text-slate-600 text-sm font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $family->user->phone ?? __('Phone not provided') }}
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

    @if (session('success'))
        <div class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

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
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">{{ __('Bookings With You') }}</p>
                        <h3 class="text-2xl font-display font-bold text-slate-900">{{ $totalBookings }}</h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">{{ __('Currently Active') }}</p>
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
                        {{ __('Booking History') }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mb-6 rtl:mr-11 ltr:ml-11">{{ __('Your shared booking history with this family.') }}</p>
                </div>

                @if($bookingHistory->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80">
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rtl:text-right">{{ __('Service') }}</th>
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rtl:text-right">{{ __('Start Date') }}</th>
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rtl:text-right">{{ __('Price') }}</th>
                                    <th class="pb-3 pt-4 px-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rtl:text-left ltr:text-right">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookingHistory as $booking)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-8 border-b border-slate-50">
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-lg ring-1 ring-inset ring-brand-500/20">
                                                {{ $booking->offre->service_type ?? __('Care Service') }}
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
                                                {{ __(ucfirst($booking->status ?? 'active')) }}
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
                            <p class="text-slate-400 font-medium text-sm">{{ __('No booking history with this family yet.') }}</p>
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
                    {{ __('Contact Information') }}
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Email') }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->email }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Phone') }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->phone ?? __('Not provided') }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Member Since') }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Location --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-display font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </span>
                    {{ __('Home Location') }}
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Wilaya') }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->localization?->wilaya ?? __('Not set') }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Commune') }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ $family->user->localization?->commune ?? __('Not set') }}</p>
                    </div>

                    @if($family->user->localization && $family->user->localization->latitude && $family->user->localization->logitude)
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $family->user->localization->latitude }},{{ $family->user->localization->logitude }}" target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-3 w-full py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-brand-500/20 active:scale-95 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ __('Get Directions on Google Maps') }}
                        </a>
                    @else
                        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 text-center">
                            <p class="text-sm font-bold text-amber-700">{{ __('GPS coordinates not available') }}</p>
                            <p class="text-[10px] text-amber-600 mt-1 font-medium">{{ __('The family hasn\'t set their location yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ route('employee.requests') }}" class="flex items-center justify-center gap-3 w-full py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl transition-all shadow-lg shadow-slate-900/10 active:scale-95 group">
                    <svg class="w-5 h-5 rtl:group-hover:translate-x-1 ltr:group-hover:-translate-x-1 rtl:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    {{ __('Back to Requests') }}
                </a>
                <button onclick="openReportModal('{{ $family->id }}', '{{ addslashes($family->user->name) }}')" class="flex items-center justify-center gap-3 w-full py-4 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-2xl transition-all active:scale-95 border border-rose-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    {{ __('Report Family Issue') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Report Modal --}}
    <div id="modal-report" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeReportModal()">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-report-content">
            <form id="report-form" method="POST" action="{{ route('employee.reports.store') }}">
                @csrf
                <input type="hidden" name="family_id" id="report_family_id" value="">
                
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">{{ __('Report Family') }}</h3>
                    <button type="button" onclick="closeReportModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-8 space-y-6">
                    @if ($errors->any())
                        <div class="bg-rose-50 border border-rose-100 text-rose-700 px-4 py-3 rounded-xl text-sm font-medium">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-rose-800">
                        <p class="text-sm font-medium">{{ __('Reporting') }} <strong id="report_family_name" class="font-bold text-rose-900">...</strong>{{ __('. Our team will review this case shortly.') }}</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Reason for Report') }} <span class="text-rose-500">*</span></label>
                        <select name="report_reason" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] rtl:bg-[left_16px_center] ltr:bg-[right_16px_center] bg-no-repeat rtl:pl-10 ltr:pr-10">
                            <option value="" disabled selected>{{ __('Select a reason...') }}</option>
                            <option value="Unsafe Environment">{{ __('Unsafe Environment') }}</option>
                            <option value="Unprofessional Behavior">{{ __('Unprofessional Behavior') }}</option>
                            <option value="Payment Issue">{{ __('Payment Issue') }}</option>
                            <option value="Other">{{ __('Other') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Additional Details') }} <span class="text-rose-500">*</span></label>
                        <textarea name="description" required rows="4" placeholder="{{ __('Please provide specific details about the incident...') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium resize-none transition-all"></textarea>
                    </div>
                </div>

                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeReportModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-8 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-rose-500/30 active:scale-95">{{ __('Submit Report') }}</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const reportModal = document.getElementById('modal-report');
        const reportModalContent = document.getElementById('modal-report-content');

        function openReportModal(familyId, familyName) {
            document.getElementById('report_family_id').value = familyId;
            document.getElementById('report_family_name').textContent = familyName;
            reportModal.classList.remove('invisible', 'opacity-0');
            setTimeout(() => reportModalContent.classList.remove('scale-95', 'opacity-0'), 50);
        }

        function closeReportModal() {
            reportModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => reportModal.classList.add('invisible', 'opacity-0'), 200);
        }
    </script>
    @endpush
</x-layouts.employee>
