<x-app-layout>
    {{-- 1. LOAD LIBRARY SWEETALERT --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Detail Intern') }}
                </h2>
                <p class="text-slate-500 text-sm">Lihat profil dan rekap aktivitas intern</p>
            </div>
             <a href="{{ route('mentor.students.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 2. PROFILE CARD --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row items-center md:items-center gap-6">
                {{-- Photo --}}
                <div class="shrink-0">
                    @if($internship->student->studentProfile && $internship->student->studentProfile->photo)
                        <img class="h-28 w-28 rounded-full object-cover shadow-md border-4 border-slate-50" src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" alt="{{ $internship->student->name }}">
                    @else
                        <div class="h-28 w-28 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white text-4xl font-bold shadow-md border-4 border-slate-50">
                            {{ substr($internship->student->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="grow text-center md:text-left space-y-2">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">{{ $internship->student->name }}</h1>
                        <p class="text-slate-500 font-medium">{{ $internship->student->email }}</p>
                    </div>

                    {{-- MERGED: INFO STATS FROM INCOMING CHANGE --}}
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
                         <div class="px-3 py-1 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-0.5">Universitas</p>
                            <p class="font-semibold text-slate-700 text-sm">{{ $internship->student->studentProfile->university ?? '-' }}</p>
                        </div>
                        <div class="px-3 py-1 bg-blue-50 rounded-lg border border-blue-100">
                            <p class="text-xs text-blue-400 uppercase tracking-wider font-bold mb-0.5">Divisi</p>
                            <p class="font-bold text-blue-700 text-sm">{{ $internship->division->name }}</p>
                        </div>
                         <div class="px-3 py-1 bg-indigo-50 rounded-lg border border-indigo-100">
                            <p class="text-xs text-indigo-400 uppercase tracking-wider font-bold mb-0.5">Total Logbook</p>
                            <p class="font-bold text-indigo-700 text-sm">{{ $internship->dailyLogbooks->count() }} Aktivitas</p>
                        </div>
                    </div>
                    </div>

                {{-- Action / Grading --}}
                <div class="shrink-0 md:ml-auto flex flex-col items-center md:items-end justify-center">
                        @if($internship->evaluation)
                             <div class="text-left">
                                <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Nilai Akhir</span>
                                <span class="inline-flex items-center px-5 py-2 bg-emerald-100 text-emerald-800 rounded-xl font-bold text-xl border border-emerald-200 shadow-sm">
                                    {{ $internship->evaluation->final_score }}
                                </span>
                             </div>
                        @else
                            @php
                                $canInputGrade = \Carbon\Carbon::parse($internship->end_date)->subDays(7)->lte(\Carbon\Carbon::now());
                                $daysRemaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($internship->end_date), false);
                            @endphp

                            @if($canInputGrade)
                                <a href="{{ route('mentor.evaluations.create', $internship->id) }}" 
                                   class="group inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all hover:scale-105 active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Input Nilai Akhir
                                </a>
                            @else
                                <button disabled class="group inline-flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-400 font-bold rounded-xl border border-slate-200 cursor-not-allowed" title="Penilaian baru dibuka 7 hari sebelum magang selesai">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    Input Nilai Terkunci
                                </button>
                                <p class="text-xs text-slate-400 mt-2 text-left">
                                    Terbuka dalam {{ ceil($daysRemaining - 7) }} hari lagi
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

            {{-- 3. TRANSKRIP NILAI --}}
            @if($internship->evaluation)
            <div x-data="{ show: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">Transkrip Nilai Magang</h3>
                        <p class="text-sm text-slate-500">Hasil evaluasi akhir kegiatan magang</p>
                    </div>
                    <div class="flex gap-3">
                        <button @click="show = !show" class="text-sm font-semibold text-slate-600 bg-white border border-slate-300 px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                             <span x-text="show ? 'Sembunyikan' : 'Lihat Transkrip'"></span>
                        </button>
                        <a href="{{ route('mentor.students.transcript', $internship->id) }}" target="_blank" class="text-sm font-semibold text-white bg-blue-600 border border-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015-1.837-2.175a48.041 48.041 0 00-1.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                            Cetak Transkrip
                        </a>
                    </div>
                </div>
                {{-- Table (Collapsible) --}}
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

            {{-- 4. DOKUMEN & LAPORAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 p-6 space-y-4">
                <h3 class="font-bold text-lg text-slate-800 mb-2">Dokumen & Laporan</h3>
                
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
                            <p class="text-sm text-slate-500">Cetak rekap kehadiran & logbook mahasiswa</p>
                        </div>
                    </div>
                    <button onclick="openMonthlyReportModal()" class="text-sm font-semibold text-blue-600 border border-blue-200 px-5 py-2.5 rounded-xl hover:bg-blue-50 transition-colors">
                        Unduh Laporan
                    </button>
                </div>

                {{-- Final Report --}}
                @php $finalReport = $internship->documents->where('type', 'laporan_akhir')->first(); @endphp
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="bg-purple-100 text-purple-600 p-3 rounded-xl">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Laporan Akhir</h4>
                            <p class="text-sm text-slate-500">File laporan final yang diupload mahasiswa</p>
                        </div>
                    </div>
                    @if($finalReport)
                        <a href="{{ Storage::url($finalReport->file_path) }}" target="_blank" class="text-sm font-semibold text-purple-600 border border-purple-200 px-5 py-2.5 rounded-xl hover:bg-purple-50 transition-colors">
                            Download PDF
                        </a>
                    @else
                         <span class="text-xs font-semibold text-slate-400 border border-slate-200 px-4 py-2 rounded-xl bg-slate-50 cursor-not-allowed">
                            Belum Ada
                        </span>
                    @endif
                </div>
            </div>

            {{-- 5. LOGBOOK HISTORY --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-6">
                    <h3 id="logbook-section" class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 scroll-mt-24">
                        <span class="w-2 h-6 bg-red-600 rounded-full"></span>
                        Riwayat Logbook Harian
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs">Tanggal</th>
                                    <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs w-1/3">Aktivitas</th>
                                    <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs">Bukti</th>
                                    <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs">Status</th>
                                    <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs text-center w-64">Penilaian Mentor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($internship->dailyLogbooks as $logbook)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-700 align-top">
                                        {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="text-slate-800 leading-relaxed trix-content">
                                            {!! $logbook->activity !!}
                                        </div>
                                        @if($logbook->mentor_note)
                                            <div class="mt-2 text-xs font-medium text-indigo-600 bg-indigo-50 p-2 rounded-lg border border-indigo-100 inline-block">
                                                💬 Note: {{ $logbook->mentor_note }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        @if($logbook->evidence)
                                            <a href="{{ asset('storage/' . $logbook->evidence) }}" target="_blank" 
                                               class="inline-flex items-center gap-1 text-xs font-bold text-white bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-lg transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 8.201 2.372 9.336 6.404.186.66.186 1.35 0 2.01C18.201 15.428 14.257 17.8 10 17.8c-4.257 0-8.201-2.372-9.336-6.404zM6 10a4 4 0 118 0 4 4 0 01-8 0z" clip-rule="evenodd" />
                                                </svg>
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-slate-400 text-xs italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        @if($logbook->status == 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Approved
                                            </span>
                                        @elseif($logbook->status == 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                 <span class="w-1.5 h-1.5 bg-rose-500 rounded-full mr-1.5"></span> Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                 <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span> Pending
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center align-top">
                                        @if($logbook->status == 'pending')
                                            <form action="{{ route('mentor.logbook.update', $logbook->id) }}" method="POST" class="flex flex-col gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <input type="text" name="mentor_note" placeholder="Tulis catatan (Opsional)..." 
                                                       class="text-xs border-slate-200 rounded-lg px-3 py-2 w-full focus:ring-red-500 focus:border-red-500 bg-white" 
                                                       value="{{ $logbook->mentor_note }}">
                                                
                                                <div class="grid grid-cols-2 gap-2">
                                                    <button type="button" data-status="approved" class="btn-action bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold px-3 py-2 rounded-lg text-xs transition shadow-sm border border-emerald-200">
                                                        ✓ Terima
                                                    </button>
                                                    <button type="button" data-status="rejected" class="btn-action bg-white hover:bg-rose-50 text-rose-600 font-bold px-3 py-2 rounded-lg text-xs transition shadow-sm border border-slate-200 hover:border-rose-200">
                                                        ✕ Tolak
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <div class="text-xs text-slate-400 font-medium italic py-2">
                                                Telah divalidasi
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        Belum ada logbook yang disubmit.
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
                        title: isApproved ? 'Terima Logbook?' : 'Tolak Logbook?',
                        text: isApproved 
                            ? "Status logbook akan berubah menjadi Approved." 
                            : "Logbook akan ditolak. Pastikan Anda sudah memberikan catatan.",
                        icon: isApproved ? 'question' : 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonColor: isApproved ? '#10b981' : '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: isApproved ? 'Ya, Terima' : 'Ya, Tolak',
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
    <div id="monthlyReportModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('monthlyReportModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                <form action="{{ route('mentor.students.monthlyReport', $internship->id) }}" method="GET" target="_blank" class="p-6">
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
                        <button type="button" onclick="document.getElementById('monthlyReportModal').classList.add('hidden')" class="py-2 px-4 border rounded-md text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openMonthlyReportModal() {
            document.getElementById('monthlyReportModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>