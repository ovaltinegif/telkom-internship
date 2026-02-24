<x-app-layout>
    <div class="py-12" x-data="{ 
        showModal: false, 
        showPreview: false,
        previewUrl: '',
        selectedLogbook: { name: '', title: '', date: '', activity: '' } 
    }">
    {{-- 1. LOAD LIBRARY SWEETALERT --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight transition-colors">
                    {{ __('Detail Intern') }}
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm transition-colors">Lihat profil dan rekap aktivitas intern</p>
            </div>
             <a href="{{ route('mentor.students.index') }}" class="inline-flex items-center px-6 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl font-black text-[10px] text-slate-600 dark:text-slate-400 uppercase tracking-widest shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-red-600 dark:hover:text-red-400 hover:border-red-100 dark:hover:border-red-500/20 active:scale-95 transition-all">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 2. PROFILE CARD --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center md:items-center gap-10 transition-colors duration-300">
                {{-- Photo --}}
                <div class="shrink-0 relative group">
                    <div class="absolute -inset-1 bg-gradient-to-tr from-red-600 to-orange-600 rounded-full blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
                    @if($internship->student->studentProfile && $internship->student->studentProfile->photo)
                        <img class="relative h-32 w-32 rounded-full object-cover shadow-2xl border-4 border-white dark:border-slate-800 transition-colors" src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" alt="{{ $internship->student->name }}">
                    @else
                        <div class="relative h-32 w-32 rounded-full bg-gradient-to-tr from-red-600 to-orange-600 flex items-center justify-center text-white text-5xl font-black shadow-2xl border-4 border-white dark:border-slate-800 transition-colors">
                            {{ substr($internship->student->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="grow text-center md:text-left space-y-4">
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 dark:text-slate-100 tracking-tight transition-colors">{{ $internship->student->name }}</h1>
                        <p class="text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest text-[10px] mt-1 transition-colors">{{ $internship->student->email }}</p>
                    </div>

                    {{-- MERGED: INFO STATS FROM INCOMING CHANGE --}}
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-4">
                         <div class="px-5 py-2.5 bg-slate-50 dark:bg-slate-950/50 rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors">
                            <p class="text-[10px] text-slate-400 dark:text-slate-600 uppercase tracking-widest font-black mb-1">Universitas</p>
                            <p class="font-bold text-slate-700 dark:text-slate-300 text-xs">{{ $internship->student->studentProfile->university ?? '-' }}</p>
                        </div>
                        <div class="px-5 py-2.5 bg-red-50 dark:bg-red-500/10 rounded-2xl border border-red-100 dark:border-red-500/20 transition-colors">
                            <p class="text-[10px] text-red-400 dark:text-red-500 uppercase tracking-widest font-black mb-1">Divisi</p>
                            <p class="font-black text-red-600 dark:text-red-400 text-xs uppercase tracking-tight">{{ $internship->division->name }}</p>
                        </div>
                         <div class="px-5 py-2.5 bg-slate-900 dark:bg-white rounded-2xl border border-slate-900 dark:border-white shadow-lg shadow-slate-900/20 dark:shadow-none transition-colors">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-black mb-1">Total Logbook</p>
                            <p class="font-black text-white dark:text-slate-900 text-xs">{{ $internship->dailyLogbooks->count() }} Aktivitas</p>
                        </div>
                    </div>
                </div>

                {{-- Action / Grading --}}
                <div class="shrink-0 md:ml-auto flex flex-col items-center md:items-end justify-center">
                         @if($internship->evaluation)
                              <div class="text-center md:text-right bg-emerald-50 dark:bg-emerald-500/5 p-6 rounded-[2rem] border border-emerald-100 dark:border-emerald-500/10 transition-colors">
                                 <span class="block text-[10px] text-emerald-600 dark:text-emerald-500 uppercase font-black tracking-widest mb-3 transition-colors">Nilai Akhir</span>
                                 <div class="relative inline-block">
                                     <div class="absolute -inset-4 bg-emerald-500 rounded-full blur-xl opacity-20"></div>
                                     <span class="relative inline-flex items-center px-8 py-4 bg-emerald-500 text-white rounded-2xl font-black text-3xl shadow-xl shadow-emerald-500/40 transition-colors">
                                         {{ $internship->evaluation->final_score }}
                                     </span>
                                 </div>
                              </div>
                        @else
                            @php
                                $canInputGrade = \Carbon\Carbon::parse($internship->end_date)->subDays(7)->lte(\Carbon\Carbon::now());
                                $daysRemaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($internship->end_date), false);
                            @endphp

                            @if($canInputGrade)
                                <a href="{{ route('mentor.evaluations.create', $internship->id) }}" 
                                   class="group inline-flex items-center gap-3 px-8 py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black rounded-2xl shadow-xl shadow-slate-900/20 dark:shadow-none hover:bg-red-600 dark:hover:bg-red-50 hover:text-white dark:hover:text-red-600 text-sm uppercase tracking-widest transition-all hover:scale-105 active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Input Nilai Akhir
                                </a>
                            @else
                                <div class="text-right">
                                    <button disabled class="group inline-flex items-center gap-3 px-8 py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 font-black rounded-2xl border border-slate-200 dark:border-slate-700 cursor-not-allowed text-sm uppercase tracking-widest transition-colors" title="Penilaian baru dibuka 7 hari sebelum magang selesai">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                        </svg>
                                        Input Nilai Terkunci
                                    </button>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-600 mt-3 font-black uppercase tracking-widest transition-colors text-right">
                                        Terbuka dalam <span class="text-slate-800 dark:text-slate-200">{{ ceil($daysRemaining - 7) }}</span> hari lagi
                                    </p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

            {{-- 3. TRANSKRIP NILAI --}}
            @if($internship->evaluation)
            <div x-data="{ show: false }" class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-[2.5rem] border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="px-10 py-6 bg-slate-50/50 dark:bg-slate-950/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between transition-colors">
                    <div>
                        <h3 class="font-black text-lg text-slate-800 dark:text-slate-100 tracking-tight transition-colors">Transkrip Nilai Magang</h3>
                        <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest mt-1 transition-colors">Hasil evaluasi akhir kegiatan magang</p>
                    </div>
                    <div class="flex gap-3">
                        <button @click="show = !show" class="text-[10px] font-black uppercase tracking-widest text-slate-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 px-6 py-2.5 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-red-600 dark:hover:text-red-400 hover:border-red-100 dark:hover:border-red-500/20 active:scale-95 transition-all shadow-sm flex items-center gap-2">
                             <span x-text="show ? 'Sembunyikan' : 'Lihat Transkrip'"></span>
                        </button>
                        <a href="{{ route('mentor.students.transcript', $internship->id) }}" target="_blank" class="text-[10px] font-black uppercase tracking-widest text-white bg-blue-600 hover:bg-blue-700 px-6 py-2.5 rounded-2xl transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015-1.837-2.175a48.041 48.041 0 00-1.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                            Cetak Transkrip
                        </a>
                    </div>
                </div>
                {{-- Table (Collapsible) --}}
                <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="border-t border-slate-100 dark:border-slate-800 transition-colors">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-950/30 text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th class="px-10 py-5 w-24 text-center">No</th>
                                <th class="px-8 py-5">Komponen Penilaian</th>
                                <th class="px-8 py-5 w-40 text-center">Nilai Angka</th>
                                <th class="px-10 py-5 w-40 text-center">Predikat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300 transition-colors">
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-10 py-6 text-center font-black text-slate-400">01</td>
                                <td class="px-8 py-6 font-bold">Kedisiplinan & Etika Kerja</td>
                                <td class="px-8 py-6 text-center font-black text-lg">{{ $internship->evaluation->discipline_score }}</td>
                                <td class="px-10 py-6 text-center">
                                    <span class="inline-flex items-center px-4 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-black text-xs border border-slate-200 dark:border-slate-700">
                                        {{ $internship->evaluation->discipline_score >= 85 ? 'A' : ($internship->evaluation->discipline_score >= 70 ? 'B' : 'C') }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-10 py-6 text-center font-black text-slate-400">02</td>
                                <td class="px-8 py-6 font-bold">Kemampuan Teknis & Hasil Kerja</td>
                                <td class="px-8 py-6 text-center font-black text-lg">{{ $internship->evaluation->technical_score }}</td>
                                <td class="px-10 py-6 text-center">
                                    <span class="inline-flex items-center px-4 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-black text-xs border border-slate-200 dark:border-slate-700">
                                        {{ $internship->evaluation->technical_score >= 85 ? 'A' : ($internship->evaluation->technical_score >= 70 ? 'B' : 'C') }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-10 py-6 text-center font-black text-slate-400">03</td>
                                <td class="px-8 py-6 font-bold">Komunikasi & Kerjasama Tim</td>
                                <td class="px-8 py-6 text-center font-black text-lg">{{ $internship->evaluation->soft_skill_score }}</td>
                                <td class="px-10 py-6 text-center">
                                    <span class="inline-flex items-center px-4 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-black text-xs border border-slate-200 dark:border-slate-700">
                                        {{ $internship->evaluation->soft_skill_score >= 85 ? 'A' : ($internship->evaluation->soft_skill_score >= 70 ? 'B' : 'C') }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg-emerald-500 text-white transition-colors">
                                <td colspan="2" class="px-10 py-8 text-right font-black uppercase tracking-widest text-xs">Nilai Akhir Rata-Rata</td>
                                <td class="px-8 py-8 text-center font-black text-3xl">{{ $internship->evaluation->final_score }}</td>
                                <td class="px-10 py-8 text-center font-black text-3xl">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- 4. DOKUMEN & LAPORAN --}}
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-10 space-y-6 transition-colors duration-300">
                <h3 class="font-black text-2xl text-slate-800 dark:text-slate-100 tracking-tight transition-colors">Dokumen & Laporan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Monthly Report --}}
                    <div class="flex items-center justify-between p-8 bg-slate-50/50 dark:bg-slate-950/50 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-500/20 group transition-all duration-300">
                        <div class="flex items-center gap-6">
                            <div class="bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 p-5 rounded-[1.5rem] shadow-lg shadow-blue-500/10 group-hover:scale-110 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0h18M5 10.5h14" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-black text-xl text-slate-800 dark:text-slate-200 transition-colors">Laporan Bulanan</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest mt-1 transition-colors">Rekap kehadiran & logbook</p>
                            </div>
                        </div>
                        <button onclick="openMonthlyReportModal()" class="text-[10px] font-black uppercase tracking-widest text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-500/30 px-6 py-3 rounded-2xl hover:bg-blue-600 hover:text-white hover:border-blue-600 active:scale-95 transition-all shadow-sm">
                            Unduh
                        </button>
                    </div>

                    {{-- Final Report --}}
                    @php $finalReport = $internship->documents->where('type', 'laporan_akhir')->first(); @endphp
                    <div class="flex items-center justify-between p-8 bg-slate-50/50 dark:bg-slate-950/50 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-purple-200 dark:hover:border-purple-500/20 group transition-all duration-300">
                        <div class="flex items-center gap-6">
                            <div class="bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-500 p-5 rounded-[1.5rem] shadow-lg shadow-purple-500/10 group-hover:scale-110 transition-all">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-black text-xl text-slate-800 dark:text-slate-200 transition-colors">Laporan Akhir</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest mt-1 transition-colors">File laporan final mahasiswa</p>
                            </div>
                        </div>
                        @if($finalReport)
                            <a href="{{ Storage::url($finalReport->file_path) }}" target="_blank" class="text-[10px] font-black uppercase tracking-widest text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-500/30 px-6 py-3 rounded-2xl hover:bg-purple-600 hover:text-white hover:border-purple-600 active:scale-95 transition-all shadow-sm">
                                Download
                            </a>
                        @else
                             <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-600 border border-slate-100 dark:border-slate-800 px-6 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900/50 cursor-not-allowed transition-colors">
                                Kosong
                            </span>
                        @endif
                    </div>
                </div>

            {{-- 5. LOGBOOK HISTORY --}}
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-[2.5rem] border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-10">
                    <h3 id="logbook-section" class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-8 flex items-center gap-3 scroll-mt-24 transition-colors">
                        <span class="w-2.5 h-8 bg-gradient-to-b from-red-600 to-red-800 rounded-full shadow-lg shadow-red-500/20"></span>
                        Riwayat Logbook Harian
                    </h3>
                    
                    <div class="overflow-hidden rounded-[2rem] border border-slate-100 dark:border-slate-800 transition-colors">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead class="bg-slate-50 dark:bg-slate-950/30 border-b border-slate-100 dark:border-slate-800 transition-colors">
                                <tr>
                                    <th class="px-8 py-5 font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest text-[10px]">Tanggal</th>
                                    <th class="px-8 py-5 font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest text-[10px] w-1/4">Judul</th>
                                    <th class="px-8 py-5 font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest text-[10px] w-1/3">Aktivitas</th>
                                    <th class="px-8 py-5 font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest text-[10px]">Bukti</th>
                                    <th class="px-8 py-5 font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest text-[10px]">Status</th>
                                    <th class="px-8 py-5 font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest text-[10px] text-center w-64">Penilaian Mentor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($internship->dailyLogbooks as $logbook)
                                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-8 py-6 font-bold text-slate-700 dark:text-slate-300 align-top transition-colors">
                                        {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                    </td>
                                    <td class="px-8 py-6 align-top">
                                        <span class="text-sm font-black text-slate-800 dark:text-slate-200 line-clamp-2 transition-colors">
                                            {{ $logbook->title ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 align-top">
                                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed trix-content line-clamp-3 transition-colors text-xs">
                                            {!! $logbook->activity !!}
                                        </div>
                                        @if($logbook->mentor_note)
                                            <div class="mt-3 text-[10px] font-black text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 px-3 py-1.5 rounded-xl border border-blue-100 dark:border-blue-500/20 inline-flex items-center gap-2 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3h9m-9 3h3m-6.75 4.125l-.623 1.246a.75.75 0 001.07 1.05l1.44-1.152a.75.75 0 01.469-.175h9.75a.375.375 0 00.375-.375V4.875a.375.375 0 00-.375-.375H4.125a.375.375 0 00-.375.375v12.375c0 .207.168.375.375.375h.375a.375.375 0 01.375.375z" /></svg>
                                                Note: {{ $logbook->mentor_note }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 align-top">
                                        @if($logbook->evidence)
                                            <button type="button" 
                                                    @click="previewUrl = '{{ Storage::url($logbook->evidence) }}'; showPreview = true;"
                                               class="inline-flex items-center gap-2 text-[10px] font-black text-slate-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 px-4 py-2 rounded-xl transition-all shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-red-600 dark:hover:text-red-400 group-hover:scale-105 active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                Berkas
                                            </button>
                                        @else
                                            <span class="text-slate-400 dark:text-slate-600 text-[10px] font-black uppercase tracking-widest transition-colors italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 align-top">
                                        <div class="flex flex-col gap-2">
                                            @if($logbook->status == 'approved')
                                                <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 border border-emerald-100 dark:border-emerald-500/20 w-fit transition-colors uppercase tracking-widest">
                                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 shadow-[0_0_8px_rgba(16,185,129,0.8)] animate-pulse"></span> BERHASIL
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500 border border-amber-100 dark:border-amber-500/20 w-fit uppercase tracking-widest transition-colors">
                                                     <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-2"></span> PENDING
                                                </span>
                                            @endif
                                            
                                            <button type="button" 
                                                    @click="selectedLogbook = { 
                                                       name: '{{ addslashes($internship->student->name) }}', 
                                                       title: '{{ addslashes($logbook->title) }}',
                                                       date: '{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}', 
                                                       activity: {{ json_encode($logbook->activity) }} 
                                                    }; showModal = true"
                                                    class="text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 transition-all flex items-center gap-2 uppercase tracking-widest mt-1 active:scale-95 group/btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 group-hover/btn:translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
                                                Detail
                                            </button>
                                        </div>
                                    </td>
                                    
                                    <td class="px-8 py-6 text-center align-top">
                                        @if($logbook->status == 'pending')
                                            <form action="{{ route('mentor.logbook.update', $logbook->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="button" data-status="approved" class="btn-action w-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black px-6 py-3 rounded-2xl text-[11px] transition-all shadow-xl shadow-slate-900/20 dark:shadow-none active:scale-95 hover:bg-emerald-600 dark:hover:bg-emerald-50 hover:text-white dark:hover:text-emerald-600 uppercase tracking-widest border border-transparent">
                                                    Setujui
                                                </button>
                                            </form>
                                        @else
                                            <div class="text-[10px] text-slate-400 dark:text-slate-600 font-black uppercase tracking-widest py-3 italic transition-colors flex items-center justify-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-500"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Tervalidasi
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                         <div class="flex flex-col items-center gap-4">
                                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-950/50 rounded-full flex items-center justify-center text-slate-200 dark:text-slate-800 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 dark:text-slate-600 transition-colors">Belum ada logbook yang disubmit.</p>
                                         </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVA SCRIPT UNTUK SWEETALERT --}}
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
                confirmButtonColor: '#e11d48'
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e11d48'
            });
        @endif

        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.btn-action');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const status = this.getAttribute('data-status'); 
                    const isApproved = status === 'approved';

                    Swal.fire({
                        title: 'Setujui Logbook?',
                        text: "Status logbook akan berubah menjadi Approved.",
                        icon: 'question',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Setujui',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'status';
                            input.value = status;
                            form.appendChild(input);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    
    {{-- MODALS --}}
    {{-- Monthly Report Modal --}}
    <div id="monthlyReportModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" aria-hidden="true" onclick="document.getElementById('monthlyReportModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <form action="{{ route('mentor.students.monthlyReport', $internship->id) }}" method="GET" target="_blank" class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-500 shadow-sm border border-blue-100 dark:border-blue-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0h18M5 10.5h14" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 dark:text-slate-100 transition-colors">Unduh Laporan</h3>
                            <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest transition-colors">Pilih periode laporan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest mb-2 transition-colors">Bulan</label>
                            <select name="month" class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200 shadow-sm focus:border-red-500 focus:ring-red-500 font-bold text-sm transition-colors">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 dark:text-slate-500 uppercase tracking-widest mb-2 transition-colors">Tahun</label>
                            <select name="year" class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-200 shadow-sm focus:border-red-500 focus:ring-red-500 font-bold text-sm transition-colors">
                                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                                <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('monthlyReportModal').classList.add('hidden')" class="grow py-3.5 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-600 dark:text-slate-400 font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-95">Batal</button>
                        <button type="submit" class="grow py-3.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black text-sm transition-all shadow-xl shadow-slate-900/20 dark:shadow-none hover:bg-red-600 dark:hover:bg-red-50 hover:text-white dark:hover:text-red-600 active:scale-95">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Detail Modal @see synced redesign across mentor views --}}
    <div x-show="showModal" 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         style="display: none;"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-md" 
                 @click="showModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl border border-slate-100 dark:border-slate-800">
                
                <!-- Header -->
                <div class="px-10 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-950/50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-50 dark:bg-red-500/10 rounded-2xl flex items-center justify-center text-red-600 dark:text-red-500 shadow-sm border border-red-100 dark:border-red-500/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors tracking-tight" x-text="selectedLogbook.title || 'Detail Aktivitas'">Detail Aktivitas</h3>
                            <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest transition-colors mt-0.5" x-text="selectedLogbook.date"></p>
                        </div>
                    </div>
                    <button @click="showModal = false" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all active:scale-95">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-10 py-8">
                    <!-- Content -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-red-600 dark:bg-red-500 rounded-full shadow-lg shadow-red-500/40"></span>
                            <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest transition-colors">Isi Aktivitas</h4>
                        </div>
                        <div class="p-8 bg-slate-50/50 dark:bg-slate-950/50 border border-slate-100 dark:border-slate-800 rounded-[2rem] text-slate-700 dark:text-slate-300 leading-relaxed text-sm overflow-y-auto max-h-[40vh] shadow-inner trix-content prose prose-slate dark:prose-invert max-w-none transition-colors" 
                             x-html="selectedLogbook.activity">
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-10 py-6 bg-slate-50/50 dark:bg-slate-950/50 border-t border-slate-100 dark:border-slate-800 flex justify-end transition-colors">
                    <button type="button" 
                            @click="showModal = false"
                            class="px-10 py-3.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all active:scale-95 shadow-xl shadow-slate-900/20 dark:shadow-none hover:bg-black dark:hover:bg-slate-50">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Attachment Preview Modal --}}
    <div x-show="showPreview" 
         class="fixed inset-0 z-[1100] overflow-y-auto" 
         style="display: none;"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showPreview" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity bg-slate-900/90 backdrop-blur-xl" 
                 @click="showPreview = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showPreview"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                
                <!-- Header -->
                <div class="px-8 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-950/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-50 dark:bg-red-500/10 rounded-2xl flex items-center justify-center text-red-600 dark:text-red-400 shadow-sm border border-red-100 dark:border-red-500/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 dark:text-slate-200 transition-colors leading-tight">Pratinjau Lampiran</h3>
                            <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest transition-colors mt-0.5">Dokumen Bukti Kegiatan Intern</p>
                        </div>
                    </div>
                    <button @click="showPreview = false" class="w-10 h-10 rounded-2xl flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all shadow-sm">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 transition-colors bg-white dark:bg-slate-900 h-[70vh] flex items-center justify-center">
                    <template x-if="previewUrl.match(/\.(jpeg|jpg|gif|png|webp)$/i)">
                        <img :src="previewUrl" class="max-w-full max-h-full object-contain rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800" alt="Preview">
                    </template>
                    <template x-if="previewUrl.match(/\.(pdf)$/i)">
                        <iframe :src="previewUrl" class="w-full h-full rounded-2xl border border-slate-100 dark:border-slate-800 shadow-inner"></iframe>
                    </template>
                    <template x-if="!previewUrl.match(/\.(jpeg|jpg|gif|png|webp|pdf)$/i)">
                        <div class="text-center p-12">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-black text-slate-800 dark:text-slate-200">Pratinjau Tidak Tersedia</h4>
                            <p class="text-slate-500 dark:text-slate-500 font-medium max-w-xs mx-auto mt-2 mb-8">Format file ini tidak dapat dipratinjau langsung. Silakan unduh untuk melihat detailnya.</p>
                            <a :href="previewUrl" download class="inline-flex items-center gap-2 px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-red-500/30 active:scale-95">
                                Unduh File
                            </a>
                        </div>
                    </template>
                </div>

                <!-- Footer -->
                <div class="px-8 py-4 bg-slate-50/50 dark:bg-slate-950/50 border-t border-slate-100 dark:border-slate-800 flex justify-end transition-colors gap-3">
                    <a :href="previewUrl" target="_blank" class="px-6 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-95 shadow-sm">
                        Buka di Tab Baru
                    </a>
                    <button type="button" 
                            @click="showPreview = false"
                            class="px-8 py-2.5 bg-slate-900 dark:bg-white hover:bg-black dark:hover:bg-slate-100 text-white dark:text-slate-900 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-slate-900/20 dark:shadow-none">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>