<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-slate-200 leading-tight transition-colors hidden">
            {{ __('Tambah Mentor Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300 font-sans">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Page Title Area -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tambah Mentor</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Masukan data mentor baru untuk pembimbingan magang.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 transition-all font-semibold text-sm shadow-sm active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Main Container -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                <div class="p-8 sm:p-10">
                    
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-14 h-14 rounded-2xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-600 dark:text-red-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 transition-colors">Formulir Data Mentor</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm transition-colors">Lengkapi data diri dan penempatan mentor.</p>
                        </div>
                    </div>

                    {{-- Tampilkan Error Validasi jika ada --}}
                    @if ($errors->any())
                        <div class="mb-8 bg-rose-50 dark:bg-rose-500/10 border border-rose-100 dark:border-rose-500/20 text-rose-600 dark:text-rose-400 p-5 rounded-2xl flex items-start gap-4 transition-colors">
                            <div class="p-2 bg-white dark:bg-slate-900 rounded-lg shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 shrink-0">
                                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <strong class="font-bold text-sm block mb-1">Terjadi Kesalahan!</strong>
                                <ul class="list-disc pl-5 text-xs space-y-1 opacity-90">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.mentors.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            {{-- Field: Nama Lengkap --}}
                            <div class="md:col-span-2 space-y-2">
                                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.1em] ml-1" />
                                <x-text-input id="name" class="block w-full px-5 py-3.5 rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500/20 font-bold transition-all shadow-sm" type="text" name="name" :value="old('name')" required autofocus />
                            </div>

                            {{-- Field: Email --}}
                            <div class="space-y-2">
                                <x-input-label for="email" :value="__('Email')" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.1em] ml-1" />
                                <x-text-input id="email" class="block w-full px-5 py-3.5 rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500/20 font-bold transition-all shadow-sm" type="email" name="email" :value="old('email')" required />
                            </div>

                            {{-- Field: Password --}}
                            <div class="space-y-2">
                                <x-input-label for="password" :value="__('Password')" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.1em] ml-1" />
                                <x-text-input id="password" class="block w-full px-5 py-3.5 rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500/20 font-bold transition-all shadow-sm" type="password" name="password" required />
                            </div>

                            {{-- Field: NIK --}}
                            <div class="space-y-2">
                                <x-input-label for="nik" :value="__('NIK (Nomor Induk Karyawan)')" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.1em] ml-1" />
                                <x-text-input id="nik" class="block w-full px-5 py-3.5 rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500/20 font-bold transition-all shadow-sm" type="text" name="nik" :value="old('nik')" required />
                            </div>

                            {{-- Field: Jabatan --}}
                            <div class="space-y-2">
                                <x-input-label for="position" :value="__('Jabatan (Posisi)')" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.1em] ml-1" />
                                <x-text-input id="position" class="block w-full px-5 py-3.5 rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500/20 font-bold transition-all shadow-sm" type="text" name="position" :value="old('position')" placeholder="Contoh: Officer 3 Digital" required />
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 mt-10 border-t border-slate-100 dark:border-slate-800 transition-colors">
                            <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl text-slate-600 dark:text-slate-400 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 text-center transition-all text-sm border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-auto px-10 py-3.5 bg-red-600 text-white font-bold rounded-2xl shadow-lg shadow-red-200 dark:shadow-red-900/20 transition-all hover:bg-red-700 hover:scale-[1.02] active:scale-95 text-sm">
                                {{ __('Simpan Data Mentor') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
