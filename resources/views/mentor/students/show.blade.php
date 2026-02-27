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
             <a href="{{ route('mentor.students.index') }}" class="inline-flex items-center px-6 py-2.5 bg-red-600 border border-transparent rounded-2xl font-black text-[10px] text-white uppercase tracking-widest shadow-sm hover:shadow-red-500/20 hover:bg-red-700 active:bg-red-800 active:scale-95 transition-all">
                ← Kembali
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
                        <p class="text-slate-500 dark:text-slate-500 font-black tracking-widest text-[10px] mt-1 transition-colors">{{ $internship->student->email }}</p>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                            <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-24">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Komponen Penilaian</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-40">Nilai Angka</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-40">Predikat</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-black text-slate-400">01</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 font-bold transition-colors">Kedisiplinan & Etika Kerja</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center font-black text-lg text-slate-700 dark:text-slate-300 transition-colors">{{ $internship->evaluation->discipline_score }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-black text-[10px] uppercase tracking-widest border border-slate-200 dark:border-slate-700 transition-colors">
                                            {{ $internship->evaluation->discipline_score >= 85 ? 'A' : ($internship->evaluation->discipline_score >= 70 ? 'B' : 'C') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-black text-slate-400">02</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 font-bold transition-colors">Kemampuan Teknis & Hasil Kerja</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center font-black text-lg text-slate-700 dark:text-slate-300 transition-colors">{{ $internship->evaluation->technical_score }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-black text-[10px] uppercase tracking-widest border border-slate-200 dark:border-slate-700 transition-colors">
                                            {{ $internship->evaluation->technical_score >= 85 ? 'A' : ($internship->evaluation->technical_score >= 70 ? 'B' : 'C') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-black text-slate-400">03</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 font-bold transition-colors">Komunikasi & Kerjasama Tim</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center font-black text-lg text-slate-700 dark:text-slate-300 transition-colors">{{ $internship->evaluation->soft_skill_score }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-black text-[10px] uppercase tracking-widest border border-slate-200 dark:border-slate-700 transition-colors">
                                            {{ $internship->evaluation->soft_skill_score >= 85 ? 'A' : ($internship->evaluation->soft_skill_score >= 70 ? 'B' : 'C') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="bg-emerald-500 dark:bg-emerald-600 text-white transition-colors">
                                    <td colspan="2" class="px-6 py-6 whitespace-nowrap text-right font-black uppercase tracking-widest text-xs">Nilai Akhir Rata-Rata</td>
                                    <td class="px-6 py-6 whitespace-nowrap text-center font-black text-2xl">{{ $internship->evaluation->final_score }}</td>
                                    <td class="px-6 py-6 whitespace-nowrap text-center font-black text-2xl">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                            <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Tanggal</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-1/4">Judul</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-1/2">Aktivitas</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-64">Penilaian Mentor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                @forelse($internship->dailyLogbooks as $logbook)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700 dark:text-slate-300 align-top transition-colors">
                                        {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal align-top">
                                        <span class="text-sm font-black text-slate-800 dark:text-slate-200 line-clamp-2 transition-colors">
                                            {{ $logbook->title ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal align-top">
                                        <button type="button" 
                                                @click="selectedLogbook = { 
                                                   name: '{{ addslashes($internship->student->name) }}', 
                                                   title: '{{ addslashes($logbook->title) }}',
                                                   date: '{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}', 
                                                   activity: {{ json_encode($logbook->activity) }},
                                                   evidence: {{ $logbook->evidence ? "'" . Storage::url($logbook->evidence) . "'" : 'null' }}
                                                }; showModal = true"
                                                class="text-[10px] font-black text-slate-500 hover:text-blue-600 transition-all flex items-center justify-center gap-1.5 uppercase tracking-widest active:scale-95 group/btn bg-slate-100/50 hover:bg-blue-50 dark:bg-slate-800/50 dark:hover:bg-blue-900/40 px-3 py-1.5 rounded-lg border border-slate-200/50 dark:border-slate-700/50 hover:border-blue-200 dark:hover:border-blue-500/30 w-fit mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 group-hover/btn:scale-110 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                                            <span class="group-hover/btn:-translate-x-0.5 transition-transform">Lihat Detail</span>
                                        </button>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-top">
                                        @if($logbook->status == 'pending')
                                            <form action="{{ route('mentor.logbook.update', $logbook->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="button" data-status="approved" class="btn-action w-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black px-6 py-2.5 rounded-xl text-[10px] transition-all shadow-sm active:scale-95 hover:bg-emerald-600 dark:hover:bg-emerald-50 hover:text-white dark:hover:text-emerald-600 uppercase tracking-widest border border-slate-900 dark:border-white hover:border-emerald-600 dark:hover:border-emerald-500/20">
                                                    Setujui
                                                </button>
                                            </form>
                                        @else
                                            <div class="text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest py-2 italic transition-colors flex items-center justify-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-500"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Tervalidasi
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                        <div class="flex flex-col items-center justify-center h-full gap-2">
                                            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada logbook yang disubmit.</p>
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
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                }
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
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
                        confirmButtonText: 'Ya, Setujui',
                        cancelButtonText: 'Batal',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                            title: 'text-slate-900 dark:text-slate-100 font-bold',
                            htmlContainer: 'text-slate-600 dark:text-slate-400',
                            confirmButton: 'px-6 py-2.5 mx-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all active:scale-95',
                            cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                        }
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

                    <div class="mb-8 relative">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Pilih Periode Laporan</label>
                        @php
                            $firstLogbook = $internship->dailyLogbooks()->oldest('date')->first();
                            $start = $firstLogbook 
                                ? \Carbon\Carbon::parse($firstLogbook->date)->startOfMonth() 
                                : \Carbon\Carbon::parse($internship->start_date)->startOfMonth();
                            
                            $end = \Carbon\Carbon::now()->startOfMonth();
                            $internshipEnd = \Carbon\Carbon::parse($internship->end_date)->startOfMonth();
                            if ($end > $internshipEnd) {
                                $end = $internshipEnd;
                            }

                            $current = $end->copy();
                            $options = [];
                            
                            while ($current >= $start) {
                                $options[] = [
                                    'month' => $current->format('n'),
                                    'year' => $current->format('Y'),
                                    'label' => $current->translatedFormat('F Y')
                                ];
                                $current->subMonth();
                            }
                            
                            if (empty($options)) {
                                $options[] = [
                                    'month' => date('n'),
                                    'year' => date('Y'),
                                    'label' => \Carbon\Carbon::now()->translatedFormat('F Y')
                                ];
                            }
                        @endphp
                        <div class="relative group mt-3 mb-6">
                            {{-- Base Layer (Shadow/Overlap effect) --}}
                            <div class="absolute inset-0 bg-blue-100 dark:bg-blue-500/20 rounded-2xl transform translate-x-1.5 translate-y-1.5 transition-transform group-hover:translate-x-2 group-hover:translate-y-2 border border-blue-200 dark:border-blue-500/30"></div>
                            
                            {{-- Top Layer (Interactive) --}}
                            <div class="relative bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden transition-colors">
                                <select name="period_selector" onchange="const vals = this.value.split('-'); this.form.querySelector('[name=month]').value = vals[0]; this.form.querySelector('[name=year]').value = vals[1];" 
                                    class="w-full bg-transparent border-none focus:ring-0 text-sm py-4 pl-5 pr-12 font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest cursor-pointer !appearance-none relative z-10 transition-colors [&::-ms-expand]:hidden" style="background-image: none;">
                                    @foreach($options as $option)
                                        <option value="{{ $option['month'] }}-{{ $option['year'] }}" class="font-bold bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200">{{ $option['label'] }}</option>
                                    @endforeach
                                </select>
                                
                                {{-- Chevron Icon Custom --}}
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-blue-500 bg-gradient-to-l from-white dark:from-slate-900 via-white dark:via-slate-900 to-transparent pl-4">
                                    <svg class="h-5 w-5 opacity-70 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="month" value="{{ $options[0]['month'] ?? date('n') }}">
                        <input type="hidden" name="year" value="{{ $options[0]['year'] ?? date('Y') }}">
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
         class="fixed inset-0 z-[1100] overflow-y-auto" 
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
                 class="inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl border border-slate-100 dark:border-slate-800">
                
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
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 px-1">
                                <span class="w-2 h-2 bg-red-600 dark:bg-red-500 rounded-full shadow-lg shadow-red-500/40"></span>
                                <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest transition-colors">Isi Aktivitas</h4>
                            </div>
                            <div class="p-8 bg-slate-50/50 dark:bg-slate-950/50 border border-slate-100 dark:border-slate-800 rounded-[2rem] text-slate-700 dark:text-slate-300 leading-relaxed text-sm overflow-y-auto max-h-[40vh] shadow-inner trix-content prose prose-slate dark:prose-invert max-w-none transition-colors" 
                                 x-html="selectedLogbook.activity">
                            </div>
                        </div>

                        <!-- Lampiran Section -->
                        <div x-show="selectedLogbook.evidence" style="display: none;" class="space-y-4">
                            <div class="flex items-center gap-3 px-1">
                                <span class="w-2 h-2 bg-blue-600 dark:bg-blue-500 rounded-full shadow-[0_0_10px_rgba(37,99,235,0.5)]"></span>
                                <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest transition-colors">Lampiran Aktivitas</h4>
                            </div>
                            <div class="p-4 border border-slate-100 dark:border-slate-800 rounded-[1.5rem] bg-white dark:bg-slate-900 transition-colors">
                                <template x-if="selectedLogbook.evidence && selectedLogbook.evidence.match(/\.(jpeg|jpg|gif|png|webp)$/i)">
                                    <div class="flex justify-center bg-slate-50 dark:bg-slate-950/50 rounded-xl p-2 border border-slate-100 dark:border-slate-800">
                                        <img :src="selectedLogbook.evidence" class="max-h-[50vh] w-auto object-contain rounded-lg shadow-sm" alt="Preview Lampiran">
                                    </div>
                                </template>
                                <template x-if="selectedLogbook.evidence && selectedLogbook.evidence.match(/\.(pdf)$/i)">
                                    <iframe :src="selectedLogbook.evidence" class="w-full h-[60vh] rounded-xl border border-slate-100 dark:border-slate-800 shadow-inner"></iframe>
                                </template>
                                <template x-if="selectedLogbook.evidence && !selectedLogbook.evidence.match(/\.(jpeg|jpg|gif|png|webp|pdf)$/i)">
                                    <div class="text-center p-8 bg-slate-50 dark:bg-slate-950/50 rounded-xl border border-slate-100 dark:border-slate-800">
                                        <div class="w-16 h-16 bg-blue-50 dark:bg-blue-500/10 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        </div>
                                        <h5 class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">File Lampiran</h5>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Format file ini tidak dapat dipratinjau langsung. Silakan unduh untuk melihat detailnya.</p>
                                        <a :href="selectedLogbook.evidence" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md active:scale-95">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                            Unduh File
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
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