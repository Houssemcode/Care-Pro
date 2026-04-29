<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'My Profile')
    <x-family.head />
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-family.navbar :active="'profile'" />

    <main class="flex-1 w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 page-enter">

        {{-- Profile Header --}}
        <div class="info-card mb-6 flex flex-col sm:flex-row items-center gap-6">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-display font-bold text-3xl shadow-lg shrink-0">FA</div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 mb-1">The Ahmed Family</h1>
                <p class="text-sm text-slate-500 font-medium mb-3">Premium Member • Joined Dec 2023</p>
                <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                    <span class="badge badge-resolved">Active</span>
                    <span class="badge badge-active">3 Bookings</span>
                </div>
            </div>
            <a href="{{ route('family.settings') }}" class="btn-secondary shrink-0">Edit Profile</a>
        </div>

        {{-- Info Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="info-card"><p class="label-text">Email</p><p class="value-text">ahmed.family@email.com</p></div>
            <div class="info-card"><p class="label-text">Phone</p><p class="value-text">+213 555 123 456</p></div>
            <div class="info-card"><p class="label-text">Address</p><p class="value-text">Hydra, Algiers, Algeria</p></div>
            <div class="info-card"><p class="label-text">Membership</p><p class="value-text">Premium Plan</p></div>
        </div>

        {{-- Booking History --}}
        <div class="info-card">
            <h2 class="font-display font-bold text-lg text-slate-800 mb-4">Recent Booking History</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 hover:bg-slate-100 transition-colors">
                    <div>
                        <p class="text-sm font-bold text-slate-700">Sarah Jenkins - Child Care</p>
                        <p class="text-xs text-slate-500">Jan 10 – Feb 10, 2024</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Completed</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 hover:bg-slate-100 transition-colors">
                    <div>
                        <p class="text-sm font-bold text-slate-700">Robert Miller - Elderly Care</p>
                        <p class="text-xs text-slate-500">Feb 15, 2024 – Ongoing</p>
                    </div>
                    <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md">Active</span>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
