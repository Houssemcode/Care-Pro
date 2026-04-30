<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'Admin Hub') | Care-Pro</title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

<!-- Tailwind CSS Config -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="{{ asset('js/tailwind-config.js') }}"></script>

<style>
    body { font-family: 'Inter', sans-serif; }
    h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }

    /* ─── Sidebar ─── */
    .sidebar {
        width: 270px;
        background-color: #0f172a; /* slate-900 */
        display: flex;
        flex-direction: column;
        position: fixed;
        height: 100vh;
        z-index: 50;
        color: #cbd5e1; /* slate-300 */
        transition: transform 0.3s ease;
    }
    @media (max-width: 1023px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.mobile-open { transform: translateX(0); box-shadow: 20px 0 60px rgba(0,0,0,0.6); }
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        margin: 0 0.75rem 0.25rem 0.75rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid transparent;
        color: #94a3b8;
    }
    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.05);
        color: white;
    }
    .nav-item.active {
        background-color: rgba(20, 184, 166, 0.1); /* brand-500/10 */
        color: #2dd4bf; /* brand-400 */
        border-color: rgba(20, 184, 166, 0.2);
    }
    .nav-item .nav-badge {
        margin-left: auto;
        font-size: 10px;
        font-bold: 700;
        background-color: rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        padding: 2px 8px;
        border-radius: 6px;
    }
    .nav-item.active .nav-badge {
        background-color: rgba(20, 184, 166, 0.2);
        color: #2dd4bf;
    }

    /* ─── Data Table ─── */
    .data-table { width: 100%; text-align: left; border-collapse: collapse; min-width: 700px; }
    .data-table th {
        background-color: rgba(248, 250, 252, 0.9);
        backdrop-filter: blur(4px);
        position: sticky;
        top: 0;
        border-bottom: 1px solid #f1f5f9;
        padding: 14px 20px;
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        white-space: nowrap;
    }
    .data-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f8fafc;
        font-size: 14px;
        font-weight: 500;
        color: #334155;
        background-color: white;
        transition: background-color 0.2s ease;
    }
    .data-table tbody tr:hover td { background-color: #f8fafc; }

    /* ─── Badges ─── */
    .status-badge {
        display: inline-flex;
        padding: 4px 10px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-radius: 8px;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
    }
    .status-pending { background-color: #fffbeb; color: #b45309; }
    .status-approved { background-color: #ecfdf5; color: #047857; }
    .status-rejected { background-color: #fff1f2; color: #be123c; }

    /* ─── Buttons ─── */
    .btn-approve { padding: 6px 12px; background-color: #10b981; color: white; font-weight: 700; border-radius: 8px; font-size: 12px; transition: all 0.2s ease; border: none; cursor: pointer; }
    .btn-approve:hover { background-color: #059669; }
    .btn-reject { padding: 6px 12px; background-color: white; border: 1px solid #e2e8f0; color: #e11d48; font-weight: 700; border-radius: 8px; font-size: 12px; transition: all 0.2s ease; cursor: pointer; }
    .btn-reject:hover { background-color: #fff1f2; border-color: #fecdd3; }

    /* ─── Report Cards ─── */
    .report-card {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        cursor: pointer;
    }
    .report-card:hover { background-color: #f8fafc; }

    /* ─── Stat Cards ─── */
    .stat-card {
        background-color: white;
        border-radius: 1rem;
        border: 1px solid #f1f5f9;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.06); }

    /* ─── Modals ─── */
    .modal-overlay { position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 100; opacity: 0; visibility: hidden; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .modal-overlay.open { opacity: 100; visibility: visible; }
    .modal-content { background-color: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); width: 100%; max-width: 32rem; transform: scale(0.95); opacity: 0; transition: all 0.3s ease; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden; }
    .modal-overlay.open .modal-content { transform: scale(1); opacity: 100; }
    .modal-header { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; background-color: white; }
    .modal-body { padding: 1.25rem 1.5rem; overflow-y: auto; background-color: #f8fafc; }
    .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; background-color: white; flex-shrink: 0; }

    /* ─── Scrollbar ─── */
    .custom-scrollbar::-webkit-scrollbar { height: 5px; width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }

    /* ─── Page Transitions ─── */
    .page-enter {
        animation: slideUp 0.4s ease-out forwards;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
