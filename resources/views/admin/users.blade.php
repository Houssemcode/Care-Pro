<x-layouts.admin active="users" title="Users Directory">
    @section('title', 'Users Directory')

    <x-admin.page-header 
        breadcrumb="Directory" 
        title="All Users" 
        subtitle="Consult and manage all registered accounts." 
    />

    <!-- Filters Section -->
    <form action="{{ route('admin.users') }}" method="GET" id="filter-form" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or ID..."
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
            </div>

            <!-- Role Dropdown -->
            <div>
                <select name="role" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat">
                    <option value="">All Roles</option>
                    <option value="family" {{ request('role') == 'family' ? 'selected' : '' }}>Family (Client)</option>
                    <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee (Caregiver)</option>
                </select>
            </div>

            <!-- Status Dropdown -->
            <div>
                <select name="status" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col w-full">
        <div class="overflow-x-auto custom-scrollbar flex-1 w-full">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr>
                        <th class="bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap z-10">Acc ID</th>
                        <th class="bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap z-10">User Information</th>
                        <th class="bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap z-10">Role & Location</th>
                        <th class="bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap z-10">Joined</th>
                        <th class="bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap z-10">Status</th>
                        <th class="bg-slate-50/90 backdrop-blur sticky top-0 border-b border-slate-100 py-3.5 px-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap z-10 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($users as $user)
                        @php
                            $loc = $user->localization;
                            $location = $loc && $loc->commune ? "{$loc->commune}, {$loc->wilaya}" : ($user->employee ? 'Professional Caregiver' : 'Platform Member');
                            $displayStatus = 'active';
                            $badgeClass = 'bg-emerald-50 text-emerald-700 ring-emerald-500/20';
                            $icon = '🟢';

                            if ($user->employee) {
                                $displayStatus = $user->employee->status;
                                $statusMap = [
                                    'active'    => ['class' => 'bg-emerald-50 text-emerald-700 ring-emerald-500/20',    'icon' => '🟢'],
                                    'pending'   => ['class' => 'bg-amber-50 text-amber-700 ring-amber-500/20',   'icon' => '🟡'],
                                    'suspended' => ['class' => 'bg-rose-50 text-rose-700 ring-rose-500/20', 'icon' => '🔴'],
                                ];
                                $badgeClass = $statusMap[$displayStatus]['class'] ?? $badgeClass;
                                $icon = $statusMap[$displayStatus]['icon'] ?? $icon;
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-4"><span class="font-bold text-slate-500">#U-{{ $user->id }}</span></td>
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 group-hover:text-brand-600 transition-colors">{{ $user->name }}</div>
                                        <div class="text-[11px] text-slate-500 font-medium">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="inline-flex px-2 py-0.5 text-[10px] font-bold rounded ring-1 ring-inset {{ $user->role_badge['class'] }} mb-1">{{ $user->role_badge['name'] }}</span>
                                <div class="text-[11px] text-slate-500 font-medium">{{ $location }}</div>
                            </td>
                            <td class="px-8 py-4 text-sm font-medium text-slate-600">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-8 py-4">
                                <span class="inline-flex px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg ring-1 ring-inset items-center gap-1.5 whitespace-nowrap {{ $badgeClass }}">
                                    {{ $icon }} {{ ucfirst($displayStatus) }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-1.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-600 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95" title="View Profile" onclick="openModal('modal-profile-{{ $user->id }}')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    @if ($user->employee)
                                        @php
                                            $isSuspended = $user->employee->status === 'suspended';
                                            $actionType = $isSuspended ? 'restore' : 'suspend';
                                            $btnColor = $isSuspended ? 'emerald' : 'rose';
                                        @endphp
                                        <button class="p-1.5 bg-white border border-slate-200 font-bold rounded-lg text-xs transition-all shadow-sm active:scale-95 text-{{ $btnColor }}-500 hover:text-{{ $btnColor }}-600 hover:border-{{ $btnColor }}-200 hover:bg-{{ $btnColor }}-50" title="{{ ucfirst($actionType) }} User" onclick="openConfirm('{{ $actionType }}', {{ $user->id }}, '{{ addslashes($user->name) }}')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($isSuspended)
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                @endif
                                            </svg>
                                        </button>
                                    @endif
                                </div>

                                <!-- Profile Modal -->
                                <div id="modal-profile-{{ $user->id }}" class="modal-overlay text-left z-[100]" onclick="if(event.target===this) closeModal('modal-profile-{{ $user->id }}')">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="font-display font-bold text-lg text-slate-800">User Profile</h3>
                                            <button onclick="closeModal('modal-profile-{{ $user->id }}')" class="text-slate-400 hover:text-slate-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <div class="flex items-center gap-4 mb-6">
                                                <div class="w-16 h-16 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-xl">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                                <div>
                                                    <h4 class="font-bold text-xl text-slate-900">{{ $user->name }}</h4>
                                                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-bold rounded ring-1 ring-inset {{ $user->role_badge['class'] }} mt-2">{{ $user->role_badge['name'] }}</span>
                                                </div>
                                            </div>
                                            <div class="space-y-6">
                                                @if($user->employee)
                                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Professional Info</h5>
                                                    <div class="flex items-center justify-between py-2 border-b border-slate-100"><span class="text-sm font-medium text-slate-600">Diploma</span><span class="text-sm font-bold text-brand-600">{{ $user->employee->diploma ?? 'None' }}</span></div>
                                                    <div class="flex items-center justify-between py-2 border-b border-slate-100"><span class="text-sm font-medium text-slate-600">Experience</span><span class="text-sm font-bold text-slate-700">{{ $user->employee->experience ?? '0' }} Years</span></div>
                                                    <div class="pt-3"><p class="text-xs font-bold text-slate-400 mb-1 uppercase tracking-wider">Bio</p><p class="text-sm text-slate-600 leading-relaxed italic">{{ $user->employee->description ?? 'No description provided.' }}</p></div>
                                                </div>
                                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Documents</h5>
                                                    @forelse($user->employee->documents as $doc)
                                                        <div class="flex items-center justify-between p-4 bg-slate-900 rounded-xl mb-3 border border-slate-800"><span class="font-bold text-white capitalize text-sm">{{ str_replace('_', ' ', $doc->document_type) }}</span><a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-sm font-bold text-slate-300 hover:text-white transition-colors">View PDF</a></div>
                                                    @empty
                                                        <p class="text-xs text-slate-400 italic">No documents uploaded.</p>
                                                    @endforelse
                                                </div>
                                                @endif
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100"><p class="text-xs font-bold text-slate-400 mb-1">Phone</p><p class="text-sm font-semibold text-slate-700">{{ $user->phone ?? 'Not Provided' }}</p></div>
                                                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100"><p class="text-xs font-bold text-slate-400 mb-1">Location</p><p class="text-sm font-semibold text-slate-700 truncate" title="{{ $location }}">{{ $location }}</p></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button onclick="closeModal('modal-profile-{{ $user->id }}')" class="px-4 py-2 text-sm font-bold text-slate-500">Close</button>
                                            @if($user->employee && $user->employee->status === 'pending')
                                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="px-6 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm">Approve</button></form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="py-4 px-8 border-t border-slate-100 bg-slate-50">{{ $users->links() }}</div>
    </div>

    <!-- Confirm Action Modal -->
    <div id="modal-confirm" class="modal-overlay z-[110]" onclick="if(event.target===this) closeModal('modal-confirm')">
        <div class="modal-content max-w-sm">
            <div class="px-6 py-8 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" id="confirm-icon-bg">
                    <svg class="w-8 h-8" id="confirm-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
                </div>
                <h3 class="font-display font-bold text-xl text-slate-800 mb-2" id="confirm-title">Confirm Action</h3>
                <p class="text-sm text-slate-500" id="confirm-message">Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer justify-center bg-transparent border-t-0 pt-0 gap-3">
                <button onclick="closeModal('modal-confirm')" class="px-4 py-2 text-sm font-bold text-slate-500">Cancel</button>
                <button class="px-6 py-2 rounded-xl text-sm font-bold text-white transition-all shadow-lg active:scale-95" id="confirm-btn">Confirm</button>
            </div>
        </div>
    </div>

    <form id="action-form" method="POST" class="hidden">@csrf @method('PATCH')</form>

    @push('scripts')
    <script>
        function openConfirm(type, id, name) {
            document.getElementById('confirm-title').textContent = type === 'suspend' ? 'Suspend User' : 'Restore User';
            document.getElementById('confirm-message').textContent = type === 'suspend' ? `Are you sure you want to suspend ${name}?` : `Are you sure you want to restore ${name}?`;
            const btn = document.getElementById('confirm-btn');
            const iconBg = document.getElementById('confirm-icon-bg');
            const icon = document.getElementById('confirm-icon');

            if (type === 'suspend') {
                btn.className = 'px-6 py-2 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl text-sm shadow-rose-500/20';
                btn.textContent = 'Yes, Suspend';
                iconBg.className = 'w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-rose-100 text-rose-500';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
            } else {
                btn.className = 'px-6 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm shadow-emerald-500/20';
                btn.textContent = 'Yes, Restore';
                iconBg.className = 'w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-emerald-100 text-emerald-500';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            }

            btn.onclick = () => {
                const form = document.getElementById('action-form');
                form.action = `/admin/users/${id}/toggle-status`;
                form.submit();
            };
            openModal('modal-confirm');
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