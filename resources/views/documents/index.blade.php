<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Dokumen & Laporan') }}
            </h2>
            <p class="text-slate-500 text-sm">Kelola arsip dokumen dan laporan magangmu</p>
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
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 p-8 space-y-6">
                
                {{-- Transcript Display (Hidden by Default) --}}
                @if($internship->evaluation)
                <div x-data="{ show: false }" class="bg-white overflow-hidden shadow-md sm:rounded-2xl border border-slate-200">
                    
                    {{-- Header / Unlock Section --}}
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800">Transkrip Nilai Magang</h3>
                            <p class="text-sm text-slate-500">Hasil evaluasi akhir kegiatan magang Anda</p>
                        </div>
                        
                        <div class="flex gap-3">
                            <button @click="show = !show" class="text-sm font-semibold text-slate-600 bg-white border border-slate-300 px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
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
                    <div x-show="show" x-transition class="border-t border-slate-100">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 w-12 text-center">No</th>
                                    <th class="px-6 py-4">Komponen Penilaian</th>
                                    <th class="px-6 py-4 w-32 text-center">Nilai Angka</th>
                                    <th class="px-6 py-4 w-32 text-center">Predikat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                <tr>
                                    <td class="px-6 py-4 text-center">1</td>
                                    <td class="px-6 py-4">Kedisiplinan & Etika Kerja</td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $internship->evaluation->discipline_score }}</td>
                                    <td class="px-6 py-4 text-center">{{ $internship->evaluation->discipline_score >= 85 ? 'A' : ($internship->evaluation->discipline_score >= 70 ? 'B' : 'C') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-center">2</td>
                                    <td class="px-6 py-4">Kemampuan Teknis & Hasil Kerja</td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $internship->evaluation->technical_score }}</td>
                                    <td class="px-6 py-4 text-center">{{ $internship->evaluation->technical_score >= 85 ? 'A' : ($internship->evaluation->technical_score >= 70 ? 'B' : 'C') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-center">3</td>
                                    <td class="px-6 py-4">Komunikasi & Kerjasama Tim</td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $internship->evaluation->soft_skill_score }}</td>
                                    <td class="px-6 py-4 text-center">{{ $internship->evaluation->soft_skill_score >= 85 ? 'A' : ($internship->evaluation->soft_skill_score >= 70 ? 'B' : 'C') }}</td>
                                </tr>
                                <tr class="bg-emerald-50/50">
                                    <td colspan="2" class="px-6 py-4 text-right font-bold text-slate-800">Nilai Akhir Rata-Rata</td>
                                    <td class="px-6 py-4 text-center font-bold text-lg text-emerald-600 border-x border-emerald-100">{{ $internship->evaluation->final_score }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-lg text-emerald-600">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Monthly Report --}}
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0h18M5 10.5h14" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Laporan Bulanan</h4>
                            <p class="text-sm text-slate-500">Cetak rekap kehadiran & logbook bulanan</p>
                        </div>
                    </div>
                    <button onclick="openMonthlyReportModal()" class="text-sm font-semibold text-blue-600 border border-blue-200 px-5 py-2.5 rounded-xl hover:bg-blue-50 transition-colors">
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
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="bg-amber-50 text-amber-600 p-3 rounded-lg border border-amber-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-slate-800">Perpanjangan Magang</h4>
                                    <p class="text-sm text-slate-500">Ajukan perpanjangan jika membutuhkan waktu lebih lama.</p>
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
                            <div class="mt-6 bg-slate-50 rounded-2xl p-5 border border-slate-100 relative overflow-hidden">
                                {{-- Background Decoration --}}
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-amber-400/20 to-red-500/20 rounded-full blur-2xl"></div>

                                <div class="flex items-center justify-between mb-6 relative">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-white rounded-lg shadow-sm border border-slate-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="font-bold text-slate-700 text-sm">Skema Perpanjangan</h3>
                                    </div>
                                    <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-200 shadow-sm">
                                        +{{ \Carbon\Carbon::parse($extension->new_start_date)->diffInDays(\Carbon\Carbon::parse($extension->new_end_date)->addDay()) }} Hari
                                    </span>
                                </div>

                                {{-- Timeline Container --}}
                                <div class="relative pt-2">
                                    <div class="h-3 bg-slate-200 rounded-full w-full flex overflow-hidden relative shadow-inner">
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
                                            <div class="flex items-center gap-1.5 mb-1 text-slate-400">
                                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">Mulai</span>
                                            </div>
                                            <div class="font-bold text-slate-800 font-mono">
                                                {{ \Carbon\Carbon::parse($internship->start_date)->format('d M y') }}
                                            </div>
                                        </div>

                                        {{-- Original End (Middle) --}}
                                        <div class="absolute left-2/3 -translate-x-1/2 -top-1 flex flex-col items-center group cursor-default w-auto whitespace-nowrap text-center">
                                            <div class="w-px h-4 bg-slate-300 group-hover:bg-blue-500 transition-colors mb-1"></div>
                                            <span class="text-[9px] text-slate-400 font-medium uppercase tracking-wide group-hover:text-blue-600 transition-colors">Selesai Normal</span>
                                            <div class="text-[10px] font-bold text-slate-500 font-mono group-hover:text-blue-700 transition-colors">
                                                {{ \Carbon\Carbon::parse($internship->end_date)->format('d M y') }}
                                            </div>
                                        </div>

                                        {{-- New End --}}
                                        <div class="flex flex-col items-end w-1/3">
                                            <div class="flex items-center gap-1.5 mb-1">
                                                <span class="text-[10px] font-bold text-red-600 uppercase tracking-wider">Target Baru</span>
                                                <span class="relative flex h-2 w-2">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                                </span>
                                            </div>
                                            <div class="font-bold text-red-600 font-mono bg-red-50 px-2 py-0.5 rounded border border-red-100 shadow-sm">
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

                             <div class="mt-2 flex items-center justify-between bg-slate-50 p-4 rounded-lg border border-slate-100">
                                <div class="text-sm text-slate-600">
                                    Masa magang berakhir pada <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</span>.
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
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Dokumen Kelulusan</h4>
                            <p class="text-sm text-slate-500">Download sertifikat dan penilaian magang</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @if($certificate)
                            <a href="{{ Storage::url($certificate->file_path) }}" target="_blank" class="text-sm font-semibold text-green-600 border border-green-200 px-4 py-2 rounded-xl hover:bg-green-50 transition-colors">
                                Sertifikat
                            </a>
                        @endif
                        @if($assessment)
                            <a href="{{ Storage::url($assessment->file_path) }}" target="_blank" class="text-sm font-semibold text-green-600 border border-green-200 px-4 py-2 rounded-xl hover:bg-green-50 transition-colors">
                                Penilaian
                            </a>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Final Report --}}
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-purple-100 text-purple-600 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Laporan Akhir</h4>
                            <p class="text-sm text-slate-500">Upload laporan final setelah selesai magang</p>
                        </div>
                    </div>
                    <button onclick="openFinalReportModal()" 
                            @if(!$isFinished) disabled title="Dapat diakses setelah magang selesai" class="opacity-50 cursor-not-allowed text-sm font-semibold text-slate-400 border border-slate-200 px-5 py-2.5 rounded-xl" @else class="text-sm font-semibold text-purple-600 border border-purple-200 px-5 py-2.5 rounded-xl hover:bg-purple-50 transition-colors" @endif>
                        Upload Laporan
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MODALS --}}

    {{-- 1. Extension Modal --}}
    <x-modal name="extension-modal" :show="$errors->has('end_date') || $errors->has('file')" focusable>
        <form action="{{ route('documents.storeExtension') }}" method="POST" enctype="multipart/form-data" class="p-8"
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
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 p-2 rounded-lg text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">
                        {{ __('Pengajuan Perpanjangan') }}
                    </h2>
                </div>
                <button type="button" x-on:click="$dispatch('close-modal', 'extension-modal')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Timeline Visual --}}
            <div class="mb-8 relative">
                <div class="absolute inset-0 top-1/2 -translate-y-1/2 flex items-center px-4">
                    <div class="w-full h-1 bg-slate-100 rounded-full"></div>
                </div>
                <div class="relative flex justify-between">
                    {{-- Start --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white shadow-sm flex items-center justify-center text-slate-400 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75l4 4a.75.75 0 101.06-1.06l-3.25-3.25V5.75z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-500 font-medium">Selesai Saat Ini</p>
                            <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    {{-- Arrow --}}
                    <div class="flex items-center text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>

                    {{-- Target --}}
                    <div class="flex flex-col items-center gap-2">
                         <div class="w-8 h-8 rounded-full bg-amber-100 border-2 border-amber-50 shadow-sm flex items-center justify-center text-amber-600 z-10 ring-2 ring-amber-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-amber-600 font-medium">Target Baru</p>
                            <p class="text-sm font-bold text-amber-600" x-text="endDate ? new Date(endDate).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Date Input --}}
                <div>
                    <x-input-label for="end_date" :value="__('Perpanjang Hingga Tanggal')" />
                     <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date" 
                               id="end_date" 
                               name="end_date" 
                               x-model="endDate"
                               min="{{ \Carbon\Carbon::parse($internship->end_date)->addDays(2)->toDateString() }}"
                               class="block w-full pl-10 pr-3 py-2.5 border-slate-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm sm:text-sm" 
                               required>
                    </div>
                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                </div>

                {{-- Duration Card --}}
                <div x-show="duration && endDate" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100 p-4 flex items-center gap-4">
                    <div class="bg-white/50 p-2.5 rounded-lg text-amber-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-0.5">Estimasi Durasi Tambahan</p>
                        <p class="text-lg font-bold text-slate-800" x-text="duration"></p>
                    </div>
                </div>

                {{-- File Upload --}}
                <div>
                    <x-input-label for="file" :value="__('File Surat Disposisi (PDF)')" />
                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl transition-colors hover:border-amber-400 hover:bg-amber-50/30 group relative cursor-pointer">
                        <input id="file" name="file" type="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required @change="fileName = $event.target.files[0].name">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-amber-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <span class="relative font-medium text-amber-600 hover:text-amber-500">
                                    <span x-show="!fileName">Upload a file</span>
                                    <span x-show="fileName" x-text="fileName" class="font-bold text-slate-800"></span>
                                </span>
                                <p class="pl-1" x-show="!fileName">or drag and drop</p>
                            </div>
                            <p class="text-xs text-slate-500" x-show="!fileName">PDF up to 5MB</p>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>

                {{-- Warning Alert --}}
                <div class="rounded-lg bg-red-50 p-4 border border-red-100 flex gap-3">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Perhatian</h3>
                        <div class="mt-1 text-sm text-red-700">
                            <p>Pengajuan harus dilakukan maksimal H-7 sebelum masa magang berakhir. Pastikan data yang Anda masukkan sudah benar.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'extension-modal')" type="button">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-primary-button class="bg-amber-600 hover:bg-amber-700 focus:ring-amber-500">
                    {{ __('Ajukan Perpanjangan') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- 2. Final Report Modal --}}
    <div id="finalReportModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('finalReportModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <form action="{{ route('documents.storeFinalReport') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Laporan Akhir</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">File Laporan (PDF)</label>
                        <input type="file" name="file" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" required>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('finalReportModal')" class="py-2 px-4 border rounded-md text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit" class="py-2 px-4 bg-purple-600 text-white rounded-md hover:bg-purple-700">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 3. Monthly Report Modal --}}
    <div id="monthlyReportModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('monthlyReportModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                <form action="{{ route('attendance.report') }}" method="GET" target="_blank" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Laporan Bulanan</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pilih Periode Laporan</label>
                        @php
                            $start = \Carbon\Carbon::parse($internship->start_date)->startOfMonth();
                            $end = \Carbon\Carbon::now()->startOfMonth();
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
                        @endphp
                        <select name="period_selector" onchange="const vals = this.value.split('-'); document.getElementById('report_month').value = vals[0]; document.getElementById('report_year').value = vals[1];" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @foreach($options as $option)
                                <option value="{{ $option['month'] }}-{{ $option['year'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="month" id="report_month" value="{{ date('n') }}">
                        <input type="hidden" name="year" id="report_year" value="{{ date('Y') }}">
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('monthlyReportModal')" class="py-2 px-4 border rounded-md text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">Cetak</button>
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
