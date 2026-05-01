<x-layouts.admin active="requests" title="Manage Requests">
    @section('title', 'Manage Requests')

    <x-admin.page-header 
        breadcrumb="Requests" 
        title="Booking Requests" 
        subtitle="Monitor, approve, and finalize prices for bookings." 
    />

    <!-- Filters Section -->
    <form action="{{ route('admin.requests') }}" method="GET" id="filter-form" class="mb-6">
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
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <!-- Requests Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
        <div class="overflow-x-auto custom-scrollbar flex-1 w-full relative min-h-[400px]">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Request ID</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Family</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Requested Offre</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($requests as $req)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-4">
                                <span class="font-bold text-slate-700">#REQ-{{ $req->id }}</span><br>
                                <span class="text-slate-400 text-[10px]">Start: {{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</span>
                            </td>
                            <td class="px-8 py-4">
                                <div class="font-semibold text-slate-900">{{ $req->family->user->name ?? 'Unknown Family' }}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <div class="text-[10px] text-slate-500 font-medium truncate max-w-[150px]">{{ $req->family->user->localization->commune ?? '' }}{{ $req->family->user->localization->wilaya ? ', ' . $req->family->user->localization->wilaya : 'No Location' }}</div>
                                    @if($req->family->user->localization && $req->family->user->localization->latitude && $req->family->user->localization->logitude)
                                        <a href="https://www.google.com/maps?q={{ $req->family->user->localization->latitude }},{{ $req->family->user->localization->logitude }}" target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-brand-50 text-brand-700 rounded text-[10px] font-bold hover:bg-brand-100 transition-colors ring-1 ring-inset ring-brand-500/20" title="View on map">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Map
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <div class="font-semibold text-brand-600">{{ $req->offre->service_type ?? 'Service Offre' }}</div>
                                <div class="text-[10px] text-slate-500 font-medium">Caregiver: {{ $req->offre->employee->user->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="inline-flex px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider ring-1 ring-inset {{ $req->status === 'pending' ? 'bg-amber-50 text-amber-700 ring-amber-500/20' : ($req->status === 'assigned' ? 'bg-emerald-50 text-emerald-700 ring-emerald-500/20' : 'bg-rose-50 text-rose-700 ring-rose-500/20') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($req->status === 'pending')
                                        <button class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold rounded-lg text-xs transition-all border border-brand-100 active:scale-95" title="Approve & Set Price"
                                            onclick="openAssignModal(
                                                {{ $req->id }}, 
                                                '{{ addslashes($req->family->user->name ?? 'Family') }}',
                                                '{{ addslashes($req->offre->employee->user->name ?? 'Caregiver') }}'
                                            )">
                                            Set Price
                                        </button>
                                    @endif
                                    <button class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition-all active:scale-95" title="View Details"
                                        onclick="viewRequestDetails(
                                            '{{ $req->id }}', 
                                            '{{ addslashes($req->offre->service_type ?? 'Service') }}', 
                                            '{{ addslashes($req->offre->working_house ?? 'N/A') }}', 
                                            '{{ $req->status }}',
                                            '{{ $req->offre->employee->user->name ?? '' }}'
                                        )">
                                        Details
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-slate-400 italic text-sm">No booking requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
        <div class="py-4 px-8 border-t border-slate-100 bg-slate-50">{{ $requests->links() }}</div>
        @endif
    </div>

    <!-- Modals -->
    <div id="modal-assign" class="modal-overlay z-[100]" onclick="if(event.target===this) closeModal('modal-assign')">
        <div class="modal-content">
            <form id="form-assign-caregiver" method="POST" action="">
                @csrf @method('PATCH')
                <div class="modal-header">
                    <div>
                        <h3 class="font-display font-bold text-lg text-slate-800">Finalize Assignment</h3>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5" id="assign-req-title"></p>
                    </div>
                    <button type="button" onclick="closeModal('modal-assign')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="modal-body space-y-5">
                    <div class="bg-brand-50 border border-brand-100 p-4 rounded-xl">
                        <p class="text-[10px] font-bold text-brand-600 uppercase tracking-widest mb-1">Requested Caregiver</p>
                        <p class="text-sm font-bold text-brand-900" id="assign-caregiver-name"></p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Final Price (DZD)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-brand-500 font-bold text-xs">DA</div>
                            <input type="number" name="price" required min="0" placeholder="0.00" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-white outline-none font-bold text-slate-800 text-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-assign')" class="px-4 py-2 text-sm font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-brand-500/30">Confirm & Assign</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-details" class="modal-overlay z-[100]" onclick="if(event.target===this) closeModal('modal-details')">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="font-display font-bold text-lg text-slate-800">Request Details</h3>
                <button onclick="closeModal('modal-details')" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="modal-body space-y-4">
                <div class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Request ID</span>
                    <span class="font-bold text-brand-600 text-sm" id="detail-req-id"></span>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Service Type</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-req-service"></p>
                    </div>
                    <div class="p-4 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Location</h4>
                        <p class="text-sm font-bold text-slate-800" id="detail-req-location"></p>
                    </div>
                </div>
                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm" id="detail-contract" style="display: none;">
                    <h4 class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-2">Active Contract</h4>
                    <p class="text-xs font-medium text-emerald-800">Assigned To: <span class="font-bold" id="detail-contract-emp"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <form id="form-reject-request" method="POST" action="" class="mr-auto" onsubmit="return confirm('Reject this request?');">
                    @csrf @method('PATCH')
                    <button type="submit" class="px-4 py-2 text-rose-600 hover:bg-rose-50 font-bold rounded-xl text-xs transition-all border border-transparent hover:border-rose-100" id="btn-reject-req">Reject Request</button>
                </form>
                <button onclick="closeModal('modal-details')" class="px-4 py-2 text-sm font-bold text-slate-500">Close</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openAssignModal(reqId, familyName, caregiverName) {
            document.getElementById('assign-req-title').textContent = `Request #${reqId} - ${familyName}`;
            document.getElementById('assign-caregiver-name').textContent = caregiverName;
            document.getElementById('form-assign-caregiver').action = `/admin/requests/${reqId}/assign`;
            openModal('modal-assign');
        }

        function viewRequestDetails(reqId, service, location, status, employeeName) {
            document.getElementById('detail-req-id').textContent = `#REQ-${reqId}`;
            document.getElementById('detail-req-service').textContent = service;
            document.getElementById('detail-req-location').textContent = location;
            document.getElementById('form-reject-request').action = `/admin/requests/${reqId}/reject`;
            document.getElementById('btn-reject-req').style.display = (status === 'pending') ? 'block' : 'none';
            const contractPanel = document.getElementById('detail-contract');
            if (status === 'assigned') {
                contractPanel.style.display = 'block';
                document.getElementById('detail-contract-emp').textContent = employeeName;
            } else { contractPanel.style.display = 'none'; }
            openModal('modal-details');
        }

        let searchTimer;
        const searchInput = document.querySelector('input[name="search"]');
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => { document.getElementById('filter-form').submit(); }, 500);
        });
    </script>
    @endpush
</x-layouts.admin>