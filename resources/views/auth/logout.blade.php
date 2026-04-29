<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'Logging Out')
    @include('partials.employee-head')
</head>
<body class="bg-[#f4f7f9] min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-xl p-8 sm:p-12 max-w-sm w-full text-center border border-slate-100 page-enter">
        <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h1 class="text-2xl font-display font-bold text-slate-900 mb-2">See You Soon!</h1>
        <p class="text-sm text-slate-500 font-medium mb-8">You have been securely logged out of your caregiver account.</p>
        <a href="{{ route('home') }}" class="block w-full py-3.5 btn-primary text-center">Back to Home</a>
        <a href="{{ route('employee.dashboard') }}" class="block mt-3 text-sm font-semibold text-slate-500 hover:text-brand-600 transition-colors">Sign in again →</a>
    </div>
</body>
</html>
