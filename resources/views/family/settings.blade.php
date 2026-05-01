<x-layouts.family active="settings">
    @section('title', 'Account Settings')

    <x-family.page-header 
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
            <div class="bg-white rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Profile Information</h3>
                    <p class="text-xs text-slate-500 font-medium">Update your account's profile information and contact details.</p>
                </div>
                
                <form action="{{ route('family.settings.info') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="e.g. 0555 12 34 56"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Wilaya <span class="text-rose-500">*</span></label>
                            <input type="text" name="wilaya" value="{{ Auth::user()->localization->wilaya ?? '' }}" placeholder="e.g., Alger" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                            @error('wilaya') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Commune <span class="text-rose-500">*</span></label>
                            <input type="text" name="commune" value="{{ Auth::user()->localization->commune ?? '' }}" placeholder="e.g., Bab El Oued" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                            @error('commune') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- GPS Coordinates Section --}}
                    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Home Location Coordinates <span class="text-rose-500">*</span></h4>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">Required so your caregiver can navigate to your home.</p>
                            </div>
                            <button type="button" onclick="getMyLocation()" id="geo-btn"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-xs transition-all shadow-md shadow-brand-500/20 active:scale-95 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span id="geo-btn-text">Get My Location</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Latitude</label>
                                <input type="number" step="any" name="latitude" id="input-latitude" value="{{ Auth::user()->localization->latitude ?? '' }}" placeholder="e.g., 36.7538" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-white outline-none text-sm font-medium transition-all">
                                @error('latitude') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Longitude</label>
                                <input type="number" step="any" name="logitude" id="input-logitude" value="{{ Auth::user()->localization->logitude ?? '' }}" placeholder="e.g., 3.0588" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-white outline-none text-sm font-medium transition-all">
                                @error('logitude') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium" id="geo-status"></p>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-slate-900/10 active:scale-95">Save Changes</button>
                    </div>
                </form>
            </div>

            {{-- Update Password Form --}}
            <div class="bg-white rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Update Password</h3>
                    <p class="text-xs text-slate-500 font-medium">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                
                <form action="{{ route('family.settings.password') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Current Password</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">New Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-slate-900/10 active:scale-95">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function getMyLocation() {
            const btn = document.getElementById('geo-btn');
            const btnText = document.getElementById('geo-btn-text');
            const status = document.getElementById('geo-status');
            const latInput = document.getElementById('input-latitude');
            const lngInput = document.getElementById('input-logitude');

            if (!navigator.geolocation) {
                status.textContent = '⚠ Geolocation is not supported by your browser.';
                status.className = 'text-[10px] text-rose-500 font-bold';
                return;
            }

            // Loading state
            btn.disabled = true;
            btnText.textContent = 'Locating...';
            btn.classList.add('opacity-70');
            status.textContent = 'Requesting your position...';
            status.className = 'text-[10px] text-amber-600 font-bold';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latInput.value = position.coords.latitude.toFixed(6);
                    lngInput.value = position.coords.longitude.toFixed(6);
                    status.textContent = '✓ Location detected successfully! Verify the coordinates and save.';
                    status.className = 'text-[10px] text-emerald-600 font-bold';
                    btnText.textContent = 'Get My Location';
                    btn.disabled = false;
                    btn.classList.remove('opacity-70');
                },
                (error) => {
                    let msg = 'Unable to retrieve your location.';
                    if (error.code === 1) msg = 'Location access denied. Please allow location access in your browser settings.';
                    if (error.code === 2) msg = 'Location unavailable. Please try again or enter coordinates manually.';
                    if (error.code === 3) msg = 'Location request timed out. Please try again.';
                    status.textContent = '⚠ ' + msg;
                    status.className = 'text-[10px] text-rose-500 font-bold';
                    btnText.textContent = 'Get My Location';
                    btn.disabled = false;
                    btn.classList.remove('opacity-70');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }
    </script>
    @endpush
</x-layouts.family>