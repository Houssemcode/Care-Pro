/**
 * Authentication Logic
 * Handles form toggling. (Submission is now handled natively by Laravel)
 */
document.addEventListener('DOMContentLoaded', () => {
    // Element Selectors
    const loginToggle = document.getElementById('login-toggle');
    const registerToggle = document.getElementById('register-toggle');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    // --- Form Toggling Logic ---
    const toggleAuthForm = (showRegister) => {
        if (showRegister) {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            loginToggle.classList.remove('active');
            registerToggle.classList.add('active');
        } else {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginToggle.classList.add('active');
            registerToggle.classList.remove('active');
        }
    };

    loginToggle.addEventListener('click', () => toggleAuthForm(false));
    registerToggle.addEventListener('click', () => toggleAuthForm(true));
});