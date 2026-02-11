<div x-data="{ open: false, internshipId: null, isSmk: false, studentName: '' }"
     @open-completion-modal.window="open = true; internshipId = $event.detail.id; isSmk = $event.detail.isSmk; studentName = $event.detail.name"
     x-show="open" 
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto" 
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
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form :action="'/admin/internships/' + internshipId + '/complete'" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-completion-title">
                        Kirim Dokumen Kelulusan: <span x-text="studentName"></span>
                    </h3>
                    
                    <div class="mt-4">
                        <!-- Certificate (Always Required) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sertifikat Kelulusan</label>
                            <input type="file" name="sertifikat_kelulusan" required accept=".pdf"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">File PDF, Max 2MB.</p>
                        </div>

                        <!-- PKL Assessment (Visible for all, optional for University) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Laporan Penilaian PKL 
                                <span x-text="isSmk ? '(Wajib untuk SMK)' : '(Tidak Wajib untuk Mahasiswa)'" 
                                      :class="isSmk ? 'text-red-600 font-bold ml-1' : 'text-gray-500 italic ml-1'"></span>
                            </label>
                            <input type="file" name="laporan_penilaian_pkl" :required="isSmk" accept=".pdf"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                            <p class="mt-1 text-xs text-gray-500">File PDF, Max 2MB.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Kirim Dokumen
                    </button>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
