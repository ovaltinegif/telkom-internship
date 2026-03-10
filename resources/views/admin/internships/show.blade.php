<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 dark:text-slate-100 transition-colors tracking-tight">
                    {{ __('Detail Magang') }}
                </h2>
                <p class="text-slate-500 dark:text-slate-400 font-medium text-sm mt-1 transition-colors">Informasi lengkap terkait mahasiswa dan program magang</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php
                $profile = \App\Models\StudentProfile::where('user_id', $internship->student_id)->first();
            @endphp

            <!-- Page actions -->
            <div class="flex flex-col md:flex-row justify-end items-start md:items-center gap-4 mb-4">
                <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                    @if($internship->status === 'finished')
                    <button type="button" 
                        @click="$dispatch('open-completion-modal', { 
                            id: {{ $internship->id }}, 
                            isSmk: {{ optional($profile)->education_level === 'SMK' ? 'true' : 'false' }}, 
                            name: '{{ addslashes($internship->student->name) }}' 
                        })"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white dark:text-emerald-400 dark:bg-emerald-500/10 dark:hover:bg-emerald-500/20 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-emerald-200 dark:shadow-none transition-all active:scale-95 duration-200 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Send Certificate
                    </button>
                    @endif
                    @if($internship->status !== 'finished')
                    <button type="button" onclick="document.getElementById('overrideModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-500/50 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 text-slate-700 dark:text-slate-300 hover:text-indigo-700 dark:hover:text-indigo-400 rounded-xl font-bold text-xs uppercase tracking-widest shadow-sm hover:shadow transition-all active:scale-95 duration-200 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M16.47 2.05a3.15 3.15 0 014.45 4.45l-9.8 9.8a3.75 3.75 0 01-1.66.98l-3.32.83a.75.75 0 01-.93-.93l.83-3.32a3.75 3.75 0 01.98-1.66l9.45-9.45zm2.33 1.06a1.65 1.65 0 00-2.33 0l-.82.82 2.33 2.33.82-.82a1.65 1.65 0 000-2.33zm-4.21 2.94L12.26 8.38l2.33 2.33 2.33-2.33-2.33-2.33zM5.25 5.25A2.25 2.25 0 003 7.5v11.25A2.25 2.25 0 005.25 21h11.25A2.25 2.25 0 0018.75 18.75v-5.25a.75.75 0 00-1.5 0v5.25a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V7.5a.75.75 0 01.75-.75h5.25a.75.75 0 000-1.5H5.25z" clip-rule="evenodd" />
                        </svg>
                        Edit Kehadiran
                    </button>
                    @endif
                    <button type="button" onclick="window.history.back()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white dark:text-slate-100 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-slate-900/20 dark:shadow-none hover:shadow-slate-900/40 transition-all active:scale-95 duration-200 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        Kembali
                    </button>
                </div>
            </div>
            

            <!-- 1. Header Card: Identity & Status -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 dark:border-slate-800 flex flex-col md:flex-row items-center md:items-start gap-8 relative overflow-hidden transition-colors duration-300">
                <!-- Decorative Background Blurs -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Photo -->
                <div class="shrink-0 relative z-10">
                    @if($profile && $profile->photo)
                        <img class="h-32 w-32 rounded-3xl object-cover shadow-lg shadow-emerald-500/20 dark:shadow-none border-4 border-white dark:border-slate-800 transition-colors" src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $internship->student->name }}">
                    @else
                        <div class="h-32 w-32 rounded-3xl bg-gradient-to-tr from-emerald-400 to-teal-500 flex items-center justify-center text-white text-5xl font-black shadow-lg shadow-emerald-500/20 dark:shadow-none border-4 border-white dark:border-slate-800 transition-colors">
                            {{ substr($internship->student->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-emerald-500 border-4 border-white dark:border-slate-900 rounded-full flex items-center justify-center shadow-lg" title="Active Account">
                         <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>

                <!-- Info -->
                <div class="grow text-center md:text-left space-y-4 z-10">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 transition-colors tracking-tight">{{ $internship->student->name }}</h1>
                        <p class="text-slate-500 dark:text-slate-400 font-bold flex items-center justify-center md:justify-start gap-1.5 mt-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $internship->student->email }}
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <x-status-badge :status="$internship->status" class="px-4 py-1.5 text-[11px] font-black uppercase tracking-widest shadow-sm" />
                        
                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-widest bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/20 shadow-sm transition-colors">
                            {{ $internship->division->name ?? 'Belum Ada Divisi' }}
                        </span>
                        
                        @if($internship->mentor)
                             <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-widest bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20 shadow-sm gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                                Mentor: {{ $internship->mentor->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                
                <!-- Left Column (Detail Mahasiswa) -->
                <div class="space-y-6 lg:space-y-8">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 flex items-center justify-between">
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 transition-colors">Informasi Intern</h3>
                            <div class="p-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 text-slate-400 dark:text-slate-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest mb-1.5 flex items-center gap-1.5 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-indigo-400 dark:text-indigo-500"><path d="M10 2l8 4-8 4-8-4 8-4z" /><path d="M2.5 9v4c0 2 1.5 4 7.5 5.5C16 17 17.5 15 17.5 13V9l-7.5 3.75L2.5 9z" /></svg>
                                    Institusi Pendidikan
                                </p>
                                <p class="text-slate-800 dark:text-slate-200 font-bold transition-colors">{{ $profile->university ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest mb-1.5 transition-colors">Jurusan</p>
                                    <p class="text-slate-800 dark:text-slate-200 font-bold transition-colors">{{ $profile->major ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest mb-1.5 transition-colors">Jenjang</p>
                                    <span class="inline-flex px-2.5 py-1 text-[10px] uppercase tracking-widest font-black rounded-lg shadow-sm bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20 transition-colors">
                                        {{ $profile->education_level ?? '-' }}
                                    </span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest mb-1.5 transition-colors">{{ optional($profile)->student_type === 'siswa' ? 'NIS/NISN' : 'NIM' }}</p>
                                    <p class="text-slate-800 dark:text-slate-200 font-mono text-sm font-bold transition-colors">{{ $profile->nim ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest mb-1.5 transition-colors">Kontak (WA/HP)</p>
                                    <p class="text-slate-800 dark:text-slate-200 font-mono text-sm font-bold transition-colors">{{ $profile->phone_number ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="pt-2">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest mb-1.5 flex items-center gap-1.5 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-red-400 dark:text-red-500"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" /></svg>
                                    Alamat Domisili
                                </p>
                                <p class="text-slate-600 dark:text-slate-300 text-sm font-medium leading-relaxed bg-slate-50 dark:bg-slate-800/50 p-3.5 rounded-xl border border-slate-100 dark:border-slate-700/50 transition-colors">{{ $profile->address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Detail Magang & Dokumen) -->
                <div class="lg:col-span-2 space-y-6 lg:space-y-8">
                     <!-- Durasi & Lokasi -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden relative transition-colors duration-300">
                        <!-- Background Accent Layout -->
                        <div class="absolute top-0 right-0 w-64 h-full bg-gradient-to-l from-indigo-50/50 dark:from-indigo-500/5 to-transparent pointer-events-none"></div>

                        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 flex justify-between items-center relative z-10">
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 transition-colors">Detail Pelaksanaan</h3>
                            <div class="flex items-center gap-3">
                                @if($internship->status === 'finished')
                                    <span class="bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-400 text-[10px] px-3 py-1.5 rounded-lg font-black uppercase tracking-widest border border-indigo-200 dark:border-indigo-500/30 shadow-sm transition-colors">
                                        Status: Selesai
                                    </span>
                                @elseif($internship->status === 'active')
                                    @php
                                        $start = \Carbon\Carbon::parse($internship->start_date);
                                        $end = \Carbon\Carbon::parse($internship->end_date);
                                        $diff = $start->diff($end);
                                        $durationStr = '';
                                        if($diff->y > 0) $durationStr .= $diff->y . ' Tahun ';
                                        if($diff->m > 0) $durationStr .= $diff->m . ' Bulan ';
                                        if($diff->d > 0) $durationStr .= $diff->d . ' Hari';
                                    @endphp
                                    <span class="bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[10px] px-3 py-1.5 rounded-lg font-black uppercase tracking-widest border border-emerald-200 dark:border-emerald-500/30 shadow-sm transition-colors">
                                        Durasi: {{ trim($durationStr) ?: '0 Hari' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-10 relative z-10">
                             <!-- Periode Magang -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 bg-orange-500/10 text-orange-500 border border-orange-500/20 shadow-sm rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] transition-colors">Periode Magang</p>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800/80 rounded-[2rem] p-6 pl-8 relative overflow-hidden transition-colors shadow-sm">
                                    <!-- Timeline connector graphic -->
                                    <div class="absolute left-8 top-10 bottom-10 w-[2px] bg-slate-200 dark:bg-slate-800 transition-colors"></div>
                                    
                                    <div class="space-y-8 relative z-10">
                                        <div class="flex items-center gap-6">
                                            <div class="w-4 h-4 rounded-full bg-slate-400 dark:bg-slate-700 ring-[6px] ring-white dark:ring-slate-900 shadow-sm -ml-[7px] transition-colors relative z-20"></div>
                                            <div>
                                                <p class="text-[11px] font-black uppercase text-slate-400 dark:text-slate-500 tracking-widest transition-colors mb-1">Mulai (Start)</p>
                                                <p class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors tracking-tight">{{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-6">
                                            <div class="w-4 h-4 rounded-full bg-emerald-500 dark:bg-emerald-400 ring-[6px] ring-white dark:ring-slate-900 shadow-sm -ml-[7px] transition-colors relative z-20"></div>
                                            <div>
                                                <p class="text-[11px] font-black uppercase text-emerald-500 dark:text-emerald-400 tracking-widest transition-colors mb-1">Selesai (End)</p>
                                                <p class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors tracking-tight">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lokasi Penempatan -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 bg-blue-500/10 text-blue-500 border border-blue-500/20 shadow-sm rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] transition-colors">Lokasi Penempatan</p>
                                    </div>
                                </div>
                                
                                <div class="h-[148px] bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800/80 rounded-[2rem] flex items-center justify-center p-8 text-center transition-colors shadow-sm">
                                    <div class="space-y-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mx-auto mb-2 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors tracking-tight">{{ $internship->location ?? 'Witel Semarang' }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Office / On-Site</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 transition-colors">Dokumen Pendukung</h3>
                            <div class="px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg text-xs font-bold text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700/50 shadow-sm transition-colors">
                                {{ ($internship->pact_integrity ? 1 : 0) + $internship->documents->count() }} Berkas
                            </div>
                        </div>
                        
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800 transition-colors">
                            <!-- Pact Integrity (Signed) -->
                            @if($internship->pact_integrity)
                                <li class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 flex items-center justify-between group transition-all">
                                    <div class="flex items-center gap-5">
                                        <div class="p-3 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-100 dark:border-emerald-500/20 shadow-sm group-hover:-translate-y-0.5 transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-800 dark:text-slate-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">Pakta Integritas</p>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30 transition-colors">
                                                Verified & Signed
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($internship->pact_integrity) }}" target="_blank" class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 text-[11px] font-extrabold uppercase tracking-wider rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100 transition-all shadow-sm active:scale-95">
                                        Lihat File
                                    </a>
                                </li>
                             @endif

                            @forelse($internship->documents as $doc)
                                <li class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 flex items-center justify-between group transition-all">
                                    <div class="flex items-center gap-5">
                                        <div class="p-3 bg-slate-50 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm group-hover:-translate-y-0.5 transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" />
                                                <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-800 dark:text-slate-200 group-hover:text-indigo-700 dark:group-hover:text-indigo-400 transition-colors">{{ $doc->name }}</p>
                                            <p class="text-[10px] font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1 transition-colors">{{ str_replace('_', ' ', $doc->type) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 text-[11px] font-extrabold uppercase tracking-wider rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100 transition-all shadow-sm active:scale-95">
                                        Lihat File
                                    </a>
                                </li>
                            @empty
                                @if(!$internship->pact_integrity)
                                    <li class="p-12 text-center text-slate-400 dark:text-slate-500 italic flex flex-col items-center justify-center">
                                        <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-full mb-4">
                                            <svg class="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold">Belum ada dokumen pendukung</p>
                                    </li>
                                @endif
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Override Attendance Modal -->
    <div id="overrideModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background Overlay -->
            <div class="fixed inset-0 transition-opacity bg-slate-900/75 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('overrideModal').classList.add('hidden')"></div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-100 dark:border-slate-800">
                <form action="{{ route('admin.attendance.override') }}" method="POST">
                    @csrf
                    <input type="hidden" name="internship_id" value="{{ $internship->id }}">
                    
                    <div class="px-6 py-6 sm:p-8">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-500/20 rounded-full mb-6">
                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100" id="modal-title">Edit Kehadiran</h3>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 font-medium">Bypass logika absensi waktu untuk menetapkan status manual untuk {{ $internship->student->name }}.</p>
                        </div>

                        <div class="space-y-5 text-left">
                            <div class="space-y-1.5 relative">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Tanggal Target</label>
                                <div class="relative">
                                    <input type="text" name="date" required placeholder="Pilih Tanggal Target..."
                                        x-data x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd M Y', locale: 'id', disableMobile: true, onReady: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('theme-modern-glow'); } })"
                                        class="w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-bold shadow-sm transition-all pl-10 cursor-pointer">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5 relative">
                                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Masuk (Opsional)</label>
                                    <div class="relative">
                                        <input type="text" name="check_in_time" placeholder="Pilih Jam..."
                                            x-data x-init="flatpickr($el, { enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true, altInput: true, altFormat: 'H:i', disableMobile: true })"
                                            class="w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-bold shadow-sm transition-all pl-10 cursor-pointer">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-1.5 relative">
                                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Keluar (Opsional)</label>
                                    <div class="relative">
                                        <input type="text" name="check_out_time" placeholder="Pilih Jam..."
                                            x-data x-init="flatpickr($el, { enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true, altInput: true, altFormat: 'H:i', disableMobile: true })"
                                            class="w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-bold shadow-sm transition-all pl-10 cursor-pointer">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Status Penetapan</label>
                                <select name="status" required class="w-full border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold">
                                    <option value="present">Hadir</option>
                                    <option value="alpha">Absen (Alpha)</option>
                                    <option value="sick">Sakit</option>
                                    <option value="permit">Izin</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Catatan Override (Opsional)</label>
                                <textarea name="note" rows="2" class="w-full border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Alasan perubahan manual..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 sm:px-8">
                        <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                            Simpan Kehadiran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4f46e5',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-800 dark:bg-slate-900',
                    title: 'text-xl font-black text-slate-800 dark:text-slate-100',
                    htmlContainer: 'text-sm font-medium text-slate-500 dark:text-slate-400 text-left',
                    confirmButton: 'px-6 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all active:scale-95'
                }
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-800 dark:bg-slate-900',
                    title: 'text-xl font-black text-slate-800 dark:text-slate-100',
                    htmlContainer: 'text-sm font-medium text-slate-500 dark:text-slate-400 text-left',
                    confirmButton: 'px-6 py-2.5 rounded-xl font-bold text-white bg-red-600 hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all active:scale-95'
                }
            });
        });
    </script>
    @endif
    @include('admin.internships.partials.completion-modal')
</x-app-layout>
