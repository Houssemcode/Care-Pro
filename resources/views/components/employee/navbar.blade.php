<nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200 shadow-sm w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex justify-between items-center">
        {{-- Brand --}}
        <a href="{{ route('employee.dashboard') }}" class="flex items-center gap-2 cursor-pointer group">
            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-brand-500 rounded-lg sm:rounded-xl flex items-center justify-center text-white shadow-md group-hover:bg-brand-600 transition-colors">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <span class="font-display font-bold tracking-tight text-xl sm:text-2xl text-slate-900">CarePro</span>
        </a>

        {{-- Navigation --}}
        <div class="flex items-center gap-3 sm:gap-6">
            <a href="{{ route('employee.dashboard') }}" class="hidden md:block text-sm transition-colors cursor-pointer {{ ($active ?? '') == 'dashboard' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Dashboard</a>
            <a href="{{ route('employee.requests') }}" class="hidden md:block text-sm transition-colors cursor-pointer {{ ($active ?? '') == 'requests' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Requests</a>
            <a href="{{ route('employee.offers') }}" class="hidden md:block text-sm transition-colors cursor-pointer {{ ($active ?? '') == 'offers' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Offers</a>
            <a href="{{ route('employee.reports') }}" class="hidden md:block text-sm transition-colors cursor-pointer {{ ($active ?? '') == 'reports' ? 'text-brand-600 font-bold border-b-2 border-brand-500 pb-1' : 'text-slate-500 hover:text-brand-600 font-semibold' }}">Reports</a>

            <div class="hidden lg:block h-8 w-px bg-slate-200 ml-2"></div>

            {{-- Account Dropdown --}}
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="flex items-center gap-2 sm:gap-3 cursor-pointer group hover:bg-slate-50 p-1 sm:p-1.5 sm:pr-4 rounded-full transition-colors border border-transparent hover:border-slate-200 outline-none">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 border-2 border-white shadow-sm flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0 {{ ($active ?? '') == 'profile' || ($active ?? '') == 'settings' ? 'ring-2 ring-brand-200' : '' }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="hidden sm:flex flex-col text-left">
                        <span class="text-sm font-semibold text-slate-800 leading-tight group-hover:text-brand-600 transition-colors whitespace-nowrap">{{ Auth::user()->name }}</span>
                        <span class="text-xs font-medium text-slate-500 flex items-center gap-1">
                            {{ Auth::user()->employee->diploma ?? 'Caregiver' }}
                            <svg class="w-3 h-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </div>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50"
                     style="display: none;">
                    
                    <a href="{{ route('employee.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        My Profile
                    </a>
                    
                    <a href="{{ route('employee.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </a>

                    <hr class="my-2 border-slate-100">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 transition-colors text-left">
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Bottom Nav --}}
    <div class="md:hidden border-t border-slate-100 bg-white px-2 py-1.5 flex justify-around">
        <a href="{{ route('employee.dashboard') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'dashboard' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('employee.requests') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'requests' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Requests
        </a>
        <a href="{{ route('employee.offers') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'offers' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Offers
        </a>
        <a href="{{ route('employee.profile') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-xl text-xs font-bold transition-colors {{ ($active ?? '') == 'profile' ? 'text-brand-600' : 'text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Profile
        </a>
    </div>
</nav>