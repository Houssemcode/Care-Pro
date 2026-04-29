<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Set New Password | Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    <style type="text/tailwindcss">
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="fixed inset-0 opacity-[0.015]"
        style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23000&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
    </div>

    <div class="w-full max-w-sm relative z-10">
        <div class="bg-white rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.08)] overflow-hidden border border-slate-100">
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <div
                        class="w-14 h-14 bg-emerald-50 rounded-2xl mx-auto flex items-center justify-center text-emerald-500 mb-5 shadow-sm border border-emerald-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-display font-extrabold text-slate-900 mb-1">Set New Access</h1>
                    <p class="text-sm font-medium text-slate-500">Provide a new password for your admin account.</p>
                </div>

                <form action="{{ route('admin.login') }}" method="GET" class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-slate-700">New Password</label>
                        <input type="password" placeholder="••••••••" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                        <input type="password" placeholder="••••••••" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <button type="submit"
                        class="w-full mt-4 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-base shadow-lg shadow-slate-900/20 active:scale-[0.98] transition-all">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6 font-medium">Care Services Platform &copy; 2025</p>
    </div>

</body>

</html>