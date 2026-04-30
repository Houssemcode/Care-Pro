<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'Create Service Offer')
    <x-employee.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-employee.navbar :active="'offers'" />

    <main class="flex-1 w-full max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">

        {{-- Page Header --}}
        <div class="mb-8">
            <a href="{{ route('employee.dashboard') }}" class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-700 transition mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-2">Create New Offer</h1>
            <p class="text-slate-500 font-medium text-sm sm:text-base">Define the details of the care services you provide so families can find and book you.</p>
        </div>

        {{-- Form Container --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
            <form action="{{ route('employee.offres.store') }}" method="POST" class="p-6 sm:p-10 space-y-8">
                @csrf

                <!-- Service Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Service Type <span class="text-rose-500">*</span></label>
                    <select name="service_type" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                        <option value="" disabled selected>Select the type of care you offer...</option>
                        <option value="Child Care">Child Care / Babysitting</option>
                        <option value="Elderly Care">Elderly Care</option>
                        <option value="Special Needs Care">Special Needs Care</option>
                        <option value="Nursing / Medical Care">Nursing / Medical Care</option>
                        <option value="Housekeeping">Housekeeping & Support</option>
                    </select>
                    @error('service_type') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Working House (Live-in / Live-out) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Work Arrangement <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-brand-500 hover:border-brand-300 hover:bg-brand-50 transition-colors">
                            <input type="radio" name="working_house" value="Live-out" class="peer sr-only" required>
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900 mb-1 peer-checked:text-brand-700">Live-out (Shift based)</span>
                                <span class="block text-xs text-slate-500">I will commute to the family's house for specific hours/shifts.</span>
                            </span>
                            <svg class="absolute right-4 top-4 h-6 w-6 text-brand-600 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-brand-500 pointer-events-none transition-colors"></span>
                        </label>
                        
                        <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-brand-500 hover:border-brand-300 hover:bg-brand-50 transition-colors">
                            <input type="radio" name="working_house" value="Live-in" class="peer sr-only">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900 mb-1 peer-checked:text-brand-700">Live-in (Full time)</span>
                                <span class="block text-xs text-slate-500">I am available to live at the family's residence.</span>
                            </span>
                            <svg class="absolute right-4 top-4 h-6 w-6 text-brand-600 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-brand-500 pointer-events-none transition-colors"></span>
                        </label>
                    </div>
                    @error('working_house') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Address Service (Target Areas) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Target Working Areas <span class="text-rose-500">*</span></label>
                    <input type="text" name="address_service" placeholder="e.g., Hydra, Ben Aknoun, El Biar" required
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    <p class="text-[10px] text-slate-500 mt-2 font-medium">List the neighborhoods or cities you are willing to travel to for work.</p>
                    @error('address_service') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Personal Base Address -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Your Base Address <span class="text-rose-500">*</span></label>
                    <input type="text" name="address" placeholder="e.g., 15 Rue Didouche Mourad, Algiers" required
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    @error('address') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('employee.dashboard') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm active:scale-95">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-500/30 active:scale-95">
                        Publish Offer
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script src="{{ asset('js/modules/employee.js') }}"></script>
</body>

</html>