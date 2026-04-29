<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'My Profile')
    @include('partials.employee-head')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    @include('partials.employee-navbar', ['active' => 'profile'])

    <main class="flex-1 w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 page-enter">
        {{-- Profile Header --}}
        <div class="info-card mb-6 flex flex-col sm:flex-row items-center gap-6">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-display font-bold text-3xl shadow-lg shrink-0">SB</div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 mb-1">Sonia Belkacem</h1>
                <p class="text-sm text-slate-500 font-medium mb-3">Verified Caregiver • Joined Jan 2024</p>
                <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                    <span class="badge badge-resolved">Active</span>
                    <span class="inline-block px-3 py-1 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-lg bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-500/20">Nursing Degree</span>
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-lg bg-slate-50 text-slate-600 ring-1 ring-inset ring-slate-200">4y Experience</span>
                </div>
            </div>
            <a href="{{ route('employee.settings') }}" class="btn-secondary shrink-0">Edit Profile</a>
        </div>

        {{-- Info Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="info-card"><p class="label-text">Email</p><p class="value-text">sonia.belkacem@email.com</p></div>
            <div class="info-card"><p class="label-text">Phone</p><p class="value-text">+213 555 789 012</p></div>
            <div class="info-card"><p class="label-text">Location</p><p class="value-text">Hydra, Algiers</p></div>
            <div class="info-card">
                <p class="label-text">Average Rating</p>
                <p class="value-text flex items-center gap-1">
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    4.5 / 5.0
                </p>
            </div>
        </div>

        {{-- Documents --}}
        <div class="info-card">
            <h2 class="font-display font-bold text-lg text-slate-800 mb-4">Uploaded Documents</h2>
            <div class="space-y-3">
                @foreach(['Nursing Degree Certificate', 'Criminal Record Certificate', 'National ID Card'] as $doc)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                        <span class="text-sm font-bold text-slate-700">{{ $doc }}</span>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Verified</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>
