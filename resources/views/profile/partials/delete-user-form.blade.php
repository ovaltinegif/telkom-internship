<section>
    <header class="mb-10">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-rose-100 dark:bg-rose-500/10 rounded-xl flex items-center justify-center text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20 shadow-sm transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <h2 class="text-xl font-black text-rose-900 dark:text-rose-300 tracking-tight">
                {{ __('Hapus Akun') }}
            </h2>
        </div>
        <p class="text-sm text-rose-700/70 dark:text-rose-400 font-medium ml-13">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.') }}
        </p>
    </header>

    <div class="bg-white/40 dark:bg-rose-500/5 p-6 rounded-3xl border border-rose-100/50 dark:border-rose-500/20 backdrop-blur-sm transition-colors duration-300">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-8 py-3.5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95 shadow-xl shadow-rose-200 dark:shadow-rose-950/40"
        >{{ __('Hapus Akun Permanen') }}</button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 sm:p-10">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-slate-800 dark:text-slate-200 tracking-tight">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 font-medium">
                {{ __('Setelah akun dihapus, semua data akan hilang selamanya. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
            </p>

            <div class="mt-8">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full rounded-2xl border-slate-200 dark:border-slate-800 focus:border-rose-500 focus:ring-rose-500 dark:bg-slate-950 shadow-sm transition-all py-4 px-6 text-slate-700 dark:text-slate-200 font-medium"
                    placeholder="{{ __('Konfirmasi Kata Sandi Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-8 py-3.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-8 py-3.5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-rose-200 dark:shadow-rose-950/40">
                    {{ __('Hapus Sekarang') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
