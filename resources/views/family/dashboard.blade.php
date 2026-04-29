<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'Available Caregivers')
    @include('partials.family-head')
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    @include('partials.family-navbar', ['active' => 'dashboard'])

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center mb-8 sm:mb-10 gap-5">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 mb-1 sm:mb-2">Available Caregivers
                </h2>
                <p class="text-sm sm:text-base text-slate-500 font-medium">Find the perfect, verified match for your
                    loved ones.</p>
            </div>
            <button onclick="document.getElementById('request-modal').classList.add('active')"
                class="md:hidden w-full flex justify-center items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3.5 rounded-xl font-bold shadow-lg shadow-slate-900/20 active:scale-95 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Post a Request
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="offers-grid"></div>
    </main>

    {{-- Request Modal --}}
    <div class="modal-overlay" id="request-modal">
        <div class="modal-content">
            <button
                class="absolute top-4 right-4 sm:top-6 sm:right-6 text-slate-400 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 rounded-full p-2 transition-colors z-10"
                id="close-modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="mb-6 sm:mb-8 mt-2 sm:mt-0">
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mb-3 sm:mb-4 shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-display font-bold text-slate-900 mb-1">Post a Care Request</h3>
                <p class="text-slate-500 text-xs sm:text-sm font-medium">Tell us what you are looking for.</p>
            </div>
            <form class="space-y-4 sm:space-y-5" id="request-form">
                <div>
                    <label class="form-label">Care Type</label>
                    <div class="relative">
                        <select required class="form-input appearance-none cursor-pointer">
                            <option value="child">Child Care</option>
                            <option value="elderly">Elderly Care</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div><label class="form-label">Start Date</label><input type="date" required class="form-input">
                    </div>
                    <div><label class="form-label">End Date</label><input type="date" required class="form-input"></div>
                </div>
                <div>
                    <label class="form-label">Location / Address</label>
                    <input type="text" placeholder="City, Commune..." required class="form-input">
                </div>
                <button type="submit" class="w-full mt-2 py-3.5 sm:py-4 px-6 btn-primary text-center">Submit
                    Request</button>
            </form>
        </div>
    </div>

    <script src="{{ resource_path('js/modules/family.js') }}"></script>
    <script>
        document.getElementById('request-modal').addEventListener('click', function (e) { if (e.target === this) this.classList.remove('active'); });
    </script>
</body>

</html>