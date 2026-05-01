<!DOCTYPE html>
<html lang="en">
<head>
    <x-employee.head />
    <title>@yield('title', 'Caregiver Dashboard') | Care-Pro</title>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">
    <x-employee.navbar :active="$active ?? ''" />

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>
