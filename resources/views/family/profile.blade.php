<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'My Profile')
    <x-family.head />
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-family.navbar :active="'profile'" />

    <main class="flex-1 w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-2">Family Profile</h1>
            <p class="text-sm sm:text-base text-slate-500 font-medium">An overview of your client account and booking activity.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Left Column: ID Card --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-indigo-500 to-purple-700"></div>
                    
                    <div class="w-24 h-24 rounded-full bg-white p-1 relative z-10 mt-6 mb-4 shadow-lg">
                        <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center text-3xl font-bold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-display font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-slate-500 font-medium mb-4">{{ Auth::user()->email }}</p>
                    
                    <span class="inline-flex px-3 py-1 text-xs font-bold text-indigo-700 bg-indigo-50 rounded-lg ring-1 ring-inset ring-indigo-500/20 uppercase tracking-wider mb-6">
                        Family Client
                    </span>

                    <a href="{{ route('family.settings') }}" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all">
                        Edit Settings
                    </a>
                </div>
            </div>

            {{-- Right Column: Stats & Info --}}
            <div class="md:col-span-2 space-y-6">
                
                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Total Requests</p>
                            <h3 class="text-2xl font-display font-bold text-slate-900">{{ $totalRequests }}</h3>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Active Contracts</p>
                            <h3 class="text-2xl font-display font-bold text-slate-900">{{ $activeContracts }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Account Details --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                    <h3 class="font-display font-bold text-lg text-slate-800 mb-4">Account Details</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-slate-50">
                            <span class="text-sm font-medium text-slate-500">Member Since</span>
                            <span class="text-sm font-bold text-slate-800">{{ Auth::user()->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-slate-50">
                            <span class="text-sm font-medium text-slate-500">Phone</span>
                            <span class="text-sm font-bold text-slate-800">{{ Auth::user()->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-medium text-slate-500">Address</span>
                            <span class="text-sm font-bold text-slate-800 text-right">{{ Auth::user()->family->address ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>
</html>