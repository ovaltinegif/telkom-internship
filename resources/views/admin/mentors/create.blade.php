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
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden relative">
                
                {{-- Decorative Header --}}
                <div class="absolute top-0 w-full h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>

                <div class="p-8">
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Formulir Data Mentor</h3>
                            <p class="text-slate-500 text-sm">Lengkapi data diri dan penempatan mentor.</p>
                        </div>
                    </div>

                    {{-- Tampilkan Error Validasi jika ada --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border border-rose-100 text-rose-600 p-4 rounded-xl flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mt-0.5 shrink-0">
                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <strong class="font-bold">Terjadi Kesalahan!</strong>
                                <ul class="list-disc pl-5 mt-1 text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.mentors.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Field: Nama Lengkap --}}
                            <div class="md:col-span-2">
                                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold mb-1" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            </div>

                            {{-- Field: Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-semibold mb-1" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            </div>

                            {{-- Field: Password --}}
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-semibold mb-1" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            </div>

                            {{-- Field: NIK --}}
                            <div>
                                <x-input-label for="nik" :value="__('NIK (Nomor Induk Karyawan)')" class="text-slate-700 font-semibold mb-1" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required />
                            </div>

                            {{-- Field: Jabatan --}}
                            <div>
                                <x-input-label for="position" :value="__('Jabatan (Posisi)')" class="text-slate-700 font-semibold mb-1" />
                                <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" placeholder="Contoh: Officer 3 Digital" required />
                            </div>



                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-slate-100">
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-xl text-slate-600 font-semibold hover:bg-slate-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all hover:scale-[1.02] active:scale-95">
                                {{ __('Simpan Data Mentor') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
