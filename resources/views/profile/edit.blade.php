<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Pengaturan Akun') }}
            </h2>
            <p class="text-slate-500 text-sm">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Profile Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-100">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Right Column: Security & Actions -->
                <div class="space-y-6">
                    <div class="p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-100">
                        @include('profile.partials.update-password-form')
                    </div>

                    @if(view()->exists('profile.partials.delete-user-form'))
                        <div class="p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-100">
                            @include('profile.partials.delete-user-form')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
