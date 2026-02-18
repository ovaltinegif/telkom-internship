{{-- Extension Review Modal --}}
<div x-data="{ open: false, id: null, name: '', current_end_date: '', doc_url: '#' }"
     @open-extension-modal.window="open = true; id = $event.detail.id; name = $event.detail.name; current_end_date = $event.detail.current_end_date; doc_url = $event.detail.doc_url"
     class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

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
            
            <div @click.away="open = false" class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Review Perpanjangan Magang</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Tinjau pengajuan perpanjangan magang untuk <span class="font-bold text-gray-800" x-text="name"></span>.
                                </p>
                                
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-500">Tanggal Selesai Saat Ini:</span>
                                        <span class="text-sm font-semibold text-gray-800" x-text="current_end_date"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">Surat Pengajuan:</span>
                                        <a :href="doc_url" target="_blank" class="text-sm font-medium text-amber-600 hover:text-amber-500 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Dokumen
                                        </a>
                                    </div>
                                </div>

                                {{-- Approval Form --}}
                                <form :action="`{{ url('/admin/internships') }}/${id}/approve-extension`" method="POST" class="mt-4">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <label for="new_end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai Baru</label>
                                    <input type="date" name="new_end_date" id="new_end_date" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                                    
                                    <div class="mt-5 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-amber-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 sm:ml-3 sm:w-auto">
                                            Setujui & Perbarui
                                        </button>
                                        <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                            Batal
                                        </button>
                                    </div>
                                </form>

                                {{-- Rejection Form (Separate) --}}
                                <div class="mt-6 border-t border-gray-100 pt-4">
                                    <p class="text-xs text-gray-400 mb-2">Jika dokumen tidak valid, Anda dapat menolak pengajuan ini.</p>
                                    <form :action="`{{ url('/admin/internships') }}/${id}/reject-extension`" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini? Dokumen akan dihapus.')" 
                                                class="text-sm text-red-600 hover:text-red-500 font-medium underline">
                                            Tolak Pengajuan
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
