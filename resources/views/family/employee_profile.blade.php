<x-layouts.family active="browse">
    @section('title', $employee->user->name . ' - Profile')

    {{-- Profile Header Card --}}
    <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden mb-8">
        <div class="h-32 bg-gradient-to-r from-brand-600 to-slate-900"></div>
        <div class="px-8 pb-8">
            <div class="relative flex flex-col md:flex-row gap-6 -mt-12 items-end md:items-center">
                <div class="w-32 h-32 rounded-[2rem] bg-white p-1.5 shadow-xl">
                    <div class="w-full h-full rounded-[1.75rem] bg-slate-900 text-white flex items-center justify-center font-bold text-4xl shadow-inner">
                        {{ strtoupper(substr($employee->user->name, 0, 2)) }}
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-display font-extrabold text-slate-900">{{ $employee->user->name }}</h1>
                    <div class="flex flex-wrap items-center gap-4 mt-2">
                        <div class="flex items-center text-amber-500 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($averageRating) ? 'fill-current' : 'text-slate-300' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                            <span class="ml-2 text-slate-700 text-xs font-bold">{{ number_format($averageRating, 1) }} ({{ $ratings->count() }} Reviews)</span>
                        </div>
                        <span class="text-slate-300 font-medium">|</span>
                        <span class="text-slate-600 text-sm font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $employee->user->phone ?? 'Private Number' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: About & Experience --}}
        <div class="lg:col-span-2 space-y-8">
            <section class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                <h2 class="text-xl font-display font-bold text-slate-900 mb-5 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    About Me
                </h2>
                <p class="text-slate-600 leading-relaxed whitespace-pre-line italic">
                    {{ $employee->description ?? 'This caregiver hasn\'t provided a description yet.' }}
                </p>
            </section>

            <section class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-display font-bold text-slate-900 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </span>
                        Family Reviews
                    </h2>
                    <div class="px-3 py-1 bg-emerald-50 rounded-lg text-[10px] font-bold text-emerald-700 uppercase tracking-widest border border-emerald-100">
                        Verified Feedback
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($ratings as $rating)
                        <div class="p-6 rounded-2xl bg-slate-50/50 border border-slate-100 relative">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-100 flex items-center justify-center font-bold text-slate-400 shadow-sm uppercase">
                                        {{ substr($rating->assignmentService->family->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ $rating->assignmentService->family->user->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $rating->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex text-amber-400 gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $rating->stars ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-slate-600 italic leading-relaxed text-sm bg-white p-4 rounded-xl border border-slate-50">
                                "{{ $rating->comment }}"
                            </p>
                        </div>
                    @empty
                        <div class="py-12 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                            <p class="text-slate-400 font-medium">No reviews yet for this caregiver.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- Right Column: Professional Background --}}
        <div class="space-y-8">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-display font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </span>
                    Qualifications
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Experience</p>
                        <p class="text-sm font-bold text-slate-800">{{ $employee->experience ?? 'Not specified' }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Diploma</p>
                        <p class="text-sm font-bold text-slate-800">{{ $employee->diploma ?? 'Not specified' }}</p>
                    </div>
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-bold uppercase tracking-widest">Account Status</span>
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-emerald-100">
                                Verified
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-display font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    Services Provided
                </h3>
                <div class="space-y-3">
                    @foreach($employee->offres as $offer)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 group transition-all">
                            <p class="font-bold text-slate-800 text-sm group-hover:text-brand-600 transition-colors">{{ $offer->service_type }}</p>
                            <p class="text-[10px] text-slate-500 mt-1 flex items-center gap-1.5 font-bold uppercase tracking-widest">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $offer->commune }}, {{ $offer->wilaya }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('family.browse') }}" class="flex items-center justify-center gap-3 w-full py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl transition-all shadow-lg shadow-slate-900/10 active:scale-95 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Browse
            </a>
        </div>
    </div>
</x-layouts.family>
