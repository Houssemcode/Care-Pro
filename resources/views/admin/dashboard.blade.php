<x-layouts.admin active="dashboard" title="System Oversight">
    @section('title', 'System Oversight')

    <x-admin.page-header 
        breadcrumb="Dashboard" 
        title="System Oversight" 
        subtitle="Real-time analytics and platform performance metrics." 
    />

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-10">
        <x-admin.stat-card 
            label="Total Users" 
            value="{{ $totalUsers }}" 
            color="brand"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
        />

        <x-admin.stat-card 
            label="Active Bookings" 
            value="{{ $approvedCount }}" 
            color="emerald"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>'
        />

        <x-admin.stat-card 
            label="Pending Verifications" 
            value="{{ $pendingCount }}" 
            color="amber"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>'
        />

        <x-admin.stat-card 
            label="Active Reports" 
            value="{{ $reportsCount }}" 
            color="rose"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>'
        />
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Main Stats & Charts -->
        <div class="xl:col-span-2 space-y-8">


            <!-- Verification Queue -->
            <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
                <div class="bg-gradient-to-r from-slate-50 to-white px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-display font-bold text-slate-900">Pending Verifications</h3>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Approve new caregiver accounts.</p>
                    </div>
                    <span class="bg-amber-100/50 text-amber-700 px-3 py-1.5 rounded-lg text-[11px] font-bold ring-1 ring-amber-500/20">
                        {{ $pendingCount }} Pending
                    </span>
                </div>
                <div class="overflow-x-auto custom-scrollbar flex-1 w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">ID</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Name</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Credentials</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Status</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($pendingEmployees as $employee)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-4"><span class="font-bold text-slate-500">#{{ $employee->id }}</span></td>
                                    <td class="px-8 py-4"><span class="font-bold text-slate-900">{{ $employee->user->name }}</span></td>
                                    <td class="px-8 py-4 text-sm text-slate-600">{{ $employee->diploma ?? 'Awaiting Upload' }}</td>
                                    <td class="px-8 py-4"><span class="inline-flex px-2 py-0.5 rounded-lg bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider">Pending</span></td>
                                    <td class="px-8 py-4 text-right">
                                        <button class="px-4 py-1.5 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-lg text-xs shadow-lg shadow-brand-500/20 active:scale-95 transition-all" onclick="openModal('modal-review-{{ $employee->id }}')">Review</button>
                                        
                                        <!-- Review Modal -->
                                        <div id="modal-review-{{ $employee->id }}" class="modal-overlay text-left z-[100]" onclick="if(event.target===this) closeModal('modal-review-{{ $employee->id }}')">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="font-display font-bold text-lg text-slate-800">Review Caregiver</h3>
                                                    <button onclick="closeModal('modal-review-{{ $employee->id }}')" class="text-slate-400 hover:text-slate-600 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-6">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Verify Account for</p>
                                                        <h4 class="text-xl font-display font-bold text-slate-900">{{ $employee->user->name }}</h4>
                                                        <p class="text-xs text-slate-500 font-medium mt-1">Joined {{ $employee->user->created_at->format('M d, Y') }}</p>
                                                    </div>
                                                    <div class="space-y-6">
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div class="bg-white p-3 border border-slate-100 rounded-xl">
                                                                <p class="text-[10px] font-bold text-slate-400 uppercase">Diploma</p>
                                                                <p class="text-sm font-bold text-brand-600">{{ $employee->diploma ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="bg-white p-3 border border-slate-100 rounded-xl">
                                                                <p class="text-[10px] font-bold text-slate-400 uppercase">Experience</p>
                                                                <p class="text-sm font-bold text-slate-900">{{ $employee->experience ?? '0' }} Years</p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-bold text-slate-500 uppercase mb-3">Verification Documents</p>
                                                            @forelse($employee->documents as $doc)
                                                                <div class="flex items-center justify-between p-4 bg-slate-900 rounded-xl mb-3 border border-slate-800">
                                                                    <span class="font-bold text-white capitalize text-sm">{{ str_replace('_', ' ', $doc->document_type) }}</span>
                                                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-sm font-bold text-slate-300 hover:text-white transition-colors">View PDF</a>
                                                                </div>
                                                            @empty
                                                                <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 text-amber-700 text-xs font-medium italic">No documents uploaded yet.</div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button onclick="closeModal('modal-review-{{ $employee->id }}')" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700">Cancel</button>
                                                    <form action="{{ route('admin.users.approve', $employee->user_id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-6 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm shadow-lg shadow-emerald-500/30 active:scale-95 transition-all">Approve & Activate</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-10 text-slate-400 italic text-sm">No pending verifications at this time.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-8">
            <!-- Active Reports List -->
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center bg-rose-50/30">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Active Reports</h3>
                    <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[10px] font-bold rounded-md">{{ $reportsCount }} Active</span>
                </div>
                <div class="p-4 space-y-4 max-h-[500px] overflow-y-auto custom-scrollbar">
                    @forelse ($activeReports as $report)
                        <div class="p-4 rounded-2xl bg-white border border-slate-100 hover:border-rose-200 transition-all group">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold text-rose-600 uppercase tracking-widest">{{ $report->report_reason }}</span>
                                <span class="text-[9px] font-bold text-slate-400">{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs font-bold text-slate-900 mb-1">{{ $report->employee->user->name ?? 'Unknown' }} ↔ {{ $report->family->user->name ?? 'Unknown' }}</p>
                            <p class="text-[11px] text-slate-500 italic line-clamp-2 mb-3">"{{ $report->description }}"</p>
                            <button class="w-full py-1.5 bg-slate-50 hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 font-bold rounded-lg text-[10px] transition-colors border border-transparent hover:border-emerald-100" onclick="openResolveConfirm({{ $report->id }})">
                                Mark Resolved
                            </button>
                        </div>
                    @empty
                        <div class="py-10 text-center text-slate-400 italic text-xs">No active reports.</div>
                    @endforelse
                </div>
                <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/50">
                    <a href="{{ route('admin.reports') }}" class="block text-center text-xs font-bold text-slate-500 hover:text-brand-600 transition">Manage All Reports</a>
                </div>
            </div>


        </div>
    </div>

    <!-- Confirm Resolve Modal -->
    <div id="modal-confirm-resolve" class="modal-overlay z-[100]" onclick="if(event.target===this) closeModal('modal-confirm-resolve')">
        <div class="modal-content max-w-sm">
            <div class="px-6 py-8 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-emerald-100 text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-display font-bold text-xl text-slate-800 mb-2">Resolve Dispute</h3>
                <p class="text-sm text-slate-500">Are you sure this issue is resolved and should be closed?</p>
            </div>
            <div class="modal-footer justify-center bg-transparent border-t-0 pt-0">
                <button onclick="closeModal('modal-confirm-resolve')" class="px-4 py-2 text-sm font-bold text-slate-500">Cancel</button>
                <button class="px-6 py-2 bg-emerald-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-emerald-500/30 active:scale-95 transition-all" onclick="confirmResolveAction()">Mark Resolved</button>
            </div>
            <form id="resolve-report-form" method="POST" class="hidden">
                @csrf
                @method('PATCH')
                <input type="hidden" id="resolve-report-id">
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        window.openResolveConfirm = function (id) {
            document.getElementById('resolve-report-id').value = id;
            openModal('modal-confirm-resolve');
        };

        window.confirmResolveAction = function () {
            const id = document.getElementById('resolve-report-id').value;
            const form = document.getElementById('resolve-report-form');
            form.action = `/admin/reports/${id}/resolve`;
            form.submit();
        };
    </script>
    @endpush
</x-layouts.admin>