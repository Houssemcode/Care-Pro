<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'My Bookings')
    @include('partials.family-head')
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    @include('partials.family-navbar', ['active' => 'requests'])

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        <div class="flex flex-col md:flex-row justify-between md:items-end mb-8 sm:mb-10 gap-4">
            <div>
                <h2 class="text-2xl sm:text-4xl font-display font-bold text-slate-900 mb-1 sm:mb-2">My Bookings &
                    Records</h2>
                <p class="text-sm sm:text-base text-slate-500 font-medium">Track assigned caregivers, prices, and give
                    ratings/reports.</p>
            </div>
            <a href="{{ route('family.dashboard') }}"
                class="md:hidden text-center bg-slate-100 hover:bg-slate-200 text-slate-800 py-3 rounded-xl font-bold text-sm transition-colors">Book
                a Caregiver</a>
        </div>

        <div class="space-y-4 sm:space-y-6" id="bookings-list">
            @foreach($requests as $req)
                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <h3 class="font-bold text-lg">Booking #{{ $req->id }}</h3>
                    <p>Start Date: {{ $req->start_date }}</p>
                    <p>End Date: {{ $req->end_date }}</p>
                </div>
            @endforeach
            @if($requests->isEmpty())
                <div class="py-16 text-center">
                    <div
                        class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <p class="text-slate-400 font-medium">No bookings yet. Start by requesting a caregiver!</p>
                </div>
            @endif
        </div>
    </main>

    <script src="{{ resource_path('js/modules/family-bookings.js') }}"></script>
</body>

</html>