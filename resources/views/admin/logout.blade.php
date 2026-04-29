<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logout | Care Services</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Outfit:wght@700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    <meta http-equiv="refresh" content="3;url={{ route('admin.login') }}" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Outfit', sans-serif;
        }

        @keyframes countdown {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>
</head>

<body class="bg-slate-900 text-white min-h-screen flex flex-col items-center justify-center">
    <div class="text-center px-6">
        <div
            class="w-16 h-16 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                </path>
            </svg>
        </div>
        <h1 class="text-3xl font-display font-extrabold mb-2">Securely Logged Out</h1>
        <p class="text-slate-400 text-sm mb-8">You are being redirected to the login page...</p>

        <!-- Progress bar -->
        <div class="w-48 h-1 bg-slate-800 rounded-full mx-auto overflow-hidden">
            <div class="h-full bg-emerald-500/50 rounded-full" style="animation: countdown 3s linear forwards"></div>
        </div>
    </div>
</body>

</html>