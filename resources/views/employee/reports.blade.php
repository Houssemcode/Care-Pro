<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'My Reports')
    @include('partials.employee-head')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    @include('partials.employee-navbar', ['active' => 'reports'])

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        <div class="mb-8 sm:mb-10">
            <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">My Reports</h1>
            <p class="text-sm sm:text-base text-slate-500 font-medium">Track reports submitted about your services.</p>
        </div>

        {{-- Reports List --}}
        <div class="space-y-4">
            @foreach($reports as $report)
            <div class="info-card">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-slate-800">{{ $report->rapport_reason }}</h3>
                            <p class="text-xs text-slate-500 font-medium">Submitted by: Family ID {{ $report->family_id }}</p>
                        </div>
                    </div>
                    <span class="badge badge-resolved">Reported</span>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 rounded-xl p-4 border border-slate-100">"{{ $report->comentaire }}"</p>
            </div>
            @endforeach

            @if($reports->isEmpty())
            {{-- Empty State --}}
            <div class="py-16 text-center text-slate-400 font-medium">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                No reports on your account. Great work!
            </div>
            @endif
        </div>
    </main>
</body>
</html>
