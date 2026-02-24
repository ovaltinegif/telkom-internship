<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Tambah Mentor Baru') }}
            </h2>
            <p class="text-slate-500 text-sm">Masukan data mentor baru untuk pembimbingan magang</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden relative transition-colors duration-300">
                
                {{-- Decorative Header --}}
                <div class="absolute top-0 w-full h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>

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
                            <div class="md:col-span-2 space-y-1.5">
                                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <x-text-input id="name" class="block mt-1 w-full px-4 py-3 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 font-bold transition-all" type="text" name="name" :value="old('name')" required autofocus />
                            </div>

                            {{-- Field: Email --}}
                            <div class="space-y-1.5">
                                <x-input-label for="email" :value="__('Email')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 font-bold transition-all" type="email" name="email" :value="old('email')" required />
                            </div>

                            {{-- Field: Password --}}
                            <div class="space-y-1.5">
                                <x-input-label for="password" :value="__('Password')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 font-bold transition-all" type="password" name="password" required />
                            </div>

                            {{-- Field: NIK --}}
                            <div class="space-y-1.5">
                                <x-input-label for="nik" :value="__('NIK (Nomor Induk Karyawan)')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <x-text-input id="nik" class="block mt-1 w-full px-4 py-3 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 font-bold transition-all" type="text" name="nik" :value="old('nik')" required />
                            </div>

                            {{-- Field: Jabatan --}}
                            <div class="space-y-1.5">
                                <x-input-label for="position" :value="__('Jabatan (Posisi)')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <x-text-input id="position" class="block mt-1 w-full px-4 py-3 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 font-bold transition-all" type="text" name="position" :value="old('position')" placeholder="Contoh: Officer 3 Digital" required />
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 mt-10 border-t border-slate-100 dark:border-slate-800 transition-colors">
                            <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto px-8 py-3 rounded-xl text-slate-600 dark:text-slate-400 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 text-center transition-all">
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-auto px-10 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 dark:shadow-red-900/20 transition-all hover:scale-[1.02] active:scale-95">
                                {{ __('Simpan Data Mentor') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
