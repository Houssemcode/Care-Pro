<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'Account Settings')
    <x-employee.head />
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-employee.navbar :active="'settings'" />

    <main class="flex-1 w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 page-enter">
        <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-2">Account Settings</h1>
        <p class="text-sm text-slate-500 font-medium mb-8">Update your personal information and preferences.</p>

        <form class="space-y-6">
            {{-- Personal Info --}}
            <div class="form-section">
                <h2 class="font-display font-bold text-lg text-slate-800 mb-5">Personal Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><label class="form-label">Full Name</label><input type="text" value="Sonia Belkacem" class="form-input"></div>
                    <div><label class="form-label">Email</label><input type="email" value="sonia.belkacem@email.com" class="form-input"></div>
                    <div><label class="form-label">Phone Number</label><input type="tel" value="+213 555 789 012" class="form-input"></div>
                    <div><label class="form-label">Location</label><input type="text" value="Hydra, Algiers" class="form-input"></div>
                </div>
            </div>

            {{-- Password --}}
            <div class="form-section">
                <h2 class="font-display font-bold text-lg text-slate-800 mb-5">Change Password</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><label class="form-label">Current Password</label><input type="password" placeholder="••••••••" class="form-input"></div>
                    <div><label class="form-label">New Password</label><input type="password" placeholder="••••••••" class="form-input"></div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="form-section border-rose-100">
                <h2 class="font-display font-bold text-lg text-rose-600 mb-2">Danger Zone</h2>
                <p class="text-xs text-slate-500 mb-4">Permanently delete your account and all associated data.</p>
                <button type="button" onclick="UI.confirm('Account deletion requires admin approval.', () => {})" class="btn-danger">Delete My Account</button>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('employee.profile') }}" class="btn-secondary">Cancel</a>
                <button type="submit" onclick="event.preventDefault(); UI.toast('Settings Saved!', 'success')" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </main>
</body>
</html>
