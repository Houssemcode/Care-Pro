<x-layouts.employee active="offers">
    @section('title', 'Edit Service Offer')

    <x-employee.page-header 
        breadcrumb="Care Services" 
        title="Edit Service Offer" 
        subtitle="Update the details of your caregiving service. Note: You cannot edit offers that have active assignments." 
    />

    {{-- Form Container --}}
    <div class="max-w-3xl bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
        <form action="{{ route('employee.offres.update', $offre->id) }}" method="POST" class="p-6 sm:p-10 space-y-8">
            @csrf
            @method('PATCH')

            <!-- Service Type -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Service Type <span class="text-rose-500">*</span></label>
                <select name="service_type" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all font-medium text-sm appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                    <option value="Child Care" {{ $offre->service_type == 'Child Care' ? 'selected' : '' }}>Child Care / Babysitting</option>
                    <option value="Elderly Care" {{ $offre->service_type == 'Elderly Care' ? 'selected' : '' }}>Elderly Care</option>
                </select>
                @error('service_type') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <!-- Working House (Live-in / Live-out) -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Work Arrangement <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-brand-500 hover:border-brand-300 hover:bg-brand-50 transition-colors">
                        <input type="radio" name="working_house" value="0" class="peer sr-only" required {{ !$offre->working_house ? 'checked' : '' }}>
                        <span class="flex flex-col">
                            <span class="block text-sm font-bold text-slate-900 mb-1 peer-checked:text-brand-700">Live-out (Shift based)</span>
                            <span class="block text-xs text-slate-500">I will commute to the family's house for specific hours/shifts.</span>
                        </span>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-brand-600 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-brand-500 pointer-events-none transition-colors"></span>
                    </label>
                    
                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-brand-500 hover:border-brand-300 hover:bg-brand-50 transition-colors">
                        <input type="radio" name="working_house" value="1" class="peer sr-only" {{ $offre->working_house ? 'checked' : '' }}>
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

            <!-- Wilaya -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Wilaya <span class="text-rose-500">*</span></label>
                <input type="text" name="wilaya" value="{{ old('wilaya', $offre->wilaya) }}" placeholder="e.g., Alger, Oran, Constantine" required
                    class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-widest">The province where you provide your services.</p>
                @error('wilaya') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <!-- Commune -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Commune <span class="text-rose-500">*</span></label>
                <input type="text" name="commune" value="{{ old('commune', $offre->commune) }}" placeholder="e.g., Hydra, Ben Aknoun, El Biar" required
                    class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                @error('commune') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('employee.offers') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm active:scale-95">Cancel</a>
                <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-slate-900/10 active:scale-95">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="{{ asset('js/modules/employee.js') }}"></script>
    @endpush
</x-layouts.employee>
