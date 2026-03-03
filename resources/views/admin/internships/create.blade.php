<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Setup Program Intern Baru') }}
            </h2>
            <p class="text-slate-500 text-sm">Validasi dan aktifkan periode intern</p>
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
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 transition-colors">Formulir Setup Intern</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm transition-colors">Pastikan data intern dan penempatan sudah benar.</p>
                        </div>
                    </div>

                    {{-- Tampilkan Error Validasi jika ada --}}
                    @if ($errors->any())
                        <div class="mb-8 bg-rose-50 dark:bg-rose-500/10 border border-rose-100 dark:border-rose-500/20 text-rose-600 dark:text-rose-400 p-5 rounded-2xl flex items-start gap-4 transition-colors">
                            <div class="p-2 bg-white dark:bg-slate-900 rounded-lg shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mt-0.5 shrink-0">
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

                    <form action="{{ route('admin.internship.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            {{-- Field: Mahasiswa --}}
                            <div class="md:col-span-2 space-y-1.5">
                                <x-input-label for="student_id" :value="__('Pilih Intern')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                        </svg>
                                    </div>
                                    <select name="student_id" id="student_id" class="pl-12 block w-full border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm font-bold transition-all py-3">
                                        <option value="">-- Cari Intern --</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Field: Divisi --}}
                            <div class="space-y-1.5">
                                <x-input-label for="division_id" :value="__('Penempatan Divisi')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M2 4.25A2.25 2.25 0 014.25 2h11.5A2.25 2.25 0 0118 4.25v8.5A2.25 2.25 0 0115.75 15h-3.105a3.501 3.501 0 001.1 1.677A.75.75 0 0113.26 18H6.74a.75.75 0 01-.484-1.323A3.501 3.501 0 007.355 15H4.25A2.25 2.25 0 012 12.75v-8.5zm1.5 0a.75.75 0 01.75-.75h11.5a.75.75 0 01.75.75v7.5a.75.75 0 01-.75.75H4.25a.75.75 0 01-.75-.75v-7.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <select name="division_id" id="division_id" class="pl-12 block w-full border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm font-bold transition-all py-3">
                                        @foreach($divisions as $div)
                                            <option value="{{ $div->id }}">{{ $div->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Field: Mentor --}}
                            <div class="space-y-1.5">
                                <x-input-label for="mentor_id" :value="__('Mentor Pembimbing')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zM6 8a2 2 0 11-4 0 2 2 0 014 0zM1.49 15.326a.78.78 0 01-.358-.442 3 3 0 014.308-3.516 6.484 6.484 0 00-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 01-2.07-.655zM16.44 15.98a4.97 4.97 0 002.07-.654.78.78 0 00.357-.442 3 3 0 00-4.308-3.517 6.484 6.484 0 011.907 3.96 2.32 2.32 0 01-.026.654zM18 8a2 2 0 11-4 0 2 2 0 014 0zM5.304 16.19a.844.844 0 01-.277-.71 5 5 0 019.947 0 .843.843 0 01-.277.71A6.975 6.975 0 0110 18a6.974 6.974 0 01-4.696-1.81z" />
                                        </svg>
                                    </div>
                                    <select name="mentor_id" id="mentor_id" class="pl-12 block w-full border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm font-bold transition-all py-3">
                                        <option value="">-- Pilih Mentor --</option>
                                        @foreach($mentors as $mentor)
                                            @php
                                                $quota = $mentor->mentorProfile->quota ?? 5;
                                                $active = $mentor->activeInternships()->count();
                                                $isFull = $active >= $quota;
                                            @endphp
                                            <option value="{{ $mentor->id }}" {{ $isFull ? 'disabled' : '' }} class="{{ $isFull ? 'text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-900/50' : '' }}">
                                                {{ $mentor->name }} ({{ $active }}/{{ $quota }}) {{ $isFull ? '- Penuh' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Field: Tanggal Mulai --}}
                            <div class="space-y-1.5">
                                <x-input-label for="start_date" :value="__('Tanggal Mulai')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <div class="relative group">
                                     <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input 
                                        id="start_date" 
                                        class="pl-12 block w-full border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm font-bold transition-all py-3" 
                                        type="text" 
                                        name="start_date" 
                                        required 
                                        placeholder="dd/mm/yyyy"
                                        x-data
                                        x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd/m/Y', locale: 'id', disableMobile: true, onReady: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('theme-modern-glow'); } })"
                                    />
                                </div>
                            </div>

                            {{-- Field: Tanggal Selesai --}}
                            <div class="space-y-1.5">
                                <x-input-label for="end_date" :value="__('Tanggal Selesai')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input 
                                        id="end_date" 
                                        class="pl-12 block w-full border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm font-bold transition-all py-3" 
                                        type="text" 
                                        name="end_date" 
                                        required 
                                        placeholder="dd/mm/yyyy"
                                        x-data
                                        x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd/m/Y', locale: 'id', disableMobile: true, onReady: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('theme-modern-glow'); } })"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 mt-10 border-t border-slate-100 dark:border-slate-800 transition-colors">
                            <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto px-8 py-3 rounded-xl text-slate-600 dark:text-slate-400 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 text-center transition-all">
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-auto px-10 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 dark:shadow-red-900/20 transition-all hover:scale-[1.02] active:scale-95">
                                {{ __('Simpan & Aktifkan Magang') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>