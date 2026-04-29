/**
 * Authentication Logic
 * Handles form toggling and mocked login/registration redirects.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Element Selectors
    const loginToggle = document.getElementById('login-toggle');
    const registerToggle = document.getElementById('register-toggle');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    const loginEmail = document.getElementById('login-email');
    const loginPassword = document.getElementById('login-password');

    const regName = document.getElementById('reg-name');
    const regEmail = document.getElementById('reg-email');
    const regPassword = document.getElementById('reg-password');

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

    // --- Mock Authentication ---

    const mockAuthRedirect = (role) => {
        console.log(`Authenticating as ${role}...`);

        // Simulate network delay
        setTimeout(() => {
            if (role === 'family') {
                window.location.href = 'pages/family/dashboard.html';
            } else if (role === 'employee') {
                window.location.href = 'pages/employee/dashboard.html';
            } else if (role === 'admin') {
                window.location.href = 'pages/admin/dashboard.html';
            } else {
                alert('Authentication failed: Role not identified.');
            }
        }, 800);
    };

    // Handle Login Submission
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Mocking a simple role check based on email for demo purposes
        const email = loginEmail.value.toLowerCase();
        let role = 'family'; // Default

        if (email.includes('admin')) {
            role = 'admin';
        } else if (email.includes('care') || email.includes('staff')) {
            role = 'employee';
        }

        mockAuthRedirect(role);
    });

    // Handle Registration Submission
    registerForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Get selected role from radio buttons
        const selectedRole = document.querySelector('input[name="role"]:checked').value;

        console.log(`Registering ${regName.value} as ${selectedRole}...`);
        mockAuthRedirect(selectedRole);
    });
});
