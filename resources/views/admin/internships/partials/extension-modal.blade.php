{{-- Extension Review Modal --}}
<div x-data="{ open: false, id: null, name: '', university: '', major: '', current_end_date: '', doc_url: '#' }"
     @open-extension-modal.window="open = true; id = $event.detail.id; name = $event.detail.name; university = $event.detail.university; major = $event.detail.major; current_end_date = $event.detail.current_end_date; doc_url = $event.detail.doc_url"
     class="relative z-[1000]" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div x-show="open" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <div x-show="open" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            
            <div @click.away="open = false" class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-transparent dark:border-slate-800">
                <div class="bg-white dark:bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-6 transition-colors duration-300">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-50 dark:bg-amber-500/10 sm:mx-0 sm:h-12 sm:w-12 transition-colors">
                            <svg class="h-7 w-7 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-4 text-center sm:ml-6 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-2 transition-colors" id="modal-title">Review Perpanjangan</h3>
                            <div class="mt-2 space-y-6">
                                <div class="space-y-3">
                                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                                        Pengajuan oleh <span class="text-slate-900 dark:text-slate-100 font-bold" x-text="name"></span>
                                    </p>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 px-3 py-1 rounded-lg text-xs font-bold transition-colors" x-text="university"></span>
                                        <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 px-3 py-1 rounded-lg text-xs font-bold transition-colors" x-text="major"></span>
                                    </div>
                                </div>
                                
                                <div class="p-4 bg-slate-50 dark:bg-slate-950/30 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-3 transition-colors">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Selesai Saat Ini</span>
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200" x-text="current_end_date"></span>
                                    </div>
                                    <div class="flex justify-between items-center pt-3 border-t border-slate-200/50 dark:border-slate-800/50">
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Surat Pengajuan</span>
                                        <a :href="doc_url" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 text-xs font-bold hover:bg-amber-100 dark:hover:bg-amber-500/20 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Dokumen
                                        </a>
                                    </div>
                                </div>

                                {{-- Approval Form --}}
                                <form id="extension-modal-approve-form" :action="`{{ url('/admin/internships') }}/${id}/approve-extension`" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="space-y-1.5">
                                        <label for="new_end_date" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Tanggal Selesai Baru</label>
                                        <input type="date" name="new_end_date" id="new_end_date" required
                                               class="block w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm font-bold transition-all">
                                    </div>
                                </form>

                                {{-- Reject Form (Simplified) --}}
                                <form id="extension-modal-reject-form" :action="`{{ url('/admin/internships') }}/${id}/reject-extension`" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-950/50 px-6 py-4 sm:px-8 flex flex-col-reverse sm:flex-row-reverse gap-3 transition-colors">
                    <button type="button" onclick="submitExtensionModalApprove()" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-amber-200 dark:shadow-amber-900/20 transition-all active:scale-95">
                        Setujui & Perbarui
                    </button>
                    <button type="button" @click="open = false" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                        Batal
                    </button>
                    <div class="flex-1 flex items-center justify-center sm:justify-start">
                        <button type="button" onclick="submitExtensionModalReject()" 
                                class="text-xs font-bold text-red-600 dark:text-red-400 hover:underline transition-all">
                            Tolak Pengajuan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
