/**
 * Admin Module Logic
 */

// Toggle Sidebar for Mobile
window.toggleSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('mobile-overlay');
    
    if (!sidebar || !overlay) return;

    sidebar.classList.toggle('mobile-open');
    if (sidebar.classList.contains('mobile-open')) {
        overlay.classList.remove('invisible', 'opacity-0');
    } else {
        overlay.classList.add('opacity-0');
        setTimeout(() => overlay.classList.add('invisible'), 300);
    }
};

// Global Modal Functions
window.openModal = function(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.add('open');
};

window.closeModal = function(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.remove('open');
};

document.addEventListener('DOMContentLoaded', () => {
    // Any global admin initialization logic can go here
});
