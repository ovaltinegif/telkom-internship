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
                        <div class="space-y-2" x-data="{ 
                            fileNameCert: '', 
                            isDraggingCert: false,
                            handleDropCert(e) {
                                this.isDraggingCert = false;
                                if (e.dataTransfer.files.length > 0) {
                                    const file = e.dataTransfer.files[0];
                                    if (file.type === 'application/pdf') {
                                        this.$refs.fileInputCert.files = e.dataTransfer.files;
                                        this.fileNameCert = file.name;
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Format Tidak Sesuai',
                                            text: 'Harap unggah file sertifikat dalam format PDF.',
                                        });
                                    }
                                }
                            },
                            clearFileCert() {
                                this.fileNameCert = '';
                                this.$refs.fileInputCert.value = '';
                            }
                        }">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors mb-2">Sertifikat Kelulusan</label>
                            <div 
                                @dragover.prevent="isDraggingCert = true" 
                                @dragleave.prevent="isDraggingCert = false" 
                                @drop.prevent="handleDropCert($event)"
                                :class="{'border-blue-500 bg-blue-50/50 dark:bg-blue-500/10 scale-[1.02]': isDraggingCert, 'border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/20': !isDraggingCert}"
                                class="flex justify-center px-4 pt-5 pb-5 border-2 border-dashed rounded-2xl group transition-all hover:bg-blue-50/50 dark:hover:bg-blue-500/5 hover:border-blue-400 relative cursor-pointer shadow-sm">
                                <input type="file" name="sertifikat_kelulusan" required accept=".pdf" x-ref="fileInputCert" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="fileNameCert = $event.target.files[0].name" :class="{'hidden': fileNameCert}">
                                <div class="text-center space-y-2 transition-transform group-hover:scale-105 duration-300 w-full">
                                    <div class="inline-flex items-center justify-center w-8 h-8 bg-white dark:bg-slate-800 rounded-lg text-slate-400 dark:text-slate-500 group-hover:text-blue-500 transition-all shadow-sm">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                    </div>
                                    <div class="text-xs text-slate-600 dark:text-slate-400 relative z-20">
                                        <span x-show="!fileNameCert" class="font-bold block text-slate-800 dark:text-slate-200">Klik atau seret file PDF</span>
                                        
                                        {{-- Selected File State --}}
                                        <div x-show="fileNameCert" style="display: none;" class="flex flex-col items-center mt-1">
                                            <div class="flex items-center gap-2 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-500/30 w-full justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                <span x-text="fileNameCert" class="font-bold truncate max-w-[150px]"></span>
                                                <button type="button" @click.stop.prevent="clearFileCert()" class="p-1 hover:bg-blue-200 dark:hover:bg-blue-500/40 rounded-md transition-colors text-blue-600 hover:text-red-500 shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>
                                        </div>

                                        <p class="mt-1 text-[10px] text-slate-400 dark:text-slate-500 italic" x-show="!fileNameCert">Max. 2MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PKL Assessment (Visible for all, optional for University) -->
                        <div class="space-y-2" x-data="{ 
                            fileNamePkl: '', 
                            isDraggingPkl: false,
                            handleDropPkl(e) {
                                this.isDraggingPkl = false;
                                if (e.dataTransfer.files.length > 0) {
                                    const file = e.dataTransfer.files[0];
                                    if (file.type === 'application/pdf') {
                                        this.$refs.fileInputPkl.files = e.dataTransfer.files;
                                        this.fileNamePkl = file.name;
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Format Tidak Sesuai',
                                            text: 'Harap unggah file laporan dalam format PDF.',
                                        });
                                    }
                                }
                            },
                            clearFilePkl() {
                                this.fileNamePkl = '';
                                this.$refs.fileInputPkl.value = '';
                            }
                        }">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors mb-2">
                                Laporan Penilaian PKL 
                                <span x-text="isSmk ? '(Wajib - SMK)' : '(Opsional)'" 
                                      :class="isSmk ? 'text-red-600 dark:text-red-400 ml-1' : 'text-slate-400 dark:text-slate-500 ml-1'"></span>
                            </label>
                            <div 
                                @dragover.prevent="isDraggingPkl = true" 
                                @dragleave.prevent="isDraggingPkl = false" 
                                @drop.prevent="handleDropPkl($event)"
                                :class="{'border-amber-500 bg-amber-50/50 dark:bg-amber-500/10 scale-[1.02]': isDraggingPkl, 'border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/20': !isDraggingPkl}"
                                class="flex justify-center px-4 pt-5 pb-5 border-2 border-dashed rounded-2xl group transition-all hover:bg-amber-50/50 dark:hover:bg-amber-500/5 hover:border-amber-400 relative cursor-pointer shadow-sm">
                                <input type="file" name="laporan_penilaian_pkl" :required="isSmk" accept=".pdf" x-ref="fileInputPkl" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="fileNamePkl = $event.target.files[0].name" :class="{'hidden': fileNamePkl}">
                                <div class="text-center space-y-2 transition-transform group-hover:scale-105 duration-300 w-full">
                                    <div class="inline-flex items-center justify-center w-8 h-8 bg-white dark:bg-slate-800 rounded-lg text-slate-400 dark:text-slate-500 group-hover:text-amber-500 transition-all shadow-sm">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                    </div>
                                    <div class="text-xs text-slate-600 dark:text-slate-400 relative z-20">
                                        <span x-show="!fileNamePkl" class="font-bold block text-slate-800 dark:text-slate-200">Klik atau seret file PDF</span>
                                        
                                        {{-- Selected File State --}}
                                        <div x-show="fileNamePkl" style="display: none;" class="flex flex-col items-center mt-1">
                                            <div class="flex items-center gap-2 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 px-3 py-1.5 rounded-lg border border-amber-200 dark:border-amber-500/30 w-full justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                <span x-text="fileNamePkl" class="font-bold truncate max-w-[150px]"></span>
                                                <button type="button" @click.stop.prevent="clearFilePkl()" class="p-1 hover:bg-amber-200 dark:hover:bg-amber-500/40 rounded-md transition-colors text-amber-600 hover:text-red-500 shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>
                                        </div>

                                        <p class="mt-1 text-[10px] text-slate-400 dark:text-slate-500 italic" x-show="!fileNamePkl">Max. 2MB</p>
                                    </div>
                                </div>
                            </div>
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
