<x-layouts.admin active="reports" title="System Reports">
    @section('title', 'Reports & Disputes')

    <x-admin.page-header 
        breadcrumb="Reports" 
        title="System Reports" 
        subtitle="Review disputes initiated by families against caregivers." 
    />

    <!-- Filters Section -->
    <form action="{{ route('admin.reports') }}" method="GET" id="filter-form" class="mb-6">
        <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="md:col-span-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID, Family, or Caregiver..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                </div>

                <!-- Status Dropdown -->
                <div>
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active (Unresolved)</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <!-- Reports Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
        <div class="bg-gradient-to-r from-rose-50/50 to-white px-8 py-6 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-display font-bold text-slate-900">Submitted Reports</h3>
        </div>

        <div class="overflow-x-auto custom-scrollbar flex-1 w-full">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">ID & Date</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Family (Reporter)</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Caregiver (Reported)</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Reason & Details</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($reports as $report)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-4">
                            <span class="font-bold text-slate-700">#RPT-{{ $report->id }}</span><br>
                            <span class="text-slate-400 text-[10px]">{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y') }}</span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="font-bold text-slate-800">{{ $report->family->user->name ?? 'Unknown Family' }}</span><br>
                            <span class="text-slate-500 text-[10px]">ID: {{ $report->family_id }}</span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="font-bold text-slate-800">{{ $report->employee->user->name ?? 'Unknown Caregiver' }}</span><br>
                            <span class="text-slate-500 text-[10px]">ID: {{ $report->employee_id }}</span>
                        </td>
                        <td class="px-8 py-4 max-w-[250px]">
                            <span class="font-bold text-rose-600/90 text-xs">{{ $report->rapport_reason ?? $report->report_reason ?? 'Dispute' }}</span>
                            <p class="text-[11px] text-slate-500 line-clamp-2 mt-1" title="{{ $report->description }}">{{ $report->description }}</p>
                        </td>
                        <td class="px-8 py-4">
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $report->status === 'active' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20' : 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/20' }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right space-x-1">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition-all active:scale-95" 
                                    onclick="viewReportDetails(
                                        '{{ $report->id }}',
                                        '{{ addslashes($report->family->user->name ?? 'Unknown Family') }}',
                                        '{{ addslashes($report->employee->user->name ?? 'Unknown Caregiver') }}',
                                        '{{ addslashes($report->rapport_reason ?? $report->report_reason ?? 'Dispute') }}',
                                        '{{ addslashes(str_replace(["\r", "\n"], ' ', $report->description ?? '')) }}'
                                    )">
                                    Details
                                </button>
                                
                                @if($report->status === 'active')
                                    <button class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold rounded-lg text-xs transition-all border border-brand-100 active:scale-95" onclick="openResolveModal('{{ $report->id }}')">Resolve</button>
                                @endif
                                
                                <button class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-lg text-xs transition-all border border-rose-100 active:scale-95" onclick="openConfirm('ban', '{{ $report->employee->user->id ?? 0 }}', '{{ addslashes($report->employee->user->name ?? 'Caregiver') }}')">Ban</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-10 text-slate-400 italic text-sm">No reports match your current filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
        <div class="py-4 px-8 border-t border-slate-100 bg-slate-50">{{ $reports->links() }}</div>
        @endif
    </div>

    <!-- Modals -->
    <div id="modal-details" class="modal-overlay z-[100]" onclick="if(event.target===this) closeModal('modal-details')">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 class="font-display font-bold text-lg text-slate-800">Report Details</h3>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5" id="detail-id"></p>
                </div>
                <button onclick="closeModal('modal-details')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="modal-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Reporter (Family)</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-family"></p>
                    </div>
                    <div class="p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Reported (Caregiver)</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-caregiver"></p>
                    </div>
                </div>
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl">
                    <h4 class="text-[10px] font-bold text-rose-500 uppercase tracking-wider mb-2">Complaint</h4>
                    <p class="text-sm font-bold text-rose-900 mb-2" id="detail-reason"></p>
                    <p class="text-xs text-rose-700/80 leading-relaxed italic" id="detail-comment"></p>
                </div>
            </div>
            <div class="modal-footer"><button onclick="closeModal('modal-details')" class="px-4 py-2 text-sm font-bold text-slate-500">Close</button></div>
        </div>
    </div>

    <div id="modal-resolve" class="modal-overlay z-[100]" onclick="if(event.target===this) closeModal('modal-resolve')">
        <div class="modal-content">
            <form id="form-resolve-report" method="POST" action="">
                @csrf @method('PATCH')
                <div class="modal-header">
                    <h3 class="font-display font-bold text-lg text-slate-800">Resolve Report</h3>
                    <button type="button" onclick="closeModal('modal-resolve')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="modal-body">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Resolution Decision</label>
                    <textarea name="admin_note" rows="4" placeholder="Findings or resolution details..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-white outline-none text-sm"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-resolve')" class="px-4 py-2 text-sm font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-emerald-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-emerald-500/30">Resolve Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Ban Modal -->
    <div id="modal-confirm" class="modal-overlay z-[110]" onclick="if(event.target===this) closeModal('modal-confirm')">
        <div class="modal-content max-w-sm">
            <form id="form-ban-employee" method="POST" action="">
                @csrf @method('PATCH')
                <div class="px-6 py-8 text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-rose-100 text-rose-500"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                    <h3 class="font-display font-bold text-xl text-slate-800 mb-2">Suspend Employee</h3>
                    <p class="text-sm text-slate-500" id="confirm-message"></p>
                </div>
                <div class="modal-footer justify-center bg-transparent border-t-0 pt-0 gap-3">
                    <button type="button" onclick="closeModal('modal-confirm')" class="px-4 py-2 text-sm font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-rose-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-rose-500/30">Yes, Suspend</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function viewReportDetails(reportId, family, caregiver, reason, comment) {
            document.getElementById('detail-id').textContent = `#RPT-${reportId}`;
            document.getElementById('detail-family').textContent = family;
            document.getElementById('detail-caregiver').textContent = caregiver;
            document.getElementById('detail-reason').textContent = reason;
            document.getElementById('detail-comment').textContent = comment || "No additional comments.";
            openModal('modal-details');
        }

        function openResolveModal(reportId) {
            document.getElementById('form-resolve-report').action = `/admin/reports/${reportId}/resolve`;
            openModal('modal-resolve');
        }

        function openConfirm(action, employeeUserId, name) {
            document.getElementById('confirm-message').textContent = `Are you sure you want to suspend ${name}? They will lose access to the platform.`;
            document.getElementById('form-ban-employee').action = `/admin/users/${employeeUserId}/toggle-status`;
            openModal('modal-confirm');
        }
    </script>
    @endpush
</x-layouts.admin>