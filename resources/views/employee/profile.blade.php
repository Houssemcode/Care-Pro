<x-layouts.employee active="profile">
    @section('title', __('My Profile'))

    <x-employee.page-header 
        breadcrumb="{{ __('Account') }}" 
        title="{{ __('My Profile') }}" 
        subtitle="{{ __('An overview of your professional account and platform statistics.') }}" 
    />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Left Column: ID Card --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-brand-500 to-brand-700"></div>
                
                <div class="w-24 h-24 rounded-full bg-white p-1 relative z-10 mt-6 mb-4 shadow-lg">
                    <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center text-3xl font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
                
                <h2 class="text-xl font-display font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-slate-500 font-medium mb-4">{{ Auth::user()->email }}</p>
                
                @php
                    $status = Auth::user()->employee->status ?? 'pending';
                    $statusConfig = [
                        'active' => [
                            'label' => __('Verified Caregiver'),
                            'class' => 'text-emerald-700 bg-emerald-50 ring-emerald-500/20'
                        ],
                        'pending' => [
                            'label' => __('Pending Verification'),
                            'class' => 'text-amber-700 bg-amber-50 ring-amber-500/20'
                        ],
                        'suspended' => [
                            'label' => __('Account Suspended'),
                            'class' => 'text-rose-700 bg-rose-50 ring-rose-500/20'
                        ]
                    ];
                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                @endphp

                <span class="inline-flex px-3 py-1 text-[10px] font-bold {{ $config['class'] }} rounded-lg ring-1 ring-inset uppercase tracking-wider mb-6">
                    {{ $config['label'] }}
                </span>

                <a href="{{ route('employee.settings') }}" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm">
                    {{ __('Edit Settings') }}
                </a>
            </div>
        </div>

        {{-- Right Column: Stats & Info --}}
        <div class="md:col-span-2 space-y-6">
            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">{{ __('Completed Jobs') }}</p>
                        <h3 class="text-2xl font-display font-bold text-slate-900">{{ $assignedJobs }}</h3>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">{{ __('Active Offers') }}</p>
                        <h3 class="text-2xl font-display font-bold text-slate-900">{{ $activeOffers }}</h3>
                    </div>
                </div>
            </div>

            {{-- Professional Profile --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <h3 class="font-display font-bold text-lg text-slate-800 mb-5">{{ __('Professional Background') }}</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Experience') }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->employee->experience ?? __('Not specified') }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Diploma') }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->employee->diploma ?? __('Not specified') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('About Me') }}</p>
                    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 rounded-xl p-5 border border-slate-100 italic">
                        {{ Auth::user()->employee->description ?? __('This caregiver hasn\'t written a bio yet.') }}
                    </p>
                </div>

                {{-- Location Info --}}
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Location') }}</p>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        @if(Auth::user()->localization && Auth::user()->localization->wilaya)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-800">{{ Auth::user()->localization->commune }}, {{ Auth::user()->localization->wilaya }}</p>
                                    @if(Auth::user()->localization->latitude && Auth::user()->localization->logitude)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ Auth::user()->localization->latitude }},{{ Auth::user()->localization->logitude }}" target="_blank" rel="noopener noreferrer"
                                            class="text-[10px] font-bold text-brand-600 hover:text-brand-700 transition-colors inline-flex items-center gap-1 mt-1">
                                            {{ __('View on Map') }}
                                            <svg class="w-3 h-3 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-slate-400 font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                {{ __('No location set.') }} <a href="{{ route('employee.settings') }}" class="text-brand-600 font-bold hover:underline">{{ __('Set it in Settings') }}</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Verification Documents --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <h3 class="font-display font-bold text-lg text-slate-800">{{ __('Verification Documents') }}</h3>
                        <a href="{{ route('employee.documents.info') }}" class="text-[10px] bg-brand-50 text-brand-600 hover:bg-brand-100 font-bold px-2 py-1 rounded-md transition-colors" title="{{ __('What should I upload?') }}">
                            <svg class="w-3.5 h-3.5 inline-block rtl:ml-0.5 ltr:mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Info') }}
                        </a>
                    </div>
                    @if($status === 'active')
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase rounded-lg border border-emerald-100">{{ __('Verified') }}</span>
                    @else
                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold uppercase rounded-lg border border-amber-100">{{ __('Verification Needed') }}</span>
                    @endif
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Upload Form -->
                <form action="{{ route('employee.documents.upload') }}" method="POST" enctype="multipart/form-data" class="mb-8 p-5 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Document Type') }}</label>
                            <select name="document_type" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type }}">{{ __($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('File (PDF, JPG, PNG)') }}</label>
                            <input type="file" name="file" required class="w-full text-xs text-slate-500 file:mr-4 rtl:file:ml-4 rtl:file:mr-0 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition-all">
                        </div>
                    </div>
                    <button type="submit" class="w-full py-3 bg-slate-900 text-white font-bold rounded-xl text-sm hover:bg-slate-800 transition-all active:scale-[0.98] shadow-lg shadow-slate-900/10">
                        {{ __('Upload Document') }}
                    </button>
                </form>

                <!-- Documents List -->
                <div class="space-y-3">
                    @forelse(Auth::user()->employee->documents as $doc)
                        <div class="flex items-center justify-between p-4 bg-white border border-slate-100 rounded-2xl group hover:border-brand-200 transition-all shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center shrink-0 group-hover:bg-brand-50 group-hover:text-brand-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 capitalize">{{ __($doc->document_type) }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ __('Uploaded on') }} {{ $doc->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="px-4 py-2 bg-slate-50 text-slate-600 font-bold rounded-xl text-xs hover:bg-slate-100 transition-all">
                                {{ __('View PDF') }}
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-sm text-slate-400 font-medium">{{ __('No documents uploaded yet.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.employee>