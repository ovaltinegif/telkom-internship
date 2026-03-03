<section>
    <header class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-black text-slate-800 dark:text-slate-200 tracking-tight">
                {{ __('Update Kata Sandi') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-medium">
                {{ __('Ubah dan ingat kata sandi agar tetap aman.') }}
            </p>
        </div>
        <div class="hidden sm:block">
            <div class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-600 dark:text-slate-400 shadow-sm border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
            <input id="update_password_current_password" name="current_password" type="password" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
            <input id="update_password_password" name="password" type="password" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-8 py-3.5 bg-slate-900 dark:bg-slate-100 hover:bg-black dark:hover:bg-white text-white dark:text-slate-900 rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95 shadow-xl shadow-slate-200 dark:shadow-slate-950/40">
                {{ __('Ubah Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 dark:text-emerald-400 font-bold"
                >{{ __('Berhasil Diperbarui.') }}</p>
            @endif
        </div>
    </form>
</section>
