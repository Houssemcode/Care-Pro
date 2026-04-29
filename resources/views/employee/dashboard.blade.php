<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'Pending Requests')
    @include('partials.employee-head')
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    @include('partials.employee-navbar', ['active' => 'dashboard'])

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">

        {{-- Page Header --}}
        <div class="flex flex-col lg:flex-row justify-between lg:items-end gap-4 sm:gap-6 mb-8 sm:mb-10 lg:pr-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">Pending
                    Requests</h1>
                <p class="text-sm sm:text-base text-slate-500 font-medium">Review and manage incoming care requests from
                    families.</p>
            </div>
            <div
                class="flex items-center gap-3 sm:gap-4 bg-white px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl shadow-sm border border-slate-100 w-fit self-start lg:self-auto">
                <div class="flex flex-col items-end">
                    <span class="text-xs sm:text-sm font-bold text-slate-800">Caregiver Account</span>
                    <span
                        class="text-[10px] sm:text-xs font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md mt-0.5">Available</span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-slate-100 border-2 border-white shadow-[0_2px_10px_rgba(0,0,0,0.1)] flex items-center justify-center font-bold text-slate-600 bg-cover bg-center"
                    style="background-image: url('https://i.pravatar.cc/150?img=12');"></div>
            </div>
        </div>

        {{-- Requests Table --}}
        <div
            class="bg-white rounded-2xl sm:rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden w-full">
            <div class="overflow-x-auto custom-scrollbar w-full">
                <table class="requests-table w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr>
                            <th
                                class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Family Profile</th>
                            <th
                                class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Service Type</th>
                            <th
                                class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Date Range</th>
                            <th
                                class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Location</th>
                            <th
                                class="bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="requests-list"></tbody>
                </table>
            </div>
            <div id="empty-msg"
                class="hidden py-10 sm:py-16 text-center text-slate-400 font-medium border-t border-slate-50 text-sm sm:text-base">
                <div
                    class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                </div>
                No pending requests at the moment.
            </div>
        </div>
    </main>

    {{-- FAB --}}
    <button
        class="fixed md:bottom-10 md:right-10 bottom-[90px] right-4 sm:right-6 w-14 h-14 sm:w-16 sm:h-16 bg-slate-900 text-white rounded-full flex items-center justify-center shadow-xl shadow-slate-900/30 hover:scale-110 active:scale-95 transition-transform z-50 group"
        id="fab-create-offer" title="Create New Offer">
        <svg class="w-6 h-6 sm:w-8 sm:h-8 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
    </button>

    <script src="{{ asset('js/modules/employee.js') }}"></script>
</body>

</html>