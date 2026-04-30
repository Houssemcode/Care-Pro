<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'My Reports')
    <x-employee.head />
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-employee.navbar :active="'reports'" />

    <main class="flex-1 w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        <div class="mb-8 sm:mb-10">
            <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">My Reports</h1>
            <p class="text-sm sm:text-base text-slate-500 font-medium">Track disputes or reports submitted by families regarding your services.</p>
        </div>

        {{-- Reports List --}}
        <div class="space-y-6">
            @forelse($reports as $report)
            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-6 flex flex-col relative overflow-hidden transition-colors hover:border-rose-200">
                
                <!-- Card Header -->
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-5">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center shrink-0 border border-rose-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg text-slate-800">{{ $report->rapport_reason ?? 'Dispute Filed' }}</h3>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                Reported by: <span class="text-slate-700 font-bold">{{ $report->family->user->name ?? 'Family ID: ' . $report->family_id }}</span> 
                                <span class="mx-1">•</span> 
                                {{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Dynamic Status Badge -->
                    <div class="shrink-0 self-start sm:self-auto">
                        @if($report->status === 'resolved')
                            <span class="inline-flex px-3 py-1.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20 uppercase tracking-wider">
                                Resolved by Admin
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1.5 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-lg ring-1 ring-inset ring-amber-500/20 uppercase tracking-wider">
                                Under Review
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Comment Box -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 relative">
                    <svg class="absolute top-4 left-4 w-6 h-6 text-slate-200" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path></svg>
                    <p class="text-sm text-slate-600 leading-relaxed pl-10 italic">
                        "{{ $report->comentaire ?? 'No additional comments provided.' }}"
                    </p>
                </div>
                
                <!-- Admin Resolution Note (If exists) -->
                @if($report->status === 'resolved' && !empty($report->admin_note))
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Admin Resolution Note</p>
                        <p class="text-sm font-medium text-emerald-700 bg-emerald-50/50 p-3 rounded-lg border border-emerald-100">{{ $report->admin_note }}</p>
                    </div>
                @endif
            </div>
            
            @empty
            {{-- Empty State --}}
            <div class="py-16 text-center bg-white rounded-2xl border border-slate-100 shadow-sm">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner border border-emerald-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-display font-bold text-xl text-slate-800 mb-1">Clean Record!</h3>
                <p class="text-slate-500 font-medium text-sm">There are no reports on your account. Keep up the great work.</p>
            </div>
            @endforelse

            {{-- Pagination (If you implement it in the controller) --}}
            @if(method_exists($reports, 'hasPages') && $reports->hasPages())
                <div class="mt-6">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>