<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>@yield('title', 'Family Dashboard') | CareServices</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@500;600;700&display=swap"
    rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="{{ asset('js/tailwind-config.js') }}"></script>
<script src="{{ asset('js/modules/core.js') }}"></script>

<style type="text/tailwindcss">
    body { font-family: 'Inter', sans-serif; }
    h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }

    /* ──── Scrollbar & Utilities ──── */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* ──── Content Cards ──── */
    .info-card { @apply bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-5 sm:p-6 transition-all duration-300 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)]; }
    .label-text { @apply text-xs font-bold text-slate-400 uppercase tracking-wider mb-1; }
    .value-text { @apply text-sm font-semibold text-slate-800; }

    /* ──── Offer Cards ──── */
    .offer-card { @apply bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:border-brand-200 flex flex-col gap-4 relative overflow-hidden; }

    /* ──── Modal ──── */
    .modal-overlay { @apply fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4 overflow-y-auto; }
    .modal-overlay.active { @apply opacity-100 visible; }
    .modal-content { @apply bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 sm:p-8 relative transform scale-95 transition-transform duration-300 translate-y-4 my-auto; }
    .modal-overlay.active .modal-content { @apply scale-100 translate-y-0; }

    /* ──── Forms ──── */
    .form-label { @apply block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2; }
    .form-input { @apply w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all duration-200 font-medium placeholder:text-slate-400; }
    .form-section { @apply bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-5 sm:p-6; }

    /* ──── Badges ──── */
    .badge { @apply inline-block px-2 sm:px-3 py-1 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-lg ring-1 ring-inset; }
    .badge-child { @apply bg-brand-50 text-brand-700 ring-brand-500/20; }
    .badge-elderly { @apply bg-accent-50 text-accent-700 ring-accent-500/20; }
    .badge-resolved { @apply bg-emerald-50 text-emerald-700 ring-emerald-500/20; }
    .badge-open { @apply bg-amber-50 text-amber-700 ring-amber-500/20; }
    .badge-active { @apply bg-brand-50 text-brand-700 ring-brand-500/20; }

    /* ──── Buttons ──── */
    .btn-primary { @apply bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-brand-500/20 transition-all active:scale-95 hover:-translate-y-0.5; }
    .btn-secondary { @apply bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-bold text-sm transition-colors; }
    .btn-danger { @apply bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 px-5 py-2.5 rounded-xl font-bold text-sm transition-colors; }
    .btn-dark { @apply w-full py-3 px-5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold tracking-wide shadow-lg shadow-slate-900/20 transition-transform transform hover:-translate-y-0.5 mt-2; }

    /* ──── Page Transitions ──── */
    .page-enter { animation: pageSlideIn 0.35s ease-out; }
    @keyframes pageSlideIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>
@stack('styles')