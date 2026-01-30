<x-app-layout>
    <!-- Custom Gradient Header -->
    <div class="relative bg-gradient-to-r from-red-700 via-red-600 to-orange-600 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h2 class="font-bold text-3xl text-white leading-tight">
                {{ __('Profile Settings') }}
            </h2>
            <p class="text-red-100 mt-2">Manage your account information and security preferences.</p>
        </div>
        
        <!-- Decorative Pattern (Optional) -->
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12"></div>
    </div>

    <div class="-mt-24 pb-12 relative z-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Profile Info -->
                <div class="lg:col-span-2">
                    <div class="p-8 bg-white shadow-lg shadow-slate-200/50 sm:rounded-2xl border border-slate-100">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Right Column: Security & Danger Zone -->
                <div class="space-y-8">
                    <div class="p-8 bg-white shadow-lg shadow-slate-200/50 sm:rounded-2xl border border-slate-100">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="p-8 bg-white shadow-lg shadow-rose-100/50 sm:rounded-2xl border border-rose-100">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
