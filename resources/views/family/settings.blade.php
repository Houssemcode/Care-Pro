<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'Account Settings')
    <x-family.head />
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-family.navbar :active="'settings'" />

    <main class="flex-1 w-full max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        <div class="mb-8 sm:mb-10">
            <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">Account Settings</h1>
            <p class="text-sm sm:text-base text-slate-500 font-medium">Manage your personal information and security preferences.</p>
        </div>

        {{-- Notifications --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="space-y-8">
            
            {{-- Profile Information Form --}}
            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Profile Information</h3>
                    <p class="text-xs text-slate-500 font-medium">Update your account's profile information and email address.</p>
                </div>
                
                <form action="{{ route('family.settings.info') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none transition-all text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none transition-all text-sm font-medium">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">Save Changes</button>
                    </div>
                </form>
            </div>

            {{-- Update Password Form --}}
            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Update Password</h3>
                    <p class="text-xs text-slate-500 font-medium">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                
                <form action="{{ route('family.settings.info') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none transition-all text-sm font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="e.g. 0555 12 34 56"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none transition-all text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Home Address</label>
                        <input type="text" name="address" value="{{ Auth::user()->family->address ?? '' }}" placeholder="Enter your full home address"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 outline-none transition-all text-sm font-medium">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>
</html>