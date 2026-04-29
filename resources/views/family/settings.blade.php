<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'Account Settings')
    @include('partials.family-head')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    @include('partials.family-navbar', ['active' => 'settings'])

    <main class="flex-1 w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 page-enter">
        <h1 class="text-2xl sm:text-4xl font-display font-bold text-slate-900 mb-2">Account Settings</h1>
        <p class="text-sm sm:text-base text-slate-500 font-medium mb-8">Update your family account information and preferences.</p>

        <form class="space-y-6">
            {{-- Family Info --}}
            <div class="form-section">
                <h2 class="font-display font-bold text-lg text-slate-800 mb-5">Family Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><label class="form-label">Family Name</label><input type="text" value="The Ahmed Family" class="form-input"></div>
                    <div><label class="form-label">Contact Email</label><input type="email" value="ahmed.family@email.com" class="form-input"></div>
                    <div><label class="form-label">Phone Number</label><input type="tel" value="+213 555 123 456" class="form-input"></div>
                    <div><label class="form-label">Address</label><input type="text" value="Hydra, Algiers" class="form-input"></div>
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

            {{-- Notifications --}}
            <div class="form-section">
                <h2 class="font-display font-bold text-lg text-slate-800 mb-5">Notification Preferences</h2>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" checked class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        <span class="text-sm font-medium text-slate-700 group-hover:text-brand-600 transition-colors">Email notifications for new caregiver matches</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" checked class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        <span class="text-sm font-medium text-slate-700 group-hover:text-brand-600 transition-colors">SMS alerts for booking confirmations</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        <span class="text-sm font-medium text-slate-700 group-hover:text-brand-600 transition-colors">Marketing emails and promotions</span>
                    </label>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="form-section border-rose-100">
                <h2 class="font-display font-bold text-lg text-rose-600 mb-2">Danger Zone</h2>
                <p class="text-xs text-slate-500 mb-4">Permanently delete your family account and all booking history.</p>
                <button type="button" onclick="UI.confirm('Account deletion requires admin approval.', () => {})" class="btn-danger">Delete My Account</button>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('family.profile') }}" class="btn-secondary">Cancel</a>
                <button type="submit" onclick="event.preventDefault(); UI.toast('Settings Saved!', 'success')" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </main>
</body>
</html>
