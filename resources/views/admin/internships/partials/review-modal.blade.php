<div x-data="{ open: false, internshipId: null, studentName: '', documents: [] }"
     @open-review-modal.window="open = true; internshipId = $event.detail.id; studentName = $event.detail.name; documents = $event.detail.docs"
     x-show="open" 
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <!-- Background backdrop -->
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

        <!-- Modal panel -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Review Aplikasi: <span x-text="studentName"></span>
                            </h3>
                            <div class="mt-4 mb-6">
                                <p class="text-sm text-gray-500 mb-2 font-semibold">Dokumen Mahasiswa:</p>
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200 max-h-40 overflow-y-auto">
                                    <template x-for="doc in documents" :key="doc.id">
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate" x-text="doc.name"></span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a :href="'/storage/' + doc.file_path" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                            <hr class="my-4">

                            <!-- Approve Form -->
                            <form id="approve-form" :action="'/admin/internships/' + internshipId + '/approve'" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="mt-4">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Upload Dokumen Onboarding</h4>
                                    
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Surat Jawaban / Penerimaan</label>
                                        <input type="file" name="surat_jawaban" required
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                        <p class="mt-1 text-xs text-gray-500">File PDF/Docx, Max 2MB.</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Google Docs Template Pakta Integritas</label>
                                        <input type="url" name="pakta_integritas_link" required placeholder="https://docs.google.com/document/d/..."
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <p class="mt-1 text-xs text-gray-500">Masukkan link dokumen yang dapat diakses oleh mahasiswa.</p>
                                    </div>
                                </div>
                            </form>
                            
                            <!-- Reject Form (Hidden) -->
                            <form id="reject-form" :action="'/admin/internships/' + internshipId + '/reject'" method="POST" class="hidden">
                                @csrf
                                @method('PATCH')
                            </form>

                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center">
                     <!-- Reject Button (Left) -->
                    <button type="submit" form="reject-form" onclick="return confirm('Apakah Anda yakin ingin MENOLAK pengajuan ini? Notifikasi akan dikirim ke mahasiswa.')"
                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                        Reject (Tolak)
                    </button>

                    <!-- Approve & Cancel (Right) -->
                    <div class="flex flex-row-reverse">
                        <button type="submit" form="approve-form" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Approve & Send Files
                        </button>
                        <button type="button" @click="open = false" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
        </div>
    </div>
</div>
