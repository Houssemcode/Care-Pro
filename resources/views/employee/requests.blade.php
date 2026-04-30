<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'My Care Requests')
    <x-employee.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-employee.navbar :active="'dashboard'" />

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">

        {{-- Page Header --}}
        <div class="flex flex-col lg:flex-row justify-between lg:items-end gap-4 sm:gap-6 mb-6 sm:mb-8 lg:pr-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">Care Requests</h1>
                <p class="text-sm sm:text-base text-slate-500 font-medium">Review and manage incoming care requests from families.</p>
            </div>
        </div>

        {{-- Notifications --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium">
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
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <!-- Status Dropdown -->
                    <div>
                        <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
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
                <table class="requests-table w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr>
                            <th class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Request ID</th>
                            <th class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Family Profile</th>
                            <th class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Service Type</th>
                            <th class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Date Range</th>
                            <th class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 text-right whitespace-nowrap">
                                Actions/Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $req)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50">
                                    <span class="font-bold text-sm text-slate-800">#REQ-{{ $req->id }}</span>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50">
                                    <div class="font-bold text-sm text-slate-800">{{ $req->family->user->name ?? 'Unknown' }}</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $req->family->address ?? 'Location not provided' }}</div>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50">
                                    <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-lg ring-1 ring-inset ring-brand-500/20">
                                        {{ $req->offre->service_type ?? 'Service Offre' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50 text-sm text-slate-600 font-medium">
                                    <div class="flex flex-col gap-0.5">
                                        <span><strong class="text-slate-400 text-xs uppercase mr-1">From</strong> {{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</span>
                                        <span><strong class="text-slate-400 text-xs uppercase mr-1">To</strong> {{ \Carbon\Carbon::parse($req->end_date)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 sm:px-6 border-b border-slate-50 text-right">
                                    @if($req->status === 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Reject Form -->
                                            <form method="POST" action="{{ route('employee.requests.reject', $req->id) }}" onsubmit="return confirm('Are you sure you want to decline this request?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 font-bold rounded-lg text-xs transition-all active:scale-95 shadow-sm">
                                                    Decline
                                                </button>
                                            </form>
                                            <!-- Accept Form -->
                                            <form method="POST" action="{{ route('employee.requests.accept', $req->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg text-xs transition-all active:scale-95 shadow-sm shadow-emerald-500/20">
                                                    Accept Request
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($req->status === 'assigned')
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20 uppercase tracking-wider">
                                            Accepted
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-rose-700 bg-rose-50 rounded-lg ring-1 ring-inset ring-rose-500/20 uppercase tracking-wider">
                                            Declined
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="py-10 sm:py-16 text-center text-slate-400 font-medium text-sm sm:text-base">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
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
    </main>

    {{-- FAB --}}
    <button onclick="window.location.href='{{ route('employee.offres.create') }}'"
        class="fixed md:bottom-10 md:right-10 bottom-[90px] right-4 sm:right-6 w-14 h-14 sm:w-16 sm:h-16 bg-slate-900 text-white rounded-full flex items-center justify-center shadow-xl shadow-slate-900/30 hover:scale-110 active:scale-95 transition-transform z-50 group"
        title="Create New Offer">
        <svg class="w-6 h-6 sm:w-8 sm:h-8 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
    </button>

    <script src="{{ asset('js/modules/employee.js') }}"></script>
    <script>
        // Live Search Debounce
        let searchTimer;
        const searchInput = document.querySelector('input[name="search"]');
        const filterForm = document.getElementById('filter-form');

        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    filterForm.submit();
                }, 500); 
            });
        }
    </script>
</body>

</html>