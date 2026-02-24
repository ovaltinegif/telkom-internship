<div x-data="{ open: false, internshipId: null, isSmk: false, studentName: '' }"
     @open-completion-modal.window="open = true; internshipId = $event.detail.id; isSmk = $event.detail.isSmk; studentName = $event.detail.name"
     x-show="open" 
     style="display: none;"
     class="fixed inset-0 z-[1000] overflow-y-auto" 
     aria-labelledby="modal-completion-title" role="dialog" aria-modal="true">
    
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="open = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="open" 
             class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-transparent dark:border-slate-800">
            
            <form :action="'/admin/internships/' + internshipId + '/complete'" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="bg-white dark:bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-6 transition-colors duration-300">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-6 transition-colors" id="modal-completion-title">
                        Kirim Dokumen Kelulusan: <span class="text-red-600 dark:text-red-400" x-text="studentName"></span>
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Certificate (Always Required) -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Sertifikat Kelulusan</label>
                            <div class="relative group">
                                <input type="file" name="sertifikat_kelulusan" required accept=".pdf"
                                    class="block w-full text-xs text-slate-500 dark:text-slate-400 
                                    file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 
                                    file:text-xs file:font-bold file:bg-blue-50 dark:file:bg-blue-500/10 
                                    file:text-blue-700 dark:file:text-blue-400 
                                    hover:file:bg-blue-100 dark:hover:file:bg-blue-500/20 transition-all">
                            </div>
                            <p class="mt-1 text-[10px] text-slate-400 dark:text-slate-500 italic">Format: PDF (Max. 2MB)</p>
                        </div>

                        <!-- PKL Assessment (Visible for all, optional for University) -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors">
                                Laporan Penilaian PKL 
                                <span x-text="isSmk ? '(Wajib - SMK)' : '(Opsional)'" 
                                      :class="isSmk ? 'text-red-600 dark:text-red-400 ml-1' : 'text-slate-400 dark:text-slate-500 ml-1'"></span>
                            </label>
                            <div class="relative group">
                                <input type="file" name="laporan_penilaian_pkl" :required="isSmk" accept=".pdf"
                                    class="block w-full text-xs text-slate-500 dark:text-slate-400 
                                    file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 
                                    file:text-xs file:font-bold file:bg-amber-50 dark:file:bg-amber-500/10 
                                    file:text-amber-700 dark:file:text-amber-400 
                                    hover:file:bg-amber-100 dark:hover:file:bg-amber-500/20 transition-all">
                            </div>
                            <p class="mt-1 text-[10px] text-slate-400 dark:text-slate-500 italic">Format: PDF (Max. 2MB)</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-950/50 px-6 py-4 sm:px-8 flex flex-col-reverse sm:flex-row-reverse gap-3 transition-colors">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-200 dark:shadow-blue-900/20 transition-all active:scale-95">
                        Kirim Dokumen
                    </button>
                    <button type="button" @click="open = false" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
