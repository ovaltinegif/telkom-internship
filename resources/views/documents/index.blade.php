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
                @if(!$isFinished)
                    @php
                        $extension = $internship->documents->where('type', 'perpanjangan_magang')->first();
                    @endphp
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-amber-100 text-amber-600 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Perpanjangan Magang</h4>
                            <p class="text-sm text-slate-500">Ajukan surat perpanjangan masa magang</p>
                        </div>
                    </div>
                    @if($extension)
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">
                                Sudah Diajukan
                            </span>
                             <a href="{{ Storage::url($extension->file_path) }}" target="_blank" class="text-sm font-semibold text-amber-600 border border-amber-200 px-4 py-2 rounded-xl hover:bg-amber-50 transition-colors">
                                Lihat Surat
                            </a>
                        </div>
                    @else
                        <button onclick="openExtensionModal()" class="text-sm font-semibold text-amber-600 border border-amber-200 px-5 py-2.5 rounded-xl hover:bg-amber-50 transition-colors">
                            Upload Surat
                        </button>
                    @endif
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
    <div id="extensionModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('extensionModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <form action="{{ route('documents.storeExtension') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Surat Perpanjangan</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">File Surat (PDF)</label>
                        <input type="file" name="file" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" required>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('extensionModal')" class="py-2 px-4 border rounded-md text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit" class="py-2 px-4 bg-amber-600 text-white rounded-md hover:bg-amber-700">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. Final Report Modal --}}
    <div id="finalReportModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
    <div id="monthlyReportModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('monthlyReportModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                <form action="{{ route('attendance.report') }}" method="GET" target="_blank" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Laporan Bulanan</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bulan</label>
                            <select name="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun</label>
                            <select name="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                                <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                            </select>
                        </div>
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
        function openExtensionModal() { document.getElementById('extensionModal').classList.remove('hidden'); }
        function openFinalReportModal() { document.getElementById('finalReportModal').classList.remove('hidden'); }
        function openMonthlyReportModal() { document.getElementById('monthlyReportModal').classList.remove('hidden'); }
        
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</x-app-layout>
