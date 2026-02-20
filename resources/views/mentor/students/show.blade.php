<x-app-layout>
    {{-- LOAD LIBRARY SWEETALERT --}}
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

            <!-- 1. Header Card: Identity & Status -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Photo -->
                <div class="shrink-0">
                    @if($internship->student->studentProfile && $internship->student->studentProfile->photo)
                        <img class="h-28 w-28 rounded-full object-cover shadow-md border-4 border-slate-50" src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" alt="{{ $internship->student->name }}">
                    @else
                        <div class="h-28 w-28 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white text-4xl font-bold shadow-md border-4 border-slate-50">
                            {{ substr($internship->student->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="grow text-center md:text-left space-y-2">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">{{ $internship->student->name }}</h1>
                        <p class="text-slate-500 font-medium">{{ $internship->student->email }}</p>
                    </div>

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

                <!-- Action / Grading -->
                <div class="shrink-0">
                    @if($internship->evaluation)
                         <div class="text-center md:text-right">
                            <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Nilai Akhir</span>
                            <span class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 text-emerald-800 rounded-2xl font-bold text-2xl border border-emerald-200 shadow-sm">
                                {{ $internship->evaluation->final_score }}
                            </span>
                         </div>
                    @else
                        <a href="{{ route('mentor.evaluations.create', $internship->id) }}" 
                           class="group inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all hover:scale-105 active:scale-95 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Input Nilai Akhir
                        </a>
                    @endif
                </div>
            </div>

            <!-- 2. Logbook History (Standardized) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h3 id="logbook-section" class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-red-600 rounded-full"></span>
                        Riwayat Logbook Harian
                    </h3>
                     <!-- Filter/Search could go here -->
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-white border-b border-slate-100 text-slate-500 uppercase tracking-wider text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Aktivitas</th>
                                <th class="px-6 py-4">Bukti</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($internship->dailyLogbooks as $logbook)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($logbook->date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 max-w-sm truncate" title="{{ strip_tags($logbook->activity) }}">
                                        {{ Str::limit(strip_tags($logbook->activity), 60) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($logbook->evidence)
                                            <a href="{{ Storage::url($logbook->evidence) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs bg-blue-50 px-2 py-1 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-slate-400 text-xs italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$logbook->status" />
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                         @if($logbook->status == 'pending')
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- Approve --}}
                                                <form action="{{ route('mentor.logbooks.approve', $logbook->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="p-2 bg-emerald-100 text-emerald-600 rounded-lg hover:bg-emerald-200 transition-colors" title="Setujui">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                {{-- Reject Button (Trigger Modal) --}}
                                                <button onclick="openRejectModal('{{ $logbook->id }}')" class="p-2 bg-rose-100 text-rose-600 rounded-lg hover:bg-rose-200 transition-colors" title="Tolak">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400 font-medium">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-slate-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                            <p>Belum ada logbook.</p>
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


    {{-- REJEcT MODAL (Keep existing logic if any, or add minimal one) --}}
    <!-- Modal Reject Logbook -->
    <div id="rejectModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Logbook</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Berikan alasan penolakan agar mahasiswa dapat memperbaiki logbook.</p>
                                    <textarea name="mentor_note" rows="3" class="mt-2 shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md" required placeholder="Contoh: Bukti kurang jelas..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Kirim Penolakan
                        </button>
                        <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            let form = document.getElementById('rejectForm');
            form.action = '/mentor/logbooks/' + id + '/reject'; // Adjust route as needed
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>