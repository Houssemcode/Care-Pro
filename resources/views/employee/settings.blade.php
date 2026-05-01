<x-layouts.employee active="settings">
    @section('title', 'Account Settings')

    <x-employee.page-header 
        breadcrumb="Account" 
        title="Account Settings" 
        subtitle="Manage your personal information and security preferences." 
    />

    <div class="max-w-3xl">
        {{-- Notifications --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                
                <form action="{{ route('employee.settings.info') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="e.g. 0555 12 34 56"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Years of Experience</label>
                            <input type="text" name="experience" value="{{ Auth::user()->employee->experience ?? '' }}" placeholder="e.g. 5 Years"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Highest Diploma / Certification</label>
                        <input type="text" name="diploma" value="{{ Auth::user()->employee->diploma ?? '' }}" placeholder="e.g. Certified Nursing Assistant (CNA)"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Professional Summary</label>
                        <textarea name="description" rows="4" placeholder="Briefly describe your caregiving style, specialties, and background..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all resize-none">{{ Auth::user()->employee->description ?? '' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Wilaya</label>
                            <input type="text" name="wilaya" value="{{ Auth::user()->localization->wilaya ?? '' }}" placeholder="e.g., Alger"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Commune</label>
                            <input type="text" name="commune" value="{{ Auth::user()->localization->commune ?? '' }}" placeholder="e.g., Bab El Oued"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>
                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">Save Changes</button>
                    </div>
                </form>
            </div>

            {{-- Update Password Form --}}
            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Update Password</h3>
                    <p class="text-xs text-slate-500 font-medium">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                
                <form action="{{ route('employee.settings.password') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Current Password</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.employee>