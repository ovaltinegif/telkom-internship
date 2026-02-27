<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
                {{ __('Dokumen & Laporan') }}
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola arsip dokumen dan laporan magangmu</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4 mb-4 flex items-start gap-3 shadow-sm" role="alert">
                    <div class="shrink-0 text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <strong class="block text-sm font-bold text-emerald-800">Berhasil!</strong>
                        <span class="text-sm text-emerald-700">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Pesan Error --}}
            @if(session('error') || $errors->any())
                <div class="rounded-xl bg-red-50 border border-red-100 p-4 mb-4 flex items-start gap-3 shadow-sm" role="alert">
                    <div class="shrink-0 text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <strong class="block text-sm font-bold text-red-800">Perhatian!</strong>
                        <span class="text-sm text-red-700">{{ session('error') ?? $errors->first() }}</span>
                    </div>
                </div>
            @endif
            
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 p-8 space-y-6 transition-colors duration-300">
                
                {{-- Transcript Display (Hidden by Default) --}}
                @if($internship->evaluation)
                <div x-data="{ show: false }" class="bg-white dark:bg-slate-900 overflow-hidden shadow-md sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-colors duration-300">
                    
                    {{-- Header / Unlock Section --}}
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100">Transkrip Nilai Magang</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Hasil evaluasi akhir kegiatan magang Anda</p>
                        </div>
                        
                        <div class="flex gap-3">
                            <button @click="show = !show" class="text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shadow-sm flex items-center gap-2">
                                <span x-text="show ? 'Sembunyikan' : 'Lihat Transkrip'"></span>
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                            
                            <a href="{{ route('documents.transcript') }}" target="_blank" class="text-sm font-semibold text-white bg-blue-600 border border-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015-1.837-2.175a48.041 48.041 0 00-1.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                                Cetak Transkrip
                            </a>
                        </div>
                    </div>

                    {{-- Table Area (Collapsible) --}}
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
                                    <tr class="bg-emerald-50/50 dark:bg-emerald-500/10 hover:bg-emerald-50 dark:hover:bg-emerald-500/20 transition-colors">
                                        <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 dark:text-slate-100 transition-colors text-right font-bold w-full">Nilai Akhir Rata-Rata</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-emerald-600 dark:text-emerald-400 transition-colors text-center font-bold text-lg border-x border-emerald-100 dark:border-emerald-900/50">{{ $internship->evaluation->final_score }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-emerald-600 dark:text-emerald-400 transition-colors text-center font-bold text-lg">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Monthly Report --}}
                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0h18M5 10.5h14" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800 dark:text-slate-100">Laporan Bulanan</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Cetak rekap kehadiran & logbook bulanan</p>
                        </div>
                    </div>
                    <button onclick="openMonthlyReportModal()" class="text-sm font-semibold text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-5 py-2.5 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                        Unduh Laporan
                    </button>
                </div>

                {{-- Extension Request (Hidden if Finished) --}}
                {{-- Extension Request (Hidden if Finished) --}}
                @if(!$isFinished)
                    @php
                        // Fetch from new InternshipExtension model
                        $extension = $internship->extensions->sortByDesc('created_at')->first();
                    @endphp
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 p-3 rounded-lg border border-amber-100 dark:border-amber-900/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-slate-800 dark:text-slate-100">Perpanjangan Magang</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Ajukan perpanjangan jika membutuhkan waktu lebih lama.</p>
                                </div>
                            </div>
                            
                            @if($extension)
                                <div class="flex flex-col items-end">
                                    @if($extension->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                            Disetujui
                                        </span>
                                    @elseif($extension->status === 'rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                            Menunggu Persetujuan
                                        </span>
                                    @endif
                                    
                                    @if($extension->status === 'pending')
                                        <span class="text-[10px] text-slate-400 mt-1">Diajukan {{ $extension->created_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Modern Timeline Visual --}}
                        @if($extension && $extension->status !== 'rejected')
                            <div class="mt-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-5 border border-slate-100 dark:border-slate-800 relative overflow-hidden">
                                {{-- Background Decoration --}}
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-amber-400/20 to-red-500/20 rounded-full blur-2xl"></div>

                                <div class="flex items-center justify-between mb-6 relative">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-100 dark:border-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="font-bold text-slate-700 dark:text-slate-200 text-sm">Skema Perpanjangan</h3>
                                    </div>
                                    <span class="bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-200 dark:border-amber-800 shadow-sm">
                                        +{{ \Carbon\Carbon::parse($extension->new_start_date)->diffInDays(\Carbon\Carbon::parse($extension->new_end_date)->addDay()) }} Hari
                                    </span>
                                </div>

                                {{-- Timeline Container --}}
                                <div class="relative pt-2">
                                    <div class="h-3 bg-slate-200 dark:bg-slate-700 rounded-full w-full flex overflow-hidden relative shadow-inner">
                                        {{-- Phase 1: Normal --}}
                                        <div class="w-2/3 bg-blue-500 h-full relative group cursor-help transition-all duration-300 hover:brightness-110">
                                            {{-- Tooltip Start --}}
                                            <div class="absolute -top-8 left-0 opacity-0 group-hover:opacity-100 transition-opacity bg-slate-800 text-white text-[10px] px-2 py-1 rounded shadow-lg pointer-events-none whitespace-nowrap">
                                                Masa Magang Awal
                                            </div>
                                        </div>
                                        
                                        {{-- Phase 2: Extension --}}
                                        <div class="w-1/3 bg-gradient-to-r from-amber-500 to-red-500 h-full relative group cursor-help animate-pulse">
                                            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            {{-- Striped Texture --}}
                                            <div class="absolute inset-0 opacity-30" style="background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent); background-size: 10px 10px;"></div>
                                             {{-- Tooltip Extra --}}
                                             <div class="absolute -top-8 right-0 opacity-0 group-hover:opacity-100 transition-opacity bg-red-600 text-white text-[10px] px-2 py-1 rounded shadow-lg pointer-events-none whitespace-nowrap">
                                                Durasi Tambahan
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Markers & Dates --}}
                                    <div class="flex justify-between items-end mt-4 relative w-full text-xs">
                                        {{-- Start --}}
                                        <div class="flex flex-col items-start w-1/3">
                                            <div class="flex items-center gap-1.5 mb-1 text-slate-400 dark:text-slate-500">
                                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">Mulai</span>
                                            </div>
                                            <div class="font-bold text-slate-800 dark:text-slate-200 font-mono">
                                                {{ \Carbon\Carbon::parse($internship->start_date)->format('d M y') }}
                                            </div>
                                        </div>

                                        {{-- Original End (Middle) --}}
                                        <div class="absolute left-2/3 -translate-x-1/2 -top-1 flex flex-col items-center group cursor-default w-auto whitespace-nowrap text-center">
                                            <div class="w-px h-4 bg-slate-300 dark:bg-slate-600 group-hover:bg-blue-500 transition-colors mb-1"></div>
                                            <span class="text-[9px] text-slate-400 dark:text-slate-500 font-medium uppercase tracking-wide group-hover:text-blue-600 transition-colors">Selesai Normal</span>
                                            <div class="text-[10px] font-bold text-slate-500 dark:text-slate-400 font-mono group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors">
                                                {{ \Carbon\Carbon::parse($internship->end_date)->format('d M y') }}
                                            </div>
                                        </div>

                                        {{-- New End --}}
                                        <div class="flex flex-col items-end w-1/3">
                                            <div class="flex items-center gap-1.5 mb-1">
                                                <span class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-wider">Target Baru</span>
                                                <span class="relative flex h-2 w-2">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                                </span>
                                            </div>
                                            <div class="font-bold text-red-600 dark:text-red-400 font-mono bg-red-50 dark:bg-red-500/10 px-2 py-0.5 rounded border border-red-100 dark:border-red-900 shadow-sm">
                                                {{ \Carbon\Carbon::parse($extension->new_end_date)->format('d M y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="mt-4 flex justify-end">
                                <a href="{{ Storage::url($extension->file_path) }}" target="_blank" class="text-sm font-medium text-amber-600 hover:text-amber-700 flex items-center gap-1 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Surat Pengajuan
                                </a>
                            </div>

                        @else
                            {{-- Empty or Rejected State --}}
                            @if($extension && $extension->status === 'rejected' && $extension->reason)
                                <div class="mb-4 bg-red-50 border border-red-100 p-3 rounded-lg flex gap-3 items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h5 class="text-sm font-bold text-red-800">Pengajuan Ditolak</h5>
                                        <p class="text-xs text-red-600 mt-1">{{ $extension->reason }}</p>
                                    </div>
                                </div>
                            @endif

                             <div class="mt-2 flex items-center justify-between bg-slate-50 dark:bg-slate-800/50 p-4 rounded-lg border border-slate-100 dark:border-slate-800">
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    Masa magang berakhir pada <span class="font-bold text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</span>.
                                </div>
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'extension-modal')" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm hover:shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ $extension && $extension->status === 'rejected' ? 'Ajukan Ulang' : 'Upload Surat' }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Completion Documents (Visible if Finished or Docs Exist) --}}
                @php
                    $certificate = $internship->documents->where('type', 'sertifikat_kelulusan')->first();
                    $assessment = $internship->documents->where('type', 'laporan_penilaian_pkl')->first();
                @endphp

                @if($certificate || $assessment)
                <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-emerald-500/10 rounded-xl hover:bg-green-100 dark:hover:bg-emerald-500/20 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 dark:bg-emerald-500/20 text-green-600 dark:text-emerald-400 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800 dark:text-slate-100">Dokumen Kelulusan</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Download sertifikat dan penilaian magang</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @if($certificate)
                            <a href="{{ Storage::url($certificate->file_path) }}" target="_blank" class="text-sm font-semibold text-green-600 dark:text-emerald-400 border border-green-200 dark:border-emerald-800 px-4 py-2 rounded-xl hover:bg-green-50 dark:hover:bg-emerald-900/40 transition-colors">
                                Sertifikat
                            </a>
                        @endif
                        @if($assessment)
                            <a href="{{ Storage::url($assessment->file_path) }}" target="_blank" class="text-sm font-semibold text-green-600 dark:text-emerald-400 border border-green-200 dark:border-emerald-800 px-4 py-2 rounded-xl hover:bg-green-50 dark:hover:bg-emerald-900/40 transition-colors">
                                Penilaian
                            </a>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Final Report --}}
                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800 dark:text-slate-100">Laporan Akhir</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Upload laporan final setelah selesai magang</p>
                        </div>
                    </div>
                    <button onclick="openFinalReportModal()" 
                            @if(!$isFinished) disabled title="Dapat diakses setelah magang selesai" class="opacity-50 cursor-not-allowed text-sm font-semibold text-slate-400 dark:text-slate-500 border border-slate-200 dark:border-slate-800 px-5 py-2.5 rounded-xl transition-all" @else class="text-sm font-semibold text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800 px-5 py-2.5 rounded-xl hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-all shadow-sm" @endif>
                        Upload Laporan
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MODALS --}}

    {{-- 1. Extension Modal --}}
    <x-modal name="extension-modal" :show="$errors->has('end_date') || $errors->has('file')" focusable>
        <form action="{{ route('documents.storeExtension') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 p-8 sm:p-10 rounded-[2.5rem] relative overflow-hidden transition-colors duration-300"
              x-data="{ 
                originalEndDate: '{{ $internship->end_date }}',
                endDate: '{{ old('end_date') }}',
                fileName: '',
                get duration() {
                    if (!this.endDate) return '';
                    const start = new Date(this.originalEndDate);
                    start.setDate(start.getDate() + 1); // Extension starts day after
                    const end = new Date(this.endDate);
                    if (end < start) return 'Tanggal tidak valid';
                    
                    const diffTime = Math.abs(end - (new Date(this.originalEndDate)));
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Diff from original end
                    
                    const months = Math.floor(diffDays / 30);
                    const days = diffDays % 30;
                    
                    let text = '';
                    if (months > 0) text += months + ' Bulan ';
                    if (days > 0) text += days + ' Hari';
                    
                    return text + ' (' + diffDays + ' Hari Tambahan)';
                }
              }">
            @csrf
            
            {{-- Decorative Background Glimmer --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 dark:bg-amber-500/5 rounded-full -mr-32 -mt-32 blur-[80px]"></div>

            <div class="flex items-center justify-between mb-8 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="bg-amber-100 dark:bg-amber-500/20 p-3 rounded-2xl text-amber-600 dark:text-amber-400 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight leading-tight">
                            {{ __('Pengajuan Perpanjangan') }}
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest mt-1">Status: Active Intern</p>
                    </div>
                </div>
                <button type="button" x-on:click="$dispatch('close-modal', 'extension-modal')" class="text-slate-400 hover:text-red-500 transition-all bg-slate-50 dark:bg-slate-800 p-2 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 active:scale-90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Timeline Visual --}}
            <div class="mb-10 relative z-10 px-4">
                <div class="absolute inset-x-0 top-6 h-1 bg-slate-100 dark:bg-slate-800 rounded-full shadow-inner"></div>
                <div class="relative flex justify-between">
                    {{-- Start --}}
                    <div class="flex flex-col items-center gap-3 group">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 shadow-md flex items-center justify-center text-slate-400 dark:text-slate-500 z-10 transition-all group-hover:scale-110 group-hover:rotate-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest flex items-center gap-1 justify-center">
                                <span class="w-1 h-1 bg-slate-400 dark:bg-slate-600 rounded-full"></span> Selesai Awal
                            </p>
                            <p class="text-sm font-black text-slate-800 dark:text-slate-200 mt-1 font-mono tracking-tight">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    {{-- Arrow --}}
                    <div class="flex items-center text-slate-300 dark:text-slate-700 mt-[-3rem]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>

                    {{-- Target --}}
                    <div class="flex flex-col items-center gap-3 group">
                         <div class="w-12 h-12 rounded-2xl bg-amber-500 dark:bg-amber-600 border-4 border-amber-50 dark:border-amber-900 shadow-xl shadow-amber-500/20 flex items-center justify-center text-white z-10 transition-all group-hover:scale-110 group-hover:-rotate-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-amber-600 dark:text-amber-400 font-black uppercase tracking-widest flex items-center gap-1 justify-center">
                                <span class="w-1 h-1 bg-amber-500 rounded-full animate-ping"></span> Target Baru
                            </p>
                            <p class="text-sm font-black text-amber-600 dark:text-amber-400 mt-1 font-mono tracking-tight" x-text="endDate ? new Date(endDate).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Date Input --}}
                <div class="relative z-10">
                    <x-input-label for="end_date" :value="__('Perpanjang Hingga Tanggal')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1" />
                     <div class="relative mt-1 group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date" 
                               id="end_date" 
                               name="end_date" 
                               x-model="endDate"
                               min="{{ \Carbon\Carbon::parse($internship->end_date)->addDays(2)->toDateString() }}"
                               class="block w-full pl-12 pr-4 py-3.5 bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-slate-800 focus:border-amber-500 focus:ring-amber-500 rounded-2xl shadow-sm sm:text-sm transition-all font-bold text-slate-800 dark:text-slate-200" 
                               required>
                    </div>
                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                </div>

                {{-- Duration Card --}}
                <div x-show="duration && endDate" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     class="bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-500/10 dark:to-transparent rounded-2xl border-2 border-amber-100 dark:border-amber-900/40 p-5 flex items-center gap-5 relative z-10 shadow-lg shadow-amber-500/5">
                    <div class="bg-white dark:bg-amber-500/20 p-3 rounded-xl text-amber-600 dark:text-amber-400 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-amber-600 dark:text-amber-500 uppercase tracking-widest mb-1 leading-none">Estimasi Durasi Tambahan</p>
                        <p class="text-xl font-black text-slate-800 dark:text-slate-100 tracking-tight" x-text="duration"></p>
                    </div>
                </div>

                {{-- File Upload --}}
                <div class="relative z-10">
                    <x-input-label for="file" :value="__('File Surat Disposisi (PDF)')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1" />
                    <div class="mt-2 flex justify-center px-6 pt-10 pb-10 border-2 border-slate-200 dark:border-slate-800 border-dashed rounded-[2rem] transition-all hover:border-amber-400 hover:bg-amber-50/30 dark:hover:bg-amber-500/10 hover:shadow-xl group relative cursor-pointer bg-slate-50/50 dark:bg-slate-950/20">
                        <input id="file" name="file" type="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" required @change="fileName = $event.target.files[0].name">
                        <div class="space-y-3 text-center transition-transform group-hover:scale-105 duration-300">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-600 group-hover:text-amber-500 group-hover:bg-amber-50 dark:group-hover:bg-amber-500/10 transition-all shadow-sm">
                                <svg class="w-8 h-8" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex flex-col text-sm text-slate-600 dark:text-slate-400">
                                <span class="relative font-black text-slate-800 dark:text-slate-200">
                                    <span x-show="!fileName">Klik atau seret file ke sini</span>
                                    <span x-show="fileName" x-text="fileName" class="text-amber-600 dark:text-amber-400 underline underline-offset-4 decoration-amber-500/30"></span>
                                </span>
                                <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest font-black" x-show="!fileName">Format: PDF (Max. 5MB)</p>
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>

                {{-- Warning Alert --}}
                <div class="rounded-2xl bg-red-50 dark:bg-red-500/10 p-5 border-2 border-red-100 dark:border-red-900/30 flex gap-4 relative z-10 shadow-sm transition-all hover:shadow-md">
                    <div class="shrink-0 bg-white dark:bg-red-500/20 p-2 rounded-xl text-red-500 dark:text-red-400 shadow-sm border border-red-100 dark:border-red-900/40">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-black text-red-800 dark:text-red-300 uppercase tracking-tight">Penting untuk Diketahui</h3>
                        <p class="mt-1 text-xs text-red-700/80 dark:text-red-400 font-bold leading-relaxed">
                            Pengajuan harus dilakukan maksimal <span class="underline decoration-red-500/30 font-black">H-7</span> sebelum masa magang berakhir. Pastikan data lampiran sudah sesuai.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3 relative z-10 border-t border-slate-100 dark:border-slate-800 pt-8">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'extension-modal')" type="button" class="w-full sm:w-auto justify-center rounded-2xl py-3 border-2 border-slate-200 dark:border-slate-800">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-primary-button class="w-full sm:w-auto justify-center bg-gradient-to-r from-amber-600 to-amber-500 dark:from-amber-600 dark:to-amber-700 hover:shadow-xl hover:shadow-amber-500/30 rounded-2xl py-3 border-b-4 border-amber-800/50 shadow-lg active:scale-95 transition-all">
                    {{ __('Ajukan Perpanjangan') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- 2. Final Report Modal --}}
    <div id="finalReportModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal('finalReportModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl dark:shadow-slate-950/80 transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100 dark:border-slate-800">
                <form action="{{ route('documents.storeFinalReport') }}" method="POST" enctype="multipart/form-data" class="p-8 relative">
                    {{-- Glimmer --}}
                    <div class="absolute top-0 right-0 w-48 h-48 bg-purple-500/10 dark:bg-purple-500/5 rounded-full -mr-24 -mt-24 blur-[60px]"></div>

                    @csrf
                    <div class="flex justify-between items-center mb-6 relative">
                        <div class="flex items-center gap-3">
                             <div class="bg-purple-100 dark:bg-purple-500/20 p-2.5 rounded-xl text-purple-600 dark:text-purple-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25" />
                                </svg>
                             </div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-slate-100 uppercase tracking-tight">Upload Laporan</h3>
                        </div>
                        <button type="button" onclick="closeModal('finalReportModal')" class="text-slate-400 hover:text-red-500 transition-all p-1.5 bg-slate-50 dark:bg-slate-800 rounded-lg active:scale-90">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="mb-8 relative" x-data="{ fileName: '' }">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-3 ml-1">Pilih File Laporan (PDF)</label>
                        <div class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-slate-100 dark:border-slate-800 border-dashed rounded-3xl group transition-all hover:bg-purple-50 dark:hover:bg-purple-500/5 hover:border-purple-400 relative cursor-pointer shadow-inner bg-slate-50/50 dark:bg-slate-950/20">
                            <input type="file" name="file" accept=".pdf" class="absolute inset-0 opacity-0 cursor-pointer z-10" required @change="fileName = $event.target.files[0].name">
                            <div class="text-center space-y-3">
                                <div class="inline-flex items-center justify-center w-14 h-14 bg-white dark:bg-slate-800 rounded-2xl text-slate-400 dark:text-slate-600 group-hover:text-purple-500 transition-all shadow-sm">
                                     <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                </div>
                                <div class="text-xs text-slate-600 dark:text-slate-400">
                                    <span x-show="!fileName" class="font-bold block text-slate-800 dark:text-slate-200">Klik untuk upload lampiran</span>
                                    <span x-show="fileName" x-text="fileName" class="font-black text-purple-600 dark:text-purple-400 underline decoration-purple-500/30 font-mono"></span>
                                    <p class="mt-1 opacity-60 font-medium" x-show="!fileName">Ukuran file maksimal 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-primary-button class="w-full justify-center bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-600 dark:to-indigo-700 hover:shadow-xl hover:shadow-purple-500/20 rounded-2xl py-3 border-b-4 border-purple-800/50 shadow-lg active:scale-95 transition-all">
                            {{ __('Submit Laporan Akhir') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 3. Monthly Report Modal --}}
    <div id="monthlyReportModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal('monthlyReportModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl dark:shadow-slate-950/80 transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full border border-slate-100 dark:border-slate-800">
                <form action="{{ route('attendance.report') }}" method="GET" target="_blank" class="p-8 relative">
                    {{-- Decorative Glow --}}
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 dark:bg-blue-500/5 rounded-full -mr-16 -mt-16 blur-[40px]"></div>

                    <div class="flex justify-between items-center mb-6 relative">
                        <div class="flex items-center gap-3">
                             <div class="bg-blue-100 dark:bg-blue-500/20 p-2.5 rounded-xl text-blue-600 dark:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                             </div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-slate-100 uppercase tracking-tight">Unduh Laporan</h3>
                        </div>
                        <button type="button" onclick="closeModal('monthlyReportModal')" class="text-slate-400 hover:text-red-500 transition-all p-1.5 bg-slate-50 dark:bg-slate-800 rounded-lg active:scale-90">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
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
                            <div class="relative bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden transition-colors">
                                <select name="period_selector" onchange="const vals = this.value.split('-'); document.getElementById('report_month').value = vals[0]; document.getElementById('report_year').value = vals[1];" 
                                    class="w-full bg-transparent border-none focus:ring-0 sm:text-sm py-4 pl-5 pr-12 font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest cursor-pointer !appearance-none relative z-10 transition-colors [&::-ms-expand]:hidden" style="background-image: none;">
                                    @foreach($options as $option)
                                        <option value="{{ $option['month'] }}-{{ $option['year'] }}" class="font-bold bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200">{{ $option['label'] }}</option>
                                    @endforeach
                                </select>
                                
                                {{-- Chevron Icon Custom --}}
                                <div class="absolute inset-y-0 right-0 flex items-center pr-5 pointer-events-none text-blue-500 bg-gradient-to-l from-white dark:from-slate-900 via-white dark:via-slate-900 to-transparent pl-4">
                                    <svg class="h-5 w-5 opacity-70 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="month" id="report_month" value="{{ $options[0]['month'] ?? date('n') }}">
                        <input type="hidden" name="year" id="report_year" value="{{ $options[0]['year'] ?? date('Y') }}">
                    </div>

                    <div class="flex flex-col gap-3 relative">
                        <x-primary-button class="w-full justify-center bg-gradient-to-r from-blue-600 to-blue-500 dark:from-blue-600 dark:to-blue-700 hover:shadow-xl hover:shadow-blue-500/20 rounded-2xl py-3.5 border-b-4 border-blue-800/50 shadow-lg active:scale-95 transition-all text-sm tracking-widest mb-2 font-black">
                            {{ __('CETAK LAPORAN SEKARANG') }}
                        </x-primary-button>
                        <p class="text-center text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">Format: PDF | Auto-generated</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openFinalReportModal() { document.getElementById('finalReportModal').classList.remove('hidden'); }
        function openMonthlyReportModal() { document.getElementById('monthlyReportModal').classList.remove('hidden'); }
        
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</x-app-layout>
