<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'System Oversight')
    <x-admin.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-[100dvh]">

    <x-admin.navbar active="dashboard" />

    <div class="flex min-h-screen">

        <!-- ════════════ MAIN CONTENT ════════════ -->
        <main class="flex-1 lg:ml-[270px] w-full p-4 sm:p-6 lg:p-10 xl:p-12 max-w-full overflow-x-hidden">

            <!-- Mobile Top Bar -->
            <div
                class="lg:hidden flex items-center justify-between bg-white px-5 py-4 rounded-2xl shadow-sm border border-slate-100 mb-6">
                <button onclick="toggleSidebar()"
                    class="p-2 -ml-2 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <span class="font-display font-bold text-slate-800">System Oversight</span>
                <a href="{{ route('admin.profile') }}"
                    class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</a>
            </div>

            <!-- Page Header -->
            <header
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-slate-200 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Dashboard</p>
                    <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 tracking-tight">System
                        Oversight</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Platform administration and moderation.</p>
                </div>
                <div
                    class="hidden lg:flex items-center gap-3 bg-white p-2 pr-5 rounded-full shadow-sm border border-slate-100">
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center gap-2 hover:bg-slate-50 p-1 pr-3 rounded-full transition cursor-pointer">
                        <div
                            class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <span class="font-bold text-slate-800 text-sm">{{ Auth::user()->name }}</span>
                    </a>
                    <a href="{{ route('admin.settings') }}"
                        class="text-slate-400 hover:text-slate-700 transition p-1.5 rounded-lg hover:bg-slate-100"
                        title="Settings">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900" id="stat-pending">{{ $pendingCount }}</p>
                        <p class="text-xs font-semibold text-slate-400">Pending</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900">{{ $approvedCount }}</p>
                        <p class="text-xs font-semibold text-slate-400">Approved</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900">{{ $reportsCount }}</p>
                        <p class="text-xs font-semibold text-slate-400">Reports</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div
                        class="w-11 h-11 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-extrabold text-slate-900">{{ $totalUsers }}</p>
                        <p class="text-xs font-semibold text-slate-400">Total Users</p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                <!-- Verification Table -->
                <section class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
                    <div class="bg-gradient-to-r from-slate-50 to-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-display font-bold text-slate-900">Pending Verifications</h3>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">Approve new caregiver accounts.</p>
                        </div>
                        <span class="bg-amber-100/50 text-amber-700 px-3 py-1.5 rounded-lg text-[11px] font-bold ring-1 ring-amber-500/20">
                            {{ $pendingCount }} Pending
                        </span>
                    </div>
                    <div class="overflow-x-auto custom-scrollbar flex-1 w-full">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Credentials</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingEmployees as $employee)
                                    <tr>
                                        <td><span class="font-bold text-slate-500">#{{ $employee->id }}</span></td>
                                        <td><span class="font-bold text-slate-900">{{ $employee->user->name }}</span></td>
                                        <td>{{ $employee->diploma ?? 'Awaiting Upload' }}</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button class="btn-approve" onclick="openModal('modal-review-{{ $employee->id }}')">Review</button>
                                                
                                                <!-- Review Modal for this Employee -->
                                                <div id="modal-review-{{ $employee->id }}" class="modal-overlay text-left" onclick="if(event.target===this) closeModal('modal-review-{{ $employee->id }}')">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="font-display font-bold text-lg text-slate-800">Review Caregiver</h3>
                                                            <button onclick="closeModal('modal-review-{{ $employee->id }}')" class="text-slate-400 hover:text-slate-600 transition">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-6">
                                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Verify Account for</p>
                                                                <h4 class="text-xl font-display font-bold text-slate-900">{{ $employee->user->name }}</h4>
                                                                <p class="text-xs text-slate-500 font-medium mt-1">Joined {{ $employee->user->created_at->format('M d, Y') }}</p>
                                                            </div>

                                                            <div class="space-y-6">
                                                                <!-- Professional Info -->
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

                                                                <!-- Verification Documents Snippet -->
                                                                <div>
                                                                    <p class="text-xs font-bold text-slate-500 uppercase mb-3">Verification Documents</p>
                                                                    @forelse($employee->documents as $doc)
                                                                        <div class="flex items-center justify-between p-4 bg-slate-900 rounded-xl mb-3 border border-slate-800">
                                                                            <span class="font-bold text-white capitalize text-sm">
                                                                                {{ str_replace('_', ' ', $doc->document_type) }}
                                                                            </span>
                                                                            
                                                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-sm font-bold text-slate-300 hover:text-white transition-colors">
                                                                                View PDF
                                                                            </a>
                                                                        </div>
                                                                    @empty
                                                                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 text-amber-700 text-xs font-medium italic">
                                                                            No documents uploaded yet.
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button onclick="closeModal('modal-review-{{ $employee->id }}')" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700">Cancel</button>
                                                            <div class="flex items-center gap-2">
                                                                <button class="px-4 py-2 bg-rose-50 text-rose-600 font-bold rounded-xl text-sm hover:bg-rose-100 transition-colors">Reject</button>
                                                                <form action="{{ route('admin.users.approve', $employee->user_id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                <button type="submit" class="btn-approve px-6 py-2 shadow-lg shadow-emerald-500/30 active:scale-95 transition-all">Approve & Activate</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-slate-500 font-medium">No pending verifications at this time.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Reports Section -->
                <section class="xl:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col h-[400px] sm:h-[500px] xl:h-auto">
                    <div class="bg-gradient-to-r from-rose-50/50 to-white px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-display font-bold text-slate-900">Active Reports</h3>
                            <p class="text-[11px] font-medium text-slate-500 mt-0.5">Platform disputes and alerts.</p>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-2 custom-scrollbar">
                        @forelse ($activeReports as $report)
                            <div class="report-card">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-bold text-slate-900">{{ $report->report_reason }}</span>
                                    <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded uppercase tracking-wider">High</span>
                                </div>
                                
                                <!-- This replaces the hardcoded names -->
                                <p class="text-xs font-semibold text-slate-600">
                                    {{ $report->employee->user->name ?? 'Unknown Employee' }} ↔ {{ $report->family->user->name ?? 'Unknown Family' }}
                                </p>
                                
                                <p class="text-xs text-slate-500 italic mt-1 pb-2">"{{ $report->description }}"</p>
                                
                                <button class="mt-auto self-end px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95" onclick="openResolveConfirm({{ $report->id }})">
                                    Resolve Issue
                                </button>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-500 font-medium text-sm">No active reports.</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Confirm Report Resolve -->
    <div id="modal-confirm-resolve" class="modal-overlay"
        onclick="if(event.target===this) closeModal('modal-confirm-resolve')">
        <div class="modal-content max-w-sm">
            <div class="px-6 py-6 text-center flex flex-col items-center">
                <div
                    class="w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-emerald-100 text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-display font-bold text-xl text-slate-800 mb-2">Resolve Dispute</h3>
                <p class="text-sm text-slate-500">Are you sure this issue is resolved and should be closed?</p>
            </div>
            <div class="modal-footer justify-center bg-transparent border-t-0 pt-0">
                <button onclick="closeModal('modal-confirm-resolve')" class="btn-action w-full">Cancel</button>
                <button class="btn-action w-full text-white bg-emerald-500 border-emerald-500 hover:bg-emerald-600"
                    onclick="confirmResolveAction()">Mark Resolved</button>
            </div>
            <form id="resolve-report-form" method="POST" class="hidden">
                @csrf
                @method('PATCH')
                <input type="hidden" id="resolve-report-id">
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/modules/admin.js') }}"></script>
    <script>
        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

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

</body>

</html>