<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Care Services | Premium Child & Elderly Care Platform</title>
    <meta name="description"
        content="Connecting loving families with qualified professionals to ensure the best possible care for your children and elderly relatives.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    <style type="text/tailwindcss">
        @layer utilities {
            .text-gradient {
                @apply bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500;
            }
        }

        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }

        /* Auth Toggle Custom Behaviors */
        #login-toggle.active, #register-toggle.active {
            background-color: white;
            color: #0d9488;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgba(59, 130, 246, 0.5);
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) rgba(15, 23, 42, 0.05);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }
        #login-toggle:not(.active), #register-toggle:not(.active) {
            background-color: transparent;
            color: #64748b;
            box-shadow: none;
        }

        @media screen and (max-width: 768px) {
            input, select, textarea { font-size: 16px !important; }
        }

        .blob-1 { animation: blobFloat 12s infinite ease-in-out; }
        .blob-2 { animation: blobFloat 14s infinite ease-in-out reverse; }
        @keyframes blobFloat {
            0% { transform: translateY(0) scale(1); }
            33% { transform: translateY(-30px) scale(1.1); }
            66% { transform: translateY(20px) scale(0.9); }
            100% { transform: translateY(0) scale(1); }
        }
    </style>
</head>

<body class="antialiased text-slate-800 overflow-x-hidden relative">

    <!-- Navigation Bar -->
    <nav class="fixed w-full z-40 top-0 transition-all duration-300 bg-white/80 backdrop-blur-xl border-b border-white/20 shadow-sm"
        id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                    <div
                        class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-display font-extrabold tracking-tight text-2xl text-slate-900">CareServices</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#features"
                        class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">How it
                        works</a>
                    <a href="#benefits"
                        class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Benefits</a>
                    <a href="#testimonials"
                        class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Reviews</a>
                    <button onclick="openAuthModal()"
                        class="ml-4 px-6 py-2.5 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm shadow-xl shadow-slate-900/20 transition-transform active:scale-95">
                        Log In / Sign Up
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button onclick="openAuthModal()"
                        class="px-5 py-2 rounded-full bg-brand-600 text-white font-bold text-sm shadow-md active:scale-95 transition-transform">
                        Portal
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden min-h-[90dvh] flex items-center">
        <!-- Floating Background Blobs -->
        <div
            class="absolute top-20 left-[-10%] w-[500px] h-[500px] rounded-full bg-brand-300/30 mix-blend-multiply filter blur-[80px] blob-1 pointer-events-none">
        </div>
        <div
            class="absolute bottom-20 right-[-10%] w-[600px] h-[600px] rounded-full bg-accent-300/30 mix-blend-multiply filter blur-[100px] blob-2 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-50 border border-brand-100 text-brand-700 font-bold text-xs uppercase tracking-widest mb-8 animate-fade-in">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                    </span>
                    Trusted by {{ number_format($stats['families_joined']) }}+ Families
                </div>

                <h1
                    class="text-5xl sm:text-6xl lg:text-7xl font-display font-black text-slate-900 tracking-tight leading-[1.1] mb-8">
                    Premium Care for the <br class="hidden sm:block" />
                    <span class="text-gradient">People You Love Most.</span>
                </h1>

                <p class="text-lg sm:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed font-medium">
                    The safest platform connecting families with {{ number_format($stats['verified_caregivers']) }} verified, highly-qualified childcare and elderly care
                    professionals across the country.
                </p>

                <!-- Quick Search Widget -->
                <div class="max-w-3xl mx-auto mb-12 p-2 bg-white rounded-3xl shadow-2xl border border-slate-100 flex flex-col md:flex-row gap-2">
                    <div class="flex-1 flex items-center px-4 gap-3 border-b md:border-b-0 md:border-r border-slate-100">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-1.998 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <input type="text" id="quick-wilaya" placeholder="Enter your Wilaya..." class="w-full py-3 outline-none text-sm font-medium text-slate-700 bg-transparent">
                    </div>
                    <div class="flex-1 flex items-center px-4 gap-3">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM4 12a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM4 18a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"></path></svg>
                        <select id="quick-service" class="w-full py-3 outline-none text-sm font-medium text-slate-700 bg-transparent cursor-pointer">
                            <option value="">Select Service</option>
                            <option value="Child Care">Child Care</option>
                            <option value="Elderly Care">Elderly Care</option>
                        </select>
                    </div>
                    <button onclick="executeQuickSearch()" class="px-8 py-3 rounded-2xl bg-brand-600 hover:bg-brand-500 text-white font-bold transition-all active:scale-95">
                        Search
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <button onclick="openAuthModal()"
                        class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-brand-600 hover:bg-brand-500 text-white font-bold text-lg shadow-xl shadow-brand-500/30 transition-transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                        Find a Caregiver
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                    <button onclick="openAuthModal()"
                        class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-lg shadow-lg border border-slate-100 transition-transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                        Apply to Work
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-slate-900 mb-4">Why Families Trust Us</h2>
                <p class="text-slate-500 font-medium">We built our platform around safety, transparency, and quality.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Feature 1 -->
                <div
                    class="p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow group">
                    <div
                        class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-slate-900 mb-3">100% Background Checked</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Every caregiver undergoes a rigorous identity
                        verification, criminal background check, and diploma validation process by our dedicated admins.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow group">
                    <div
                        class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-slate-900 mb-3">Instant Booking & Pricing</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Submit your care requirements and receive highly
                        accurate upfront pricing. No hidden fees, completely transparent hourly and daily rates.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow group">
                    <div
                        class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-slate-900 mb-3">Trusted Ratings</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">After every assignment, families rate their
                        caregiver. This drives a culture of excellence and helps you select only the best professionals.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section: Top Caregivers -->
    <section class="py-20 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-slate-900 mb-4">Our Top-Rated Professionals</h2>
                <p class="text-slate-500 font-medium">Meet some of the most trusted caregivers on our platform.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($topCaregivers as $caregiver)
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group text-center">
                    <div class="relative inline-block mb-4">
                        <div class="w-20 h-20 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-xl mx-auto border-4 border-white shadow-md">
                            {{ strtoupper(substr($caregiver->user->name, 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-amber-400 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                            ★ {{ $caregiver->avg_rating }}
                        </div>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-1">{{ $caregiver->user->name }}</h3>
                    <p class="text-xs text-slate-500 mb-4 capitalize">Verified Professional</p>
                    <button onclick="openAuthModal()" class="w-full py-2 bg-slate-50 hover:bg-brand-50 text-slate-600 hover:text-brand-600 rounded-xl text-xs font-bold transition-colors">
                        View Profile
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <section class="py-24 bg-slate-900 border-t border-slate-800 text-center relative overflow-hidden">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-brand-600/20 rounded-full blur-[120px] pointer-events-none">
        </div>
        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <h2 class="text-4xl sm:text-5xl font-display font-black text-white mb-6">Ready to get started?</h2>
            <p class="text-slate-400 text-lg mb-10">Join thousands of families relying on us for peace of mind.</p>
            <button onclick="openAuthModal()"
                class="px-10 py-5 rounded-2xl bg-brand-500 hover:bg-brand-400 text-white font-bold text-xl shadow-xl shadow-brand-500/20 transition-transform active:scale-95">
                Create Free Account
            </button>
        </div>
    </section>


    <!-- ========================================== -->
    <!-- AUTHENTICATION MODAL (Keeping the logic in) -->
    <!-- ========================================== -->
    <div id="auth-modal"
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-md hidden flex items-center justify-center p-4 xl:p-0 opacity-0 transition-opacity duration-300">

        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden relative transform scale-95 transition-transform duration-300"
            id="auth-box">

            <!-- Close Button -->
            <button onclick="closeAuthModal()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-full p-2 transition-colors z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="p-6 sm:p-8 lg:p-10 pt-10">
                <!-- Welcome header -->
                <div class="text-center mb-6 sm:mb-8">
                    <div
                        class="w-12 h-12 bg-brand-50 rounded-xl mx-auto flex items-center justify-center text-brand-600 mb-4 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-800 mb-2">Welcome</h2>
                    <p class="text-slate-500 font-medium text-sm">Please login or create an account.</p>
                </div>

                <!-- Form Toggle Tabs (Targeted by auth.js) -->
                <div class="flex p-1 bg-slate-100 rounded-xl mb-6">
                    <button id="login-toggle"
                        class="active flex-1 py-2.5 text-sm font-semibold rounded-lg transition-all">Login</button>
                    <button id="register-toggle"
                        class="flex-1 py-2.5 text-sm font-semibold rounded-lg transition-all">Register</button>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.submit') }}" id="login-form" class="space-y-4 sm:space-y-5 block">
                    @csrf
                    <div class="space-y-1">
                        <label for="login-email" class="block text-sm font-semibold text-slate-700">Email</label>
                        <input type="email" name="email" id="login-email" placeholder="mail@example.com" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>
                    <div class="space-y-1">
                        <div class="flex justify-between items-center">
                            <label for="login-password"
                                class="block text-sm font-semibold text-slate-700">Password</label>
                            <a href="#"
                                class="text-xs font-semibold text-brand-600 hover:text-brand-500 transition-colors">Forgot
                                Pwd?</a>
                        </div>
                        <input type="password" name="password" id="login-password" placeholder="••••••••" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>
                    <button type="submit"
                        class="w-full py-3.5 bg-brand-600 hover:bg-brand-500 text-white rounded-xl font-bold text-base shadow-lg shadow-brand-500/20 active:scale-95 transition-transform mt-4">
                        Sign In
                    </button>
                </form>
            
                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-4 sm:space-y-5 hidden">
                    @csrf
                    <div class="space-y-1">
                        <label for="reg-name" class="block text-sm font-semibold text-slate-700">Full Name</label>
                        <input type="text" name="name" id="reg-name" placeholder="John Doe" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>
                    <div class="space-y-1">
                        <label for="reg-email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                        <input type="email" name="email" id="reg-email" placeholder="example@domain.com" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>
                    <div class="space-y-1">
                        <label for="reg-password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <input type="password" name="password" id="reg-password" placeholder="••••••••" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none transition-all placeholder:text-slate-400 font-medium text-sm">
                    </div>

                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">I want to...</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer group relative">
                                <input type="radio" name="role" value="family" class="peer sr-only" checked>
                                <div
                                    class="p-3 text-center bg-white border-2 border-slate-200 rounded-xl peer-checked:border-brand-500 peer-checked:bg-brand-50 group-hover:bg-slate-50 transition-all flex flex-col items-center justify-center gap-0.5 h-full">
                                    <span class="font-bold text-slate-800 peer-checked:text-brand-700 text-sm">Look for
                                        care</span>
                                    <span class="text-[10px] font-semibold text-slate-500 uppercase">(Family)</span>
                                </div>
                            </label>
                            <label class="cursor-pointer group relative">
                                <input type="radio" name="role" value="employee" class="peer sr-only">
                                <div
                                    class="p-3 text-center bg-white border-2 border-slate-200 rounded-xl peer-checked:border-brand-500 peer-checked:bg-brand-50 group-hover:bg-slate-50 transition-all flex flex-col items-center justify-center gap-0.5 h-full">
                                    <span class="font-bold text-slate-800 peer-checked:text-brand-700 text-sm">Provide
                                        care</span>
                                    <span
                                        class="text-[10px] font-semibold text-slate-500 uppercase">(Professional)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-base shadow-xl shadow-slate-900/20 active:scale-95 transition-transform mt-4">
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/auth.js') }}"></script>
    <script>
        // Quick Search Logic
        function executeQuickSearch() {
            const wilaya = document.getElementById('quick-wilaya').value;
            const service = document.getElementById('quick-service').value;

            if (!wilaya && !service) {
                alert('Please enter a Wilaya or select a service.');
                return;
            }

            // Build the query string
            const params = new URLSearchParams();
            if (wilaya) params.append('wilaya', wilaya);
            if (service) params.append('service_type', service);

            // Redirect to browse page (Requires login, so it will redirect to login first)
            window.location.href = `/family/browse?${params.toString()}`;
        }

        // Modal Flow logic for Landing Page
        const authModal = document.getElementById('auth-modal');
        const authBox = document.getElementById('auth-box');

        function openAuthModal() {
            authModal.classList.remove('hidden');
            // Small trigger delay for smooth css transition
            setTimeout(() => {
                authModal.classList.remove('opacity-0');
                authBox.classList.remove('scale-95');
                authBox.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeAuthModal() {
            authModal.classList.add('opacity-0');
            authBox.classList.remove('scale-100');
            authBox.classList.add('scale-95');
            setTimeout(() => {
                authModal.classList.add('hidden');
            }, 300);
            document.body.style.overflow = 'auto'; // restore scroll
        }

        // Close on clicking backdrop
        authModal.addEventListener('click', (e) => {
            if (e.target === authModal) {
                closeAuthModal();
            }
        });

        // Open modal if URL is /login
        if (window.location.pathname === '/login') {
            openAuthModal();
        }
    </script>
</body>

</html>