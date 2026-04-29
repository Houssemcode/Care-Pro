<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'My Offers')
    <x-employee.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-employee.navbar :active="'offers'" />

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        <div class="flex flex-col md:flex-row justify-between mb-8 sm:mb-10 gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">My Active
                    Offers</h1>
                <p class="text-sm sm:text-base text-slate-500 font-medium">Manage and track your current caregiving
                    commitments.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="offers-grid">
            @foreach($offers as $offer)
                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <h3 class="font-bold text-lg">Offre #{{ $offer->id }}</h3>
                    <p>Service Type: {{ $offer->service_type }}</p>
                    <p>Address: {{ $offer->address }}</p>
                    <p>Working House: {{ $offer->working_house ? 'Yes' : 'No' }}</p>
                    <p>Address Service: {{ $offer->address_service }}</p>
                </div>
            @endforeach
        </div>

        <div id="empty-offers" class="hidden py-16 text-center w-full">
            <div
                class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <p class="text-slate-400 font-medium">No active offers yet. Accept a request to get started!</p>
        </div>
    </main>

    <script src="{{ asset('js/modules/employee-offers.js') }}"></script>
</body>

</html>