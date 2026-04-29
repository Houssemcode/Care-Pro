<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Login | Care Services</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>

    <style type="text/tailwindcss">
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <!-- Subtle background pattern -->
    <div class="fixed inset-0 opacity-[0.015]"
        style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23000&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.08)] overflow-hidden border border-slate-100">
            <div class="p-8 sm:p-10">
                <!-- Logo & Title -->
                <div class="text-center mb-8">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl mx-auto flex items-center justify-center text-white mb-5 shadow-lg shadow-slate-900/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-display font-extrabold text-slate-900 mb-1">Admin Hub</h1>
                    <p class="text-sm font-medium text-slate-500">Sign in to manage the platform.</p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('admin.dashboard') }}" method="GET" class="space-y-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-slate-700">Email Address</label>
                        <input type="email" placeholder="admin@careservices.com" required
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-semibold text-slate-700">Password</label>
                            <a href="{{ route('admin.forgot-password') }}"
                                class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">Forgot
                                Password?</a>
                        </div>
                        <input type="password" placeholder="••••••••" required
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <div class="flex items-center gap-2 pt-1 pb-2">
                        <input type="checkbox" id="remember"
                            class="w-4 h-4 rounded appearance-none border border-slate-300 checked:bg-slate-900 checked:border-slate-900 cursor-pointer transition-colors relative after:content-[''] after:absolute after:hidden checked:after:block after:w-1.5 after:h-2.5 after:border-r-2 after:border-b-2 after:border-white after:left-[5px] after:top-[2px] after:rotate-45">
                        <label for="remember" class="text-sm font-medium text-slate-600 cursor-pointer">Remember
                            me</label>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-base shadow-xl shadow-slate-900/20 active:scale-[0.98] transition-all">
                        Secure Sign In
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm font-medium text-slate-500">Need an account? <a
                            href="{{ route('admin.register') }}"
                            class="text-slate-900 font-bold hover:underline">Register super admin</a></p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-400 mt-6 font-medium">Care Services Platform &copy; 2025</p>
    </div>

</body>

</html>