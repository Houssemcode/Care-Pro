<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>@yield('title', 'Caregiver Dashboard') | CarePro</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="{{ asset('js/tailwind-config.js') }}"></script>
<script src="{{ asset('js/modules/core.js') }}"></script>

<style type="text/tailwindcss">
    body { font-family: 'Inter', sans-serif; }
    h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }

    /* ──── Sidebar Navigation ──── */
    .nav-item {
        @apply flex flex-col md:flex-row items-center md:justify-start gap-1 sm:gap-2 p-2 sm:p-3 md:px-5 md:py-3.5 mb-0 md:mb-1 rounded-2xl text-slate-500 font-semibold transition-all duration-300 cursor-pointer hover:bg-slate-50 hover:text-brand-600 border border-transparent flex-1 md:flex-none justify-center;
    }
    .nav-item.active {
        @apply bg-brand-50 text-brand-700 border border-brand-100 md:shadow-sm;
    }
    .nav-item svg {
        @apply w-5 h-5 sm:w-6 sm:h-6 md:w-5 md:h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110;
    }

    /* ──── Scrollbar & Utilities ──── */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    /* ──── Content Cards ──── */
    .info-card { @apply bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-5 sm:p-6 transition-all duration-300 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)]; }
    .offer-card { @apply bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:border-brand-200 flex flex-col gap-4 relative overflow-hidden; }
    .label-text { @apply text-xs font-bold text-slate-400 uppercase tracking-wider mb-1; }
    .value-text { @apply text-sm font-semibold text-slate-800; }

    /* ──── Forms ──── */
    .form-label { @apply block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2; }
    .form-input { @apply w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all duration-200 font-medium placeholder:text-slate-400; }
    .form-section { @apply bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-5 sm:p-6; }

    /* ──── Badges ──── */
    .badge { @apply inline-block px-2 sm:px-3 py-1 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-lg ring-1 ring-inset; }
    .badge-child { @apply bg-brand-50 text-brand-700 ring-brand-500/20; }
    .badge-elderly { @apply bg-accent-50 text-accent-700 ring-accent-500/20; }
    
    /* Status Badges */
    .badge-pending { @apply bg-amber-50 text-amber-700 ring-amber-500/20; }
    .badge-assigned { @apply bg-emerald-50 text-emerald-700 ring-emerald-500/20; }
    .badge-rejected { @apply bg-rose-50 text-rose-700 ring-rose-500/20; }
    
    .badge-resolved { @apply bg-emerald-50 text-emerald-700 ring-emerald-500/20; }
    .badge-open { @apply bg-amber-50 text-amber-700 ring-amber-500/20; }
    .badge-active { @apply bg-brand-50 text-brand-700 ring-brand-500/20; }

    /* ──── Buttons ──── */
    .btn-primary { @apply bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-brand-500/20 transition-all active:scale-95 hover:-translate-y-0.5; }
    .btn-secondary { @apply bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-bold text-sm transition-colors; }
    .btn-danger { @apply bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 px-5 py-2.5 rounded-xl font-bold text-sm transition-colors; }

    /* ──── Table ──── */
    .requests-table { @apply w-full text-left border-collapse min-w-[600px]; }
    .requests-table th { @apply bg-slate-50/80 backdrop-blur pb-3 pt-4 px-4 sm:px-6 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 sticky top-0 whitespace-nowrap; }
    .requests-table td { @apply py-4 px-4 sm:px-6 border-b border-slate-50 text-xs sm:text-sm font-medium text-slate-700; }
    .requests-table tr { @apply hover:bg-slate-50/50 transition-colors; }
    
    /* ──── Action Buttons (Table) ──── */
    .btn-accept { @apply px-3 sm:px-4 py-1.5 sm:py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl transition-all shadow-sm ring-1 ring-inset ring-emerald-500/20 active:scale-95 text-xs sm:text-sm; }
    .btn-decline { @apply px-3 sm:px-4 py-1.5 sm:py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-xl transition-all shadow-sm ring-1 ring-inset ring-rose-200 active:scale-95 text-xs sm:text-sm; }

    /* ──── Page Transitions ──── */
    .page-enter { animation: pageSlideIn 0.35s ease-out; }
    @keyframes pageSlideIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>
@stack('styles')