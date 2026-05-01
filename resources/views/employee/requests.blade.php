<x-layouts.employee active="requests">
    @section('title', 'My Care Requests')

    @if(Auth::user()->employee->status === 'active')
        <x-employee.page-header 
            breadcrumb="Management" 
            title="Care Requests" 
            subtitle="Review and manage incoming care requests from families." 
        />

        {{-- Notifications --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters Section --}}
        <form action="{{ route('employee.requests') }}" method="GET" id="filter-form" class="mb-6">
            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Request ID or Family name..."
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <!-- Status Dropdown -->
                    <div>
                        <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                            <option value="">All Requests</option>
                            <option value="pending" {{ request('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Declined</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        {{-- Requests Table --}}
        <div class="bg-white rounded-2xl sm:rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden w-full">
            <div class="overflow-x-auto custom-scrollbar w-full">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-slate-50/80 backdrop-blur">
                            <th class="pb-3 pt-4 px-4 sm:px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 sticky top-0 whitespace-nowrap">Request ID</th>
                            <th class="pb-3 pt-4 px-4 sm:px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 sticky top-0 whitespace-nowrap">Family Profile</th>
                            <th class="pb-3 pt-4 px-4 sm:px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 sticky top-0 whitespace-nowrap">Service Type</th>
                            <th class="pb-3 pt-4 px-4 sm:px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 sticky top-0 whitespace-nowrap">Date Range</th>
                            <th class="pb-3 pt-4 px-4 sm:px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 sticky top-0 text-right whitespace-nowrap">Actions/Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $req)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50">
                                    <span class="font-bold text-sm text-slate-800">#REQ-{{ $req->id }}</span>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50">
                                    <a href="{{ route('employee.family.profile', $req->family->id) }}" class="group">
                                        <div class="font-bold text-sm text-slate-800 group-hover:text-brand-600 transition-colors flex items-center gap-1.5">
                                            {{ $req->family->user->name ?? 'Unknown' }}
                                            <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </div>
                                    </a>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <div class="text-[11px] text-slate-500 truncate max-w-[180px]">{{ $req->family->user->localization->commune ?? '' }}{{ $req->family->user->localization->wilaya ? ', ' . $req->family->user->localization->wilaya : '' }}</div>
                                        @if($req->family->user->localization && $req->family->user->localization->latitude && $req->family->user->localization->logitude)
                                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $req->family->user->localization->latitude }},{{ $req->family->user->localization->logitude }}" target="_blank" rel="noopener"
                                                class="inline-flex items-center gap-1 px-2 py-0.5 bg-brand-50 text-brand-700 rounded-md text-[10px] font-bold hover:bg-brand-100 transition-colors ring-1 ring-inset ring-brand-500/20 whitespace-nowrap" title="Get directions">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Navigate
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50">
                                    <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-lg ring-1 ring-inset ring-brand-500/20">
                                        {{ $req->offre->service_type ?? 'Service Offre' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50 text-sm text-slate-600 font-medium">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="whitespace-nowrap"><strong class="text-[10px] font-bold text-slate-400 uppercase mr-1">From</strong> {{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</span>
                                        <span class="whitespace-nowrap"><strong class="text-[10px] font-bold text-slate-400 uppercase mr-1">To</strong> {{ \Carbon\Carbon::parse($req->end_date)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50 text-right">
                                    @if($req->status === 'pending')
                                        <div class="flex flex-col sm:flex-row items-center justify-end gap-2">
                                            <button onclick="openDiscussionModal({{ $req->id }}, {{ $req->messages->toJson() }})" class="w-full sm:w-auto px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-600 font-bold rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                Discussion
                                            </button>
                                            <form action="{{ route('employee.requests.reject', $req->id) }}" method="POST" class="w-full sm:w-auto">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full px-4 py-2 bg-white border border-slate-200 hover:bg-rose-50 text-rose-600 font-bold rounded-xl text-sm transition-all shadow-sm">Decline</button>
                                            </form>
                                            <form action="{{ route('employee.requests.accept', $req->id) }}" method="POST" class="flex items-center gap-2 w-full sm:w-auto">
                                                @csrf
                                                @method('PATCH')
                                                <div class="relative flex-1 sm:w-24">
                                                    <input type="number" name="price" required placeholder="Price" min="0" step="0.01" class="w-full pl-3 pr-8 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-white outline-none text-sm font-medium transition-all">
                                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-400 uppercase">DA</span>
                                                </div>
                                                <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95 whitespace-nowrap">Accept</button>
                                            </form>
                                        </div>
                                    @elseif($req->status === 'assigned')
                                        <span class="inline-flex px-3 py-1.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20 uppercase tracking-wider">Accepted</span>
                                    @else
                                        <span class="inline-flex px-3 py-1.5 text-[10px] font-bold text-rose-700 bg-rose-50 rounded-lg ring-1 ring-inset ring-rose-500/20 uppercase tracking-wider">Declined</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="py-16 text-center text-slate-400 font-medium text-sm">
                                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        No matching requests found.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($requests->hasPages())
                <div class="py-4 px-6 border-t border-slate-100 bg-slate-50">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>

        {{-- Discussion Modal --}}
        <div id="modal-discussion" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeDiscussionModal()">
            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden h-[600px]" id="modal-discussion-content">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Price Discussion</h3>
                    <button type="button" onclick="closeDiscussionModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/30 custom-scrollbar" id="message-container"></div>

                <form id="message-form" method="POST" action="" class="p-5 border-t border-slate-100 bg-white">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="message" required placeholder="Type your message..." class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        <button type="submit" class="px-5 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">Send</button>
                    </div>
                </form>
            </div>
        </div>

        @push('scripts')
        <script src="{{ asset('js/modules/employee.js') }}"></script>
        <script>
            let searchTimer;
            const searchInput = document.querySelector('input[name="search"]');
            const filterForm = document.getElementById('filter-form');

            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => { filterForm.submit(); }, 500); 
                });
            }

            const discussionModal = document.getElementById('modal-discussion');
            const discussionModalContent = document.getElementById('modal-discussion-content');
            const messageContainer = document.getElementById('message-container');
            const messageForm = document.getElementById('message-form');

            function openDiscussionModal(requestId, messages) {
                messageForm.action = `/employee/requests/${requestId}/messages`;
                messageContainer.innerHTML = '';

                if (messages.length === 0) {
                    messageContainer.innerHTML = '<div class="text-center py-10 text-slate-400 text-sm">No messages yet. Start the discussion!</div>';
                } else {
                    messages.forEach(msg => {
                        const isMe = msg.user_id === {{ Auth::id() }};
                        const div = document.createElement('div');
                        div.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;
                        div.innerHTML = `
                            <div class="max-w-[85%] rounded-2xl px-4 py-3 text-sm ${isMe ? 'bg-brand-600 text-white rounded-tr-none' : 'bg-white border border-slate-200 text-slate-700 rounded-tl-none shadow-sm'}">
                                <p class="font-medium leading-relaxed">${msg.message}</p>
                                <span class="text-[10px] mt-1 block opacity-70 text-right font-bold uppercase tracking-wider">${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                            </div>
                        `;
                        messageContainer.appendChild(div);
                    });
                }

                discussionModal.classList.remove('invisible', 'opacity-0');
                setTimeout(() => {
                    discussionModalContent.classList.remove('scale-95', 'opacity-0');
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                }, 50);
            }

            function closeDiscussionModal() {
                discussionModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => discussionModal.classList.add('invisible', 'opacity-0'), 200);
            }
        </script>
        @endpush
    @else
        <div class="mb-8 p-6 rounded-[2rem] bg-amber-50 border border-amber-200 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-amber-800 font-display">Account Pending Approval</h3>
                <p class="text-sm text-amber-700 mt-1 leading-relaxed">Your account is currently under review by our administration team. You will not appear in search results or receive booking requests until your account is activated.</p>
            </div>
        </div>
    @endif
</x-layouts.employee>