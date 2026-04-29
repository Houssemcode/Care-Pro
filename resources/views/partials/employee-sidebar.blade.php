{{-- Employee Sidebar – @include('partials.employee-sidebar', ['active' => 'dashboard']) --}}
<aside class="w-full md:w-[280px] bg-white border-t md:border-t-0 md:border-r border-slate-200 flex flex-col fixed md:sticky bottom-0 md:top-0 z-40 h-[72px] sm:h-20 md:h-[100dvh] md:pb-6 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] md:shadow-none pb-safe">
    {{-- Brand Logo (Desktop only) --}}
    <div class="hidden md:flex p-6 lg:p-8 items-center gap-3">
        <div class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center text-white shadow-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <span class="font-display font-bold tracking-tight text-xl text-slate-900">CarePro</span>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 w-full px-2 sm:px-4 py-1.5 sm:py-2 flex flex-row md:flex-col justify-between md:justify-start overflow-x-auto md:overflow-y-auto no-scrollbar">
        <a href="{{ route('employee.dashboard') }}" class="nav-item group {{ ($active ?? '') == 'dashboard' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="text-[10px] sm:text-xs md:text-sm mt-0.5 md:mt-0 font-bold md:font-semibold whitespace-nowrap">Requests</span>
        </a>
        <a href="{{ route('employee.offers') }}" class="nav-item group {{ ($active ?? '') == 'offers' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <span class="text-[10px] sm:text-xs md:text-sm mt-0.5 md:mt-0 font-bold md:font-semibold">Offers</span>
        </a>
        <a href="{{ route('employee.reports') }}" class="nav-item group hidden sm:flex {{ ($active ?? '') == 'reports' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="text-[10px] sm:text-xs md:text-sm mt-0.5 md:mt-0 font-bold md:font-semibold">Reports</span>
        </a>
        <a href="{{ route('employee.profile') }}" class="nav-item group {{ ($active ?? '') == 'profile' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-[10px] sm:text-xs md:text-sm mt-0.5 md:mt-0 font-bold md:font-semibold">Profile</span>
        </a>

        {{-- Bottom Actions (Desktop only) --}}
        <div class="mt-auto hidden md:block pt-4 border-t border-slate-100">
            <a href="{{ route('employee.settings') }}" class="nav-item group {{ ($active ?? '') == 'settings' ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="text-[10px] sm:text-xs md:text-sm mt-0.5 md:mt-0 font-bold md:font-semibold">Settings</span>
            </a>
            <a href="{{ route('employee.logout') }}" class="nav-item group !text-rose-500 hover:!bg-rose-50 hover:!text-rose-600">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="text-[10px] sm:text-xs md:text-sm mt-0.5 md:mt-0 font-bold md:font-semibold">Logout</span>
            </a>
        </div>
    </nav>
</aside>
