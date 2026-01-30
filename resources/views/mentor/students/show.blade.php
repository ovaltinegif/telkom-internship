<x-app-layout>
    {{-- 1. LOAD LIBRARY SWEETALERT --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Detail Mahasiswa') }}
                </h2>
                <p class="text-slate-500 text-sm">Lihat profil dan rekap aktivitas magang</p>
            </div>
            <a href="{{ route('mentor.students.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-red-600 transition-colors bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm hover:shadow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 2. PROFILE CARD --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-bl-[100px] -z-0"></div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between gap-8">
                    
                    {{-- Student Info --}}
                    <div class="flex items-start gap-6">
                        <div class="h-24 w-24 rounded-2xl bg-gradient-to-tr from-slate-200 to-white border-2 border-white shadow-lg flex items-center justify-center text-4xl font-bold text-slate-400">
                            {{ substr($internship->student->name, 0, 1) }}
                        </div>
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-3xl font-bold text-slate-800">{{ $internship->student->name }}</h3>
                                <p class="text-slate-500">{{ $internship->student->email }}</p>
                            </div>
                            
                            <div class="flex flex-wrap gap-4">
                                <div class="px-4 py-2 bg-slate-50 rounded-xl border border-slate-100">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Universitas</p>
                                    <p class="font-semibold text-slate-700">{{ $internship->student->studentProfile->university ?? '-' }}</p>
                                </div>
                                <div class="px-4 py-2 bg-blue-50 rounded-xl border border-blue-100">
                                    <p class="text-xs text-blue-400 uppercase tracking-wider font-bold mb-1">Divisi</p>
                                    <p class="font-bold text-blue-700">{{ $internship->division->name }}</p>
                                </div>
                                <div class="px-4 py-2 bg-indigo-50 rounded-xl border border-indigo-100">
                                    <p class="text-xs text-indigo-400 uppercase tracking-wider font-bold mb-1">Total Logbook</p>
                                    <p class="font-bold text-indigo-700">{{ $internship->dailyLogbooks->count() }} Aktivitas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action / Grading --}}
                    <div class="flex flex-col items-end justify-center">
                        @if($internship->evaluation)
                             <div class="text-right">
                                <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Nilai Akhir</span>
                                <span class="inline-flex items-center px-5 py-2 bg-emerald-100 text-emerald-800 rounded-xl font-bold text-xl border border-emerald-200 shadow-sm">
                                    {{ $internship->evaluation->final_score }}
                                </span>
                             </div>
                        @else
                            <a href="{{ route('mentor.evaluations.create', $internship->id) }}" 
                               class="group inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all hover:scale-105 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Input Nilai Akhir
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 3. LOGBOOK HISTORY --}}
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
                                        <p class="text-slate-800 leading-relaxed">{{ $logbook->activity }}</p>
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
        // ... (Script remains roughly the same, styles updated by UI library automatically) ...
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
</x-app-layout>