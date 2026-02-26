<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex flex-col gap-1">
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                    @if($internship->status === 'finished')
                        {{ __('Magang Selesai, ') }} <span class="text-red-600 dark:text-red-400">{{ Auth::user()->name }}!</span> 🏆
                    @else
                        {{ __('Hello, ') }} <span class="text-red-600 dark:text-red-400">{{ Auth::user()->name }}!</span> 👋
                    @endif
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    @if($internship->status === 'finished')
                        Terima kasih atas dedikasi luar biasa Anda di Telkom
                    @else
                        Selamat datang di Dashboard Kegiatan Internship Telkom
                    @endif
                </p>
            </div>
            
            @if(isset($internship) && $internship->end_date)
                @if($internship->status !== 'finished')
                    @php
                        $endDate = \Carbon\Carbon::parse($internship->end_date);
                        $now = \Carbon\Carbon::now();
                        $diff = $now->diff($endDate);
                        $isExpired = $now->gt($endDate);
                    @endphp
                    
                    <div class="flex flex-col items-start md:items-end">
                        <p class="text-slate-900 dark:text-slate-300 font-semibold text-sm mb-1">Sisa Waktu Magang Anda</p>
                        <div class="flex items-center gap-2">
                             @if(!$isExpired)
                                @if($diff->y > 0)
                                    <div class="bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 px-3 py-1 rounded-xl font-bold text-xl shadow-sm border border-emerald-200 dark:border-emerald-500/30">
                                        {{ $diff->y }} <span class="text-sm font-medium">th</span>
                                    </div>
                                @endif
                                @if($diff->m > 0 || $diff->y > 0)
                                    <div class="bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 px-3 py-1 rounded-xl font-bold text-xl shadow-sm border border-emerald-200 dark:border-emerald-500/30">
                                        {{ $diff->m }} <span class="text-sm font-medium">bl</span>
                                    </div>
                                @endif
                                <div class="bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 px-3 py-1 rounded-xl font-bold text-xl shadow-sm border border-emerald-200 dark:border-emerald-500/30">
                                    {{ $diff->d }} <span class="text-sm font-medium">hr</span>
                                </div>
                            @else
                                 <div class="bg-red-100 dark:bg-red-500/20 text-red-800 dark:text-red-300 px-4 py-1 rounded-xl font-bold text-lg shadow-sm border border-red-200 dark:border-red-500/30">
                                    Masa Magang Berakhir
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-start md:items-end">
                        <p class="text-slate-900 dark:text-slate-300 font-semibold text-sm mb-1 uppercase tracking-widest text-[10px]">Periode Magang</p>
                        <div class="flex flex-col items-start md:items-end gap-1">
                            <p class="text-slate-500 dark:text-slate-400 text-xs font-medium pr-1">
                                {{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('M Y') }} - {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('M Y') }}
                            </p>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 p-4 mb-4 flex items-start gap-3 shadow-sm transition-colors duration-300" role="alert">
                    <div class="shrink-0 text-emerald-500 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <strong class="block text-sm font-bold text-emerald-800 dark:text-emerald-300">Berhasil!</strong>
                        <span class="text-sm text-emerald-700 dark:text-emerald-400/90">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Pesan Error --}}
            @if(session('error') || $errors->any())
                <div class="rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 p-4 mb-4 flex items-start gap-3 shadow-sm transition-colors duration-300" role="alert">
                    <div class="shrink-0 text-red-500 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <strong class="block text-sm font-bold text-red-800 dark:text-red-300">Perhatian!</strong>
                        <span class="text-sm text-red-700 dark:text-red-400/90">{{ session('error') ?? $errors->first() }}</span>
                    </div>
                </div>
            @endif

            {{-- area Stats --}}
            @if($internship->status !== 'finished')
                <x-attendance-stats :totalPresent="$totalPresent" :attendancePercentage="$attendancePercentage" :totalPermit="$totalPermit" />
            @endif

            {{-- Graduation Showcase / Banner Kelulusan --}}
            @if($internship->status === 'finished')
                <div class="bg-gradient-to-br from-red-600 via-red-500 to-rose-500 dark:from-red-700 dark:via-red-600 dark:to-rose-600 rounded-3xl shadow-2xl dark:shadow-red-900/40 overflow-hidden relative group">
                    <!-- Decorative patterns -->
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-700"></div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-700"></div>
                    
                    <div class="px-8 py-10 md:px-12 md:py-16 relative z-10 text-center md:text-left flex flex-col md:flex-row items-center gap-8">
                        <div class="shrink-0">
                            <div class="w-24 h-24 md:w-32 md:h-32 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border-4 border-white/30 shadow-xl animate-bounce">
                                <span class="text-5xl md:text-6xl text-white">🎓</span>
                            </div>
                        </div>
                        
                        <div class="flex-1 text-white">
                            <h3 class="text-3xl md:text-5xl font-black mb-4 tracking-tight drop-shadow-lg">Selamat! Magang Selesai.</h3>
                            <p class="text-lg md:text-xl text-red-50 opacity-90 leading-relaxed max-w-2xl font-medium">
                                Anda telah resmi menyelesaikan program magang di <span class="font-bold underline decoration-red-200">Telkom Witel Semarang Jateng Utara</span>. Terima kasih atas dedikasi dan kontribusi luar biasa Anda selama program ini.
                            </p>
                            
                            <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                                {{-- 1. Rekap Logbook --}}
                                <a href="{{ route('logbooks.exportExcel') }}" class="inline-flex items-center gap-2 bg-white text-red-600 px-6 py-3 rounded-2xl font-bold hover:bg-red-50 transition-all shadow-lg hover:shadow-white/20 active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125h-7.5a1.125 1.125 0 0 1-1.125-1.125m0 0h7.5m-7.5 0V5.625m0 12.75v1.5c0 .621-.504 1.125-1.125 1.125M9 5.625v9.75m6-9.75v9.75M3.375 5.625h17.25c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125H3.375a1.125 1.125 0 0 1-1.125-1.125V6.75c0-.621.504-1.125 1.125-1.125Z" />
                                    </svg>
                                    Rekap Logbook (.xlsx)
                                </a>

                                {{-- 2. Transkrip Nilai --}}
                                @php
                                    $transcriptDoc = $internship->documents->where('type', 'transcript')->first();
                                @endphp
                                @if($transcriptDoc)
                                    <a href="{{ Storage::url($transcriptDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-md text-white border border-white/30 px-6 py-3 rounded-2xl font-bold hover:bg-black/30 transition-all shadow-lg active:scale-95">
                                        📄 Transkrip Nilai
                                    </a>
                                @else
                                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md text-white/80 border border-white/20 px-6 py-3 rounded-2xl font-bold italic text-sm">
                                        ⌛ Transkrip sedang diproses...
                                    </div>
                                @endif

                                {{-- 3. Sertifikat & Penilaian (Dokumen Kelulusan) --}}
                                @php
                                    $certDoc = $internship->documents->where('type', 'sertifikat_kelulusan')->first();
                                    $pklDoc = $internship->documents->where('type', 'laporan_penilaian_pkl')->first();
                                @endphp
                                
                                @if($certDoc)
                                    <a href="{{ Storage::url($certDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-md text-white border border-white/30 px-6 py-3 rounded-2xl font-bold hover:bg-black/30 transition-all shadow-lg active:scale-95">
                                        🎖️ Sertifikat Magang
                                    </a>
                                @endif

                                @if($pklDoc)
                                    <a href="{{ Storage::url($pklDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-md text-white border border-white/30 px-6 py-3 rounded-2xl font-bold hover:bg-black/30 transition-all shadow-lg active:scale-95">
                                        📋 Penilaian PKL
                                    </a>
                                @endif

                                {{-- 4. Laporan Akhir --}}
                                <button onclick="openFinalReportModal()" class="inline-flex items-center gap-2 bg-indigo-600/40 backdrop-blur-md text-white border border-indigo-400/40 px-6 py-3 rounded-2xl font-bold hover:bg-indigo-600/60 transition-all shadow-lg active:scale-95">
                                    📁 Laporan Akhir
                                </button>

                                @if(!$certDoc && !$pklDoc)
                                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md text-white/80 border border-white/20 px-6 py-3 rounded-2xl font-bold italic text-sm">
                                        ⌛ Dokumen kelulusan sedang diproses...
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transcript and Other Alumni Content --}}
                @if($internship->evaluation)
                    {{-- 1. Transcript Display --}}
                    <div x-data="{ show: false }" class="bg-white dark:bg-slate-900 overflow-hidden shadow-md sm:rounded-2xl border border-slate-200 dark:border-slate-800 transition-colors duration-300">
                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-slate-800 dark:text-slate-200">Transkrip Nilai Internal</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Hasil evaluasi akhir kegiatan magang Anda</p>
                            </div>
                            <div class="flex gap-3">
                                <button @click="show = !show" class="text-sm font-semibold text-slate-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors shadow-sm flex items-center gap-2">
                                    <span x-text="show ? 'Sembunyikan' : 'Lihat Detail'"></span>
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                </button>
                                <a href="{{ route('documents.transcript') }}" target="_blank" class="text-sm font-semibold text-white bg-red-600 border border-red-600 px-4 py-2 rounded-lg hover:bg-red-700 transition-colors shadow-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015-1.837-2.175a48.041 48.041 0 00-1.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                                    Cetak PDF
                                </a>
                            </div>
                        </div>
                        <div x-show="show" x-transition class="border-t border-slate-100 dark:border-slate-800">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                                    <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-12">No</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Komponen Penilaian</th>
                                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-32">Nilai Angka</th>
                                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-32">Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors mb-0 border-b border-gray-200 dark:border-slate-800">
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">1</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">Kedisiplinan & Etika Kerja</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center font-medium">{{ $internship->evaluation->discipline_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">{{ $internship->evaluation->discipline_score >= 85 ? 'A' : ($internship->evaluation->discipline_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">2</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">Kemampuan Teknis & Hasil Kerja</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center font-medium">{{ $internship->evaluation->technical_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">{{ $internship->evaluation->technical_score >= 85 ? 'A' : ($internship->evaluation->technical_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">3</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">Komunikasi & Kerjasama Tim</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center font-medium">{{ $internship->evaluation->soft_skill_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">{{ $internship->evaluation->soft_skill_score >= 85 ? 'A' : ($internship->evaluation->soft_skill_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                        <tr class="bg-red-50/30 dark:bg-red-500/5 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 dark:text-slate-100 transition-colors text-right font-bold w-full">Nilai Akhir Rata-Rata</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-red-600 dark:text-red-400 transition-colors text-center font-bold text-lg border-x border-red-100 dark:border-red-500/10">{{ $internship->evaluation->final_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-red-600 dark:text-red-400 transition-colors text-center font-bold text-lg">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endif


            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Column: Logbook List (Takes 2/3 width on large screens) --}}
                <div class="lg:col-span-2 space-y-6">
                    <x-logbook-history :logbooks="$logbooks" :todayLogbook="$todayLogbook" />
                </div> {{-- End Left Column --}}

                {{-- Right Column: Absensi & Mentor --}}
                <div class="space-y-6">
                    {{-- Absensi Card --}}
                    @if($internship->status !== 'finished')
                    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 dark:from-slate-900 dark:to-indigo-950 rounded-2xl shadow-xl dark:shadow-indigo-950/20 overflow-hidden text-white relative transition-all duration-300 border border-transparent dark:border-slate-800">
                        <!-- Decorative bg -->
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-red-500/10 rounded-full blur-2xl"></div>

                        <div class="p-6 relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-xl font-bold">Absensi Hari Ini</h3>
                                    <p class="text-indigo-200 text-sm">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                                </div>
                                <div class="bg-white/10 backdrop-blur-md px-3 py-1 rounded-full border border-white/20">
                                    <span class="text-xs font-semibold tracking-wider">LIVE</span>
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-center py-4 space-y-4">
                                @if(!$todayAttendance)
                                    <div class="text-center space-y-4 w-full">
                                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-2 animate-pulse">
                                            <span class="text-3xl">📍</span>
                                        </div>
                                        <div>
                                            <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                            <p class="text-white font-bold text-lg">Belum Check-In</p>
                                        </div>
                                        
                                        {{-- isCheckInTime variable is now passed from DashboardController --}}

                                        @if($isCheckInTime)
                                            <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm" class="w-full">
                                                @csrf
                                                <input type="hidden" name="latitude" id="lat_in">
                                                <input type="hidden" name="longitude" id="long_in">
                                                <button type="button" onclick="confirmCheckIn()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                                   CHECK IN SEKARANG
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-full bg-slate-800/50 border border-slate-700 text-slate-400 font-bold py-3.5 rounded-xl text-center flex flex-col items-center justify-center gap-1 cursor-not-allowed">
                                                <span>Check In Ditutup</span>
                                                <span class="text-xs font-normal text-slate-500">Hanya tersedia pukul 07:00 - 09:00</span>
                                            </div>
                                        @endif
                                        
                                        <div class="pt-2">
                                            <button onclick="openPermissionModal()" class="text-sm text-indigo-300 hover:text-white hover:underline transition-colors pb-1">
                                                Tidak masuk kerja? Ajukan Izin
                                            </button>
                                        </div>
                                    </div>

                                @elseif($todayAttendance->permit_type === 'temporary' && !$todayAttendance->check_in_time)
                                    @php
                                        $permitEndTime = \Carbon\Carbon::parse($todayAttendance->date . ' ' . $todayAttendance->permit_end_time);
                                        $isLocked = \Carbon\Carbon::now()->lt($permitEndTime);
                                    @endphp

                                    <div class="text-center space-y-4 w-full">
                                        @if($isLocked)
                                            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-2 border border-amber-200">
                                                <span class="text-3xl">⏳</span>
                                            </div>
                                            <div>
                                                <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                                <p class="text-white font-bold text-lg">Sedang Izin Sementara</p>
                                                <p class="text-indigo-200 text-xs mt-1">Check-in akan terbuka pukul {{ $permitEndTime->format('H:i') }}</p>
                                            </div>
                                        @else
                                            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-2 animate-pulse">
                                                <span class="text-3xl">📍</span>
                                            </div>
                                            <div>
                                                <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                                <p class="text-white font-bold text-lg">Waktu Izin Habis</p>
                                                <p class="text-emerald-300 text-xs mt-1">Silakan Check-in untuk melanjutkan magang.</p>
                                            </div>
                                            
                                            <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm" class="w-full">
                                                @csrf
                                                <input type="hidden" name="latitude" id="lat_in">
                                                <input type="hidden" name="longitude" id="long_in">
                                                <button type="button" onclick="confirmCheckIn()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                                   CHECK IN KEMBALI
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                @elseif($todayAttendance->permit_type === 'full')
                                     <div class="text-center space-y-4 w-full">
                                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-2 border border-amber-200">
                                            <span class="text-3xl">📝</span>
                                        </div>
                                        <div>
                                            <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                            <p class="text-white font-bold text-lg">Sedang Izin Full Day</p>
                                        </div>
                                    </div>

                                @elseif(!$todayAttendance->check_out_time)
                                    <div class="text-center space-y-4 w-full">
                                        <div class="bg-emerald-500/20 border border-emerald-500/30 rounded-xl p-4 w-full mb-2">
                                            <p class="text-emerald-200 text-xs uppercase tracking-wide font-bold">Waktu Masuk</p>
                                            <p class="text-2xl font-mono text-emerald-400 font-bold mt-1">{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</p>
                                        </div>

                                        {{-- isCheckOutTime variable is now passed from DashboardController --}}

                                        @if($isCheckOutTime)
                                            <form action="{{ route('attendance.checkOut') }}" method="POST" id="checkOutForm" class="w-full">
                                                @csrf
                                                <button type="button" onclick="confirmCheckOut()" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-rose-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                                   CHECK OUT PULANG
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-full bg-slate-800/50 border border-slate-700 text-slate-400 font-bold py-3.5 rounded-xl text-center flex flex-col items-center justify-center gap-1 cursor-not-allowed">
                                                <span>Belum Waktunya Pulang</span>
                                                <span class="text-xs font-normal text-slate-500">Check Out tersedia pukul 17:00 - 19:00</span>
                                            </div>
                                        @endif

                                        <div class="pt-2">
                                            <button onclick="openPermissionModal(true)" class="text-sm text-indigo-300 hover:text-white hover:underline transition-colors pb-1">
                                                Izin Setengah Hari / Keluar Sementara?
                                            </button>
                                        </div>
                                    </div>

                                @else
                                    <div class="text-center space-y-4 w-full">
                                        <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-2 shadow-lg shadow-emerald-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-bold text-lg">Kehadiran Terekam!</p>
                                            <p class="text-emerald-300 text-sm">Terima kasih atas kerja kerasmu hari ini.</p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 w-full mt-4">
                                            <div class="bg-white/5 rounded-lg p-3 text-center">
                                                <p class="text-xs text-indigo-300 uppercase">Masuk</p>
                                                <p class="font-mono text-sm font-bold text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</p>
                                            </div>
                                            <div class="bg-white/5 rounded-lg p-3 text-center">
                                                <p class="text-xs text-indigo-300 uppercase">Keluar</p>
                                                <p class="font-mono text-sm font-bold text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i:s') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Mentor Card --}}
                    @if($internship->mentor)
                        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                            <div class="p-1 bg-gradient-to-r from-red-600 to-rose-500"></div>
                            <div class="p-6">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center text-2xl shadow-inner border border-slate-200 dark:border-slate-700">
                                        👤
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 dark:text-slate-200 text-lg leading-tight">Mentor Anda</h4>
                                        <p class="text-slate-500 dark:text-slate-400 text-xs">Informasi Mentor Pendamping</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nama Lengkap</p>
                                        <p class="text-slate-800 dark:text-slate-200 font-bold">{{ $internship->mentor->name }}</p>
                                    </div>

                                    @if($internship->mentor->mentorProfile)
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Jabatan & Unit</p>
                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-semibold">{{ $internship->mentor->mentorProfile->position ?? '-' }}</p>
                                            <p class="text-slate-500 dark:text-slate-400 text-xs mt-0.5">{{ $internship->division->name ?? ($internship->mentor->mentorProfile->division->name ?? '-') }}</p>
                                        </div>
                                    @endif

                                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-3">
                                        <a href="mailto:{{ $internship->mentor->email }}" class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-colors group">
                                            <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center group-hover:bg-red-50 dark:group-hover:bg-red-500/10">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                </svg>
                                            </div>
                                            <span class="truncate">{{ $internship->mentor->email }}</span>
                                        </a>

                                        @if($internship->mentor->mentorProfile && $internship->mentor->mentorProfile->phone_number)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $internship->mentor->mentorProfile->phone_number) }}" target="_blank" class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                                <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center group-hover:bg-emerald-50 dark:group-hover:bg-emerald-500/10">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                                    </svg>
                                                </div>
                                                <span>{{ $internship->mentor->mentorProfile->phone_number }}</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div> {{-- End Right Column --}}

            </div> {{-- End Grid --}}
        </div> {{-- End Max Width Container --}}
    </div> {{-- End Padding Wrapper --}}

    {{-- MODALS --}}

    {{-- 1. Permission Modal --}}
    <x-permission-modal />

    {{-- 2. Final Report Modal --}}
    <div id="finalReportModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('finalReportModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 dark:border-slate-800">
                <form action="{{ route('documents.storeFinalReport') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">Upload Laporan Akhir</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">File Laporan (PDF)</label>
                        <input type="file" name="file" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 dark:file:bg-purple-500/10 file:text-purple-700 dark:file:text-purple-400 hover:file:bg-purple-100 dark:hover:file:bg-purple-500/20" required>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('finalReportModal')" class="py-2 px-4 border dark:border-slate-700 rounded-md text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">Batal</button>
                        <button type="submit" class="py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-md shadow-lg shadow-purple-500/20 transition-all">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Scripts --}}
    <script>
    // Modal Functions
    function openPermissionModal(isCheckedIn = false) { 
        document.getElementById('permissionModal').classList.remove('hidden'); 

        const typeSelect = document.getElementById('permit_type');
        
        // Elements for Date Toggle
        const badgeContainer = document.getElementById('date_badge_container');
        const inputContainer = document.getElementById('date_input_container');
        const dateInput = document.getElementById('permission_date');
        const hiddenDateInput = document.getElementById('hidden_date_input');

        // Radio Buttons
        const tempRadio = document.querySelector('input[name="permit_type"][value="temporary"]');
        const fullRadio = document.querySelector('input[name="permit_type"][value="full"]');
        const fullLabel = document.getElementById('full_permit_label');

        if (isCheckedIn) {
            // 1. Show Badge, Hide Input
            badgeContainer.classList.remove('hidden');
            inputContainer.classList.add('hidden');
            
            // Manage Inputs: Enable Hidden, Disable Manual
            dateInput.removeAttribute('required'); 
            dateInput.disabled = true; 
            hiddenDateInput.disabled = false;

            // 2. Lock Permit Type to 'temporary'
            tempRadio.checked = true;
            fullRadio.disabled = true;
            
            // Visual disable for Label/Card
            fullLabel.classList.add('opacity-50', 'cursor-not-allowed');
            fullLabel.classList.remove('cursor-pointer');
        } else {
            // 1. Show Input, Hide Badge
            badgeContainer.classList.add('hidden');
            inputContainer.classList.remove('hidden');
            
            // Manage Inputs: Disable Hidden, Enable Manual
            dateInput.setAttribute('required', 'required');
            dateInput.disabled = false; 
            hiddenDateInput.disabled = true;

             // 2. Unlock Permit Type
             fullRadio.disabled = false;
             
             // Restore Visual
             fullLabel.classList.remove('opacity-50', 'cursor-not-allowed');
             fullLabel.classList.add('cursor-pointer');
        }

        toggleAttachment(); // Ensure correct initial state
    }

    function openFinalReportModal() { document.getElementById('finalReportModal').classList.remove('hidden'); }

    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    


        // Logic for Time Input (Temporary Permit)
        function toggleAttachment() {
            // Get checked radio value
            const type = document.querySelector('input[name="permit_type"]:checked')?.value || 'temporary';
            const timeDiv = document.getElementById('time_div');
            const startTime = document.getElementById('start_time');
            const endTime = document.getElementById('end_time');

            if (type === 'temporary') {
                timeDiv.classList.remove('hidden');
                startTime.setAttribute('required', 'required');
                endTime.setAttribute('required', 'required');
            } else {
                timeDiv.classList.add('hidden');
                startTime.removeAttribute('required');
                endTime.removeAttribute('required');
            }
        }

    // 1. Fungsi Konfirmasi CHECK-IN

    function confirmCheckIn() {
        Swal.fire({
            title: 'Siap untuk Check-In?',
            text: "Pastikan kamu sudah berada di lokasi kantor!",
            icon: 'question',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: 'Ya, Check In!',
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
                Swal.fire({
                    title: 'Mengambil Lokasi...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                    }
                });
                getLocationAndSubmit();
            }
        });
    }

    // 2. Fungsi Ambil Lokasi & Submit Otomatis
    function getLocationAndSubmit() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lat_in').value = position.coords.latitude;
                    document.getElementById('long_in').value = position.coords.longitude;
                    document.getElementById('checkInForm').submit();
                },
                function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengambil lokasi. Pastikan GPS aktif.',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                            title: 'text-slate-900 dark:text-slate-100 font-bold',
                            htmlContainer: 'text-slate-600 dark:text-slate-400',
                            confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                        }
                    });
                }
            );
        } else { 
            Swal.fire({
                title: 'Error',
                text: 'Browser tidak mendukung Geolocation.',
                icon: 'error',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        }
    }

    // 3. Fungsi Konfirmasi CHECK-OUT
    function confirmCheckOut() {
        Swal.fire({
            title: 'Mau pulang sekarang?',
            text: 'Pastikan pekerjaan hari ini sudah selesai ya!',
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: 'Ya, Check Out',
            cancelButtonText: 'Masih lembur',
            buttonsStyling: false,
            customClass: {
                popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                title: 'text-slate-900 dark:text-slate-100 font-bold',
                htmlContainer: 'text-slate-600 dark:text-slate-400',
                confirmButton: 'px-6 py-2.5 mx-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl transition-all active:scale-95',
                cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkOutForm').submit();
            }
        });
    }

    // GPS Helper for legacy/debugging
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latEl = document.getElementById('lat_in');
                const longEl = document.getElementById('long_in');
                if (latEl && longEl) {
                    latEl.value = position.coords.latitude;
                    longEl.value = position.coords.longitude;
                }
            });
        }
    }
    // Call once on load
    getLocation(); 

    // Init Flatpickr for Permission Date
    document.addEventListener('DOMContentLoaded', function() {
        // Date Picker
        flatpickr("#permission_date", {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd F Y',
            locale: 'id',
            disableMobile: true,
            minDate: "today"
        });

        // Time Pickers
        flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: true,
            allowInput: true
        });

        flatpickr("#end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: true,
            allowInput: true
        });
    });
    </script>
</x-app-layout>