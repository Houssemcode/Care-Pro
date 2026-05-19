<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <x-admin.head />
    <title>@yield('title', __('Admin Hub')) | Care-Pro</title>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-[100dvh]">
    <div id="mobile-overlay"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden opacity-0 invisible transition-all duration-300"
        onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">
        <x-admin.navbar :active="$active ?? ''" />

        <!-- ════════════ MAIN CONTENT ════════════ -->
        <main class="flex-1 lg:ms-[270px] w-full p-4 sm:p-6 lg:p-10 xl:p-12 max-w-full overflow-x-hidden border-s border-slate-200 transition-all duration-300 ease-in-out">
            <x-admin.mobile-topbar :title="$title ?? __('Care-Pro Admin')" />
            
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
