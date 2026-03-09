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
             class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-transparent dark:border-slate-800">
            
            <form :action="'/admin/internships/' + internshipId + '/complete'" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="bg-white dark:bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-6 transition-colors duration-300">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-6 transition-colors" id="modal-completion-title">
                        Kirim Dokumen Kelulusan: <span class="text-indigo-600 dark:text-indigo-400" x-text="studentName"></span>
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Multiple Document Upload -->
                        <div class="space-y-2" x-data="{ 
                            files: [], 
                            isDragging: false,
                            handleDrop(e) {
                                this.isDragging = false;
                                if (e.dataTransfer.files.length > 0) {
                                    this.addFiles(e.dataTransfer.files);
                                }
                            },
                            handleFileSelect(e) {
                                if (e.target.files.length > 0) {
                                    this.addFiles(e.target.files);
                                }
                            },
                            addFiles(newFiles) {
                                const allowedTypes = ['application/pdf'];
                                // Get current files from DataTransfer object
                                const dt = new DataTransfer();
                                
                                // Add existing files to keep them
                                this.files.forEach(f => dt.items.add(f));

                                // Process new files
                                Array.from(newFiles).forEach(file => {
                                    if(allowedTypes.includes(file.type)) {
                                        // Check if file already exists
                                        if(!this.files.find(f => f.name === file.name && f.size === file.size)) {
                                            dt.items.add(file);
                                            this.files.push(file);
                                        }
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Format Tidak Sesuai',
                                            text: `File ${file.name} bukan PDF. Harap unggah format PDF.`,
                                        });
                                    }
                                });

                                // Update the actual input files
                                this.$refs.fileInput.files = dt.files;
                            },
                            removeFile(index) {
                                this.files.splice(index, 1);
                                
                                // Update DataTransfer to reflect removal
                                const dt = new DataTransfer();
                                this.files.forEach(f => dt.items.add(f));
                                this.$refs.fileInput.files = dt.files;
                                
                                if(this.files.length === 0) {
                                    this.$refs.fileInput.value = '';
                                }
                            }
                        }">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors mb-2">Upload File PDF (Disarankan: Sertifikat, Nilai, dll)</label>
                            
                            <div 
                                @dragover.prevent="isDragging = true" 
                                @dragleave.prevent="isDragging = false" 
                                @drop.prevent="handleDrop($event)"
                                :class="{'border-indigo-500 bg-indigo-50/50 dark:bg-indigo-500/10 scale-[1.02]': isDragging, 'border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/20': !isDragging}"
                                class="flex justify-center px-4 pt-5 pb-5 border-2 border-dashed rounded-2xl group transition-all hover:bg-indigo-50/50 dark:hover:bg-indigo-500/5 hover:border-indigo-400 relative focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2">
                                
                                <input type="file" name="dokumen_kelulusan[]" multiple required accept=".pdf" x-ref="fileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFileSelect($event)">
                                
                                <div class="text-center space-y-2 transition-transform duration-300 w-full" :class="{'scale-105': files.length === 0 && isDragging}">
                                    
                                    <div x-show="files.length === 0" class="pointer-events-none">
                                        <div class="inline-flex items-center justify-center w-10 h-10 bg-white dark:bg-slate-800 rounded-xl text-slate-400 dark:text-slate-500 group-hover:text-indigo-500 transition-all shadow-sm">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                        </div>
                                        <div class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                            <span class="font-bold text-slate-800 dark:text-slate-200">Klik untuk upload</span> atau seret file ke sini
                                        </div>
                                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Anda dapat memilih lebih dari satu file PDF</p>
                                    </div>

                                    <!-- Render list of selected files -->
                                    <div x-show="files.length > 0" style="display: none;" class="text-left w-full relative z-20 pointer-events-auto">
                                        <div class="flex items-center justify-between mb-3 px-1">
                                            <span class="text-xs font-bold text-indigo-700 dark:text-indigo-400" x-text="files.length + ' File Dipilih'"></span>
                                            <span class="text-[10px] text-slate-500 font-medium">Klik area kotak putus-putus ini jika ingin tambah file lagi.</span>
                                        </div>
                                        <ul class="space-y-2 max-h-[160px] overflow-y-auto pr-1 select-text">
                                            <template x-for="(file, index) in files" :key="index">
                                                <li class="flex items-center justify-between bg-white dark:bg-slate-800/80 px-3 py-2 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm transition-all hover:border-indigo-200 dark:hover:border-indigo-500/30">
                                                    <div class="flex items-center gap-3 overflow-hidden">
                                                        <div class="p-1.5 bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-lg shrink-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                        </div>
                                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 truncate" x-text="file.name"></span>
                                                    </div>
                                                    <button type="button" @click.stop.prevent="removeFile(index)" class="p-1.5 bg-slate-50 hover:bg-red-50 dark:bg-slate-800/50 dark:hover:bg-red-500/20 text-slate-400 hover:text-red-500 rounded-lg transition-colors shrink-0 outline-none focus:ring-2 focus:ring-red-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-950/50 px-6 py-4 sm:px-8 flex flex-col-reverse sm:flex-row-reverse gap-3 transition-colors">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-200 dark:shadow-indigo-900/20 transition-all active:scale-95">
                        Kirim & Selesaikan
                    </button>
                    <button type="button" @click="open = false" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
