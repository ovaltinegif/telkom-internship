<x-app-layout>
    <div x-data="{
        showModal: false,
        showPreview: false,
        previewUrl: '',
        selectedLogbook: { name: '', title: '', date: '', activity: '' },
        selectedIds: [],
        selectAll(event) {
            const checkboxes = document.querySelectorAll('.logbook-checkbox');
            this.selectedIds = event.target.checked ? Array.from(checkboxes).map(cb => cb.value) : [];
            checkboxes.forEach(cb => cb.checked = event.target.checked);
        }
    }">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight transition-colors">
            {{ __('Menunggu Persetujuan') }}
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm transition-colors">Validasi aktivitas harian mahasiswa bimbingan Anda</p>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-3xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-8 text-gray-900 dark:text-slate-200">

                    @if($pendingLogbooks->isEmpty())
                        <div class="text-center py-20 flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-emerald-50 dark:bg-emerald-500/10 rounded-3xl flex items-center justify-center mb-6 transition-colors shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-emerald-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight transition-colors">Semua Beres!</h3>
                            <p class="text-slate-500 dark:text-slate-500 font-medium mt-2">Tidak ada logbook yang perlu disetujui saat ini.</p>
                            <a href="{{ route('mentor.dashboard') }}" class="mt-8 inline-flex items-center px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition-all duration-200">
                                &larr; Kembali ke Dashboard
                            </a>
                        </div>
                    @else
                        <form action="{{ route('mentor.logbook.massApprove') }}" method="POST" id="massApproveForm">
                            @csrf
                            @method('PATCH')

                            <div x-show="selectedIds.length > 0"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="translate-y-full opacity-0"
                                 x-transition:enter-end="translate-y-0 opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="translate-y-0 opacity-100"
                                 x-transition:leave-end="translate-y-full opacity-0"
                                 class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[90] w-full max-w-lg px-4">
                                <div class="bg-slate-900/90 dark:bg-white/95 text-white dark:text-slate-900 rounded-3xl shadow-2xl p-5 flex items-center justify-between border border-white/10 dark:border-slate-200 backdrop-blur-xl">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-emerald-500 rounded-2xl p-3 shadow-lg shadow-emerald-500/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-black tracking-tight"><span x-text="selectedIds.length"></span> Aktivitas Terpilih</p>
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-black">Klik untuk menyetujui sekaligus</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                            onclick="confirmMassApprove()"
                                            class="bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white px-8 py-3 rounded-2xl text-sm font-black transition-all shadow-xl shadow-emerald-500/40 flex items-center gap-2">
                                        Setujui Massal
                                    </button>
                                </div>
                            </div>

                            <div class="mb-10 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-8 bg-red-600 dark:bg-red-500 rounded-full transition-colors"></div>
                                    <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight transition-colors">Daftar Aktivitas Pending</h3>
                                </div>
                                <div class="hidden md:block text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]" x-show="selectedIds.length === 0">
                                    Pilih Logbook untuk Aksi Massal
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                                    <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 w-10 text-center">
                                                <input type="checkbox" id="selectAll" @change="selectAll($event)" class="w-5 h-5 rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-red-600 focus:ring-red-500 focus:ring-offset-white dark:focus:ring-offset-slate-900 transition-all cursor-pointer shadow-sm">
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Intern</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Tanggal Aktivitas</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Judul Laporan</th>
                                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                        @foreach($pendingLogbooks as $logbook)
                                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="checkbox"
                                                           name="logbook_ids[]"
                                                           value="{{ $logbook->id }}"
                                                           @change="if($el.checked) { if(!selectedIds.includes('{{ $logbook->id }}')) selectedIds.push('{{ $logbook->id }}') } else { selectedIds = selectedIds.filter(id => id !== '{{ $logbook->id }}') }"
                                                           x-model="selectedIds"
                                                           class="logbook-checkbox w-5 h-5 rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-red-600 focus:ring-red-500 focus:ring-offset-white dark:focus:ring-offset-slate-900 transition-all cursor-pointer shadow-sm">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-300 transition-colors">{{ $logbook->internship->student->name }}</div>
                                                    <div class="text-xs font-bold uppercase tracking-widest mt-0.5 transition-colors text-slate-500 dark:text-slate-500">{{ $logbook->internship->division->name ?? '-' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300 transition-colors">{{ \Carbon\Carbon::parse($logbook->date)->translatedFormat('d F Y') }}</span>
                                                        <span class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widers mt-0.5 transition-colors">{{ \Carbon\Carbon::parse($logbook->date)->diffForHumans() }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex flex-col gap-1.5">
                                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300 transition-colors w-48 overflow-hidden overflow-ellipsis" title="{{ $logbook->title }}">
                                                            {{ $logbook->title ?? '-' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="flex items-center justify-center gap-3">
                                                        {{-- Approve Button --}}
                                                        <button type="button"
                                                                onclick="approveLogbook({{ $logbook->id }})"
                                                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                                                            Setujui
                                                        </button>
    
                                                        {{-- Detail Button --}}
                                                         <button type="button"
                                                                 @click="showModal = true; selectedLogbook = {
                                                                    name: '{{ addslashes($logbook->internship->student->name) }}',
                                                                    title: '{{ addslashes($logbook->title) }}',
                                                                    date: '{{ \Carbon\Carbon::parse($logbook->date)->translatedFormat('d F Y') }}',
                                                                    activity: {{ json_encode($logbook->activity) }},
                                                                    evidence: {{ $logbook->evidence ? "'" . Storage::url($logbook->evidence) . "'" : 'null' }}
                                                                 }"
                                                                 class="p-2.5 text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 bg-slate-50 dark:bg-slate-800 rounded-xl transition-all shadow-sm active:scale-95"
                                                                 title="Lihat Detail Aktivitas">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                </svg>
                                                         </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        <div class="mt-8 px-4">
                            {{ $pendingLogbooks->links() }}
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
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
                 class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-md" 
                 @click="showModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                
                <!-- Header -->
                <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-950/50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-50 dark:bg-red-500/10 rounded-2xl flex items-center justify-center text-red-600 dark:text-red-400 shadow-sm border border-red-100 dark:border-red-500/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 dark:text-slate-200 transition-colors leading-tight" x-text="selectedLogbook.title || 'Detail Aktivitas'">Detail Aktivitas</h3>
                            <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest transition-colors mt-0.5" x-text="'Oleh: ' + selectedLogbook.name + ' • ' + selectedLogbook.date"></p>
                        </div>
                    </div>
                    <button @click="showModal = false" class="w-10 h-10 rounded-2xl flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all shadow-sm">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-8 transition-colors bg-white dark:bg-slate-900">
                    <!-- Content -->
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 px-1">
                                <span class="w-2 h-2 bg-red-600 dark:bg-red-500 rounded-full shadow-[0_0_10px_rgba(220,38,38,0.5)]"></span>
                                <h4 class="text-sm font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest transition-colors">Deskripsi Aktivitas</h4>
                            </div>
                            <div class="p-6 bg-slate-50/50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-800 rounded-[1.5rem] text-slate-700 dark:text-slate-300 leading-relaxed text-base overflow-y-auto max-h-[40vh] shadow-inner trix-content prose prose-slate dark:prose-invert max-w-none transition-colors" 
                                 x-html="selectedLogbook.activity">
                            </div>
                        </div>

                        <!-- Lampiran Section -->
                        <div x-show="selectedLogbook.evidence" style="display: none;" class="space-y-4">
                            <div class="flex items-center gap-3 px-1">
                                <span class="w-2 h-2 bg-blue-600 dark:bg-blue-500 rounded-full shadow-[0_0_10px_rgba(37,99,235,0.5)]"></span>
                                <h4 class="text-sm font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest transition-colors">Lampiran Aktivitas</h4>
                            </div>
                            <div class="p-4 border-2 border-slate-100 dark:border-slate-800 rounded-[1.5rem] bg-white dark:bg-slate-900 transition-colors">
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


    {{-- Single Approval Form (Hidden) --}}
    <form id="singleApproveForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="approved">
    </form>

    <script>
        function confirmMassApprove() {
            Swal.fire({
                title: 'Setujui Semua yang Dipilih?',
                text: "Semua logbook yang Anda pilih akan langsung disetujui.",
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Ya, Setujui Semua',
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
                    document.getElementById('massApproveForm').submit();
                }
            });
        }

        function approveLogbook(id) {
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
                    const form = document.getElementById('singleApproveForm');
                    form.action = `/mentor/logbook/${id}/update`;
                    form.submit();
                }
            });
        }
    </script>
    </div>
</x-app-layout>
