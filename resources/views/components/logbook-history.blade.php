@props(['logbooks', 'todayLogbook'])

<div x-data="{ showEvidenceModal: false, evidenceUrl: '', isImage: false }" class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Riwayat Logbook</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Catat aktivitas harianmu disini</p>
            </div>
            
            @if(Auth::user()->internship && Auth::user()->internship->status === 'finished')
                <a href="{{ route('logbooks.exportExcel') }}" class="inline-flex items-center gap-2 bg-gradient-to-br from-red-600 to-red-500 text-white px-6 py-3 rounded-2xl hover:shadow-2xl hover:shadow-red-500/30 transition-all duration-300 text-xs font-black group active:scale-95 border-b-4 border-red-800/50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:scale-110 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125h-7.5a1.125 1.125 0 0 1-1.125-1.125m0 0h7.5m-7.5 0V5.625m0 12.75v1.5c0 .621-.504 1.125-1.125 1.125M9 5.625v9.75m6-9.75v9.75M3.375 5.625h17.25c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125H3.375a1.125 1.125 0 0 1-1.125-1.125V6.75c0-.621.504-1.125 1.125-1.125Z" />
                    </svg>
                    REKAP LOGBOOK
                </a>
            @else
                @if(isset($todayLogbook) && $todayLogbook)
                    <button disabled 
                       class="inline-flex items-center gap-2 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 px-6 py-3 rounded-2xl text-xs font-black cursor-not-allowed border border-slate-200 dark:border-slate-700 shadow-inner group transition-all"
                       title="Anda sudah mengisi logbook hari ini">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 opacity-50">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                        LOGBOOK TERISI
                    </button>
                @else
                    @if(Auth::user()->internship && Auth::user()->internship->status === 'active')
                        <a href="{{ route('logbooks.create') }}" 
                           class="inline-flex items-center gap-2 bg-gradient-to-br from-red-600 to-red-500 text-white px-6 py-3 rounded-2xl hover:shadow-2xl hover:shadow-red-500/30 transition-all duration-300 text-xs font-black group active:scale-95 border-b-4 border-red-800/50">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 group-hover:scale-110 transition-transform">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                            </svg>
                            ISI LOGBOOK
                        </a>
                    @endif
                @endif
            @endif
        </div>

        {{-- Logbook Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Tanggal</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Aktivitas</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Bukti</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                    @forelse($logbooks as $logbook)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors font-bold">
                                {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300 transition-colors max-w-xs truncate" title="{{ strip_tags($logbook->activity) }}">
                                {{ Str::limit(strip_tags($logbook->activity), 40) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                @if($logbook->evidence)
                                    @php
                                        $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $logbook->evidence);
                                    @endphp
                                    <button @click="showEvidenceModal = true; evidenceUrl = '{{ Storage::url($logbook->evidence) }}'; isImage = {{ $isImage ? 'true' : 'false' }}" class="inline-flex items-center gap-1.5 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-bold transition-all transform hover:scale-105">
                                        <div class="p-1.5 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 group-hover:bg-red-600 group-hover:text-white dark:group-hover:bg-red-600 dark:group-hover:text-white transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.551a.75.75 0 111.061 1.06l-3.45 3.551a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                <x-status-badge :status="$logbook->status" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                <div class="flex flex-col items-center justify-center h-full gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-slate-300 dark:text-slate-700 transition-colors">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada logbook yang diisi.</p>
                                    @if(Auth::user()->internship && Auth::user()->internship->status === 'active')
                                        <a href="{{ route('logbooks.create') }}" class="text-red-600 dark:text-red-400 font-semibold hover:underline">Yuk isi logbook pertamamu!</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Evidence Detail Modal -->
    <div x-show="showEvidenceModal" 
        class="fixed inset-0 z-[1000] overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
        style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="showEvidenceModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" 
            @click="showEvidenceModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="showEvidenceModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl w-full border border-slate-200 dark:border-slate-800">
                
                <!-- Header -->
                <div class="bg-white dark:bg-slate-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="sm:flex sm:items-start justify-between">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-slate-100" id="modal-title">
                                        Bukti Logbook
                                    </h3>
                                </div>
                                <button @click="showEvidenceModal = false" type="button" class="text-slate-400 hover:text-red-500 focus:outline-none transition-colors">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="bg-slate-50 dark:bg-slate-950 p-4 flex justify-center items-center overflow-hidden min-h-[50vh] max-h-[85vh]">
                    <template x-if="evidenceUrl">
                        <div class="w-full h-full flex justify-center items-center">
                            <template x-if="isImage">
                                <img :src="evidenceUrl" alt="Bukti Logbook" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
                            </template>
                            <template x-if="!isImage">
                                <iframe :src="evidenceUrl" class="w-full h-[75vh] border-0 rounded-lg shadow-sm" title="Bukti Attachment"></iframe>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
