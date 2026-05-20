<x-layouts.employee active="settings">
    @section('title', __('Account Settings'))

    <x-employee.page-header 
        breadcrumb="{{ __('Account') }}" 
        title="{{ __('Account Settings') }}" 
        subtitle="{{ __('Manage your personal information and security preferences.') }}" 
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
                    <h3 class="font-display font-bold text-lg text-slate-800">{{ __('Profile Information') }}</h3>
                    <p class="text-xs text-slate-500 font-medium">{{ __('Update your account\'s profile information and email address.') }}</p>
                </div>
                
                <form action="{{ route('employee.settings.info') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Full Name') }}</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Phone Number') }}</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="{{ __('e.g. 0555 12 34 56') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Years of Experience') }}</label>
                            <input type="text" name="experience" value="{{ Auth::user()->employee->experience ?? '' }}" placeholder="{{ __('e.g. 5 Years') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Highest Diploma / Certification') }}</label>
                        <input type="text" name="diploma" value="{{ Auth::user()->employee->diploma ?? '' }}" placeholder="{{ __('e.g. Certified Nursing Assistant (CNA)') }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Professional Summary') }}</label>
                        <textarea name="description" rows="4" placeholder="{{ __('Briefly describe your caregiving style, specialties, and background...') }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all resize-none">{{ Auth::user()->employee->description ?? '' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Wilaya') }}</label>
                            <input type="text" name="wilaya" value="{{ Auth::user()->localization?->wilaya ?? '' }}" placeholder="{{ __('e.g., Alger') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Commune') }}</label>
                            <input type="text" name="commune" value="{{ Auth::user()->localization?->commune ?? '' }}" placeholder="{{ __('e.g., Bab El Oued') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    {{-- GPS Coordinates Section --}}
                    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">{{ __('Your Location Coordinates') }}</h4>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ __('Helps families find you with the "Near Me" feature.') }}</p>
                            </div>
                            <button type="button" onclick="getMyLocation()" id="geo-btn"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-xs transition-all shadow-md shadow-brand-500/20 active:scale-95 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span id="geo-btn-text">{{ __('Get My Location') }}</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">{{ __('Latitude') }}</label>
                                <input type="number" step="any" name="latitude" id="input-latitude" value="{{ Auth::user()->localization?->latitude ?? '' }}" placeholder="e.g., 36.7538"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-white outline-none text-sm font-medium transition-all">
                                @error('latitude') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">{{ __('Longitude') }}</label>
                                <input type="number" step="any" name="logitude" id="input-logitude" value="{{ Auth::user()->localization?->logitude ?? '' }}" placeholder="e.g., 3.0588"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-white outline-none text-sm font-medium transition-all">
                                @error('logitude') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium" id="geo-status"></p>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>

            {{-- Update Password Form --}}
            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-display font-bold text-lg text-slate-800">{{ __('Update Password') }}</h3>
                    <p class="text-xs text-slate-500 font-medium">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                </div>
                
                <form action="{{ route('employee.settings.password') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Current Password') }}</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('New Password') }}</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">{{ __('Update Password') }}</button>
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
            btnText.textContent = '{{ __("Locating...") }}';
            btn.classList.add('opacity-70');
            status.textContent = '{{ __("Requesting your position...") }}';
            status.className = 'text-[10px] text-amber-600 font-bold';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latInput.value = position.coords.latitude.toFixed(6);
                    lngInput.value = position.coords.longitude.toFixed(6);
                    status.textContent = '✓ {{ __("Location detected successfully! Verify the coordinates and save.") }}';
                    status.className = 'text-[10px] text-emerald-600 font-bold';
                    btnText.textContent = '{{ __("Get My Location") }}';
                    btn.disabled = false;
                    btn.classList.remove('opacity-70');
                },
                (error) => {
                    let msg = '{{ __("Unable to retrieve your location.") }}';
                    if (error.code === 1) msg = '{{ __("Location access denied. Please allow location access in your browser settings.") }}';
                    if (error.code === 2) msg = '{{ __("Location unavailable. Please try again or enter coordinates manually.") }}';
                    if (error.code === 3) msg = '{{ __("Location request timed out. Please try again.") }}';
                    status.textContent = '⚠ ' + msg;
                    status.className = 'text-[10px] text-rose-500 font-bold';
                    btnText.textContent = '{{ __("Get My Location") }}';
                    btn.disabled = false;
                    btn.classList.remove('opacity-70');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }
    </script>
    @endpush
</x-layouts.employee>