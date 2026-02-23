<div x-data="{ show: false, id: null, name: '' }" 
    @open-activation-modal.window="show = true; id = $event.detail.id; name = $event.detail.name" 
    x-show="show" 
    class="fixed inset-0 z-[1000] overflow-y-auto" 
    style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        
        <div x-show="show" class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="show" 
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form :action="'{{ route('admin.internships.activate', 'PLACEHOLDER_ID') }}'.replace('PLACEHOLDER_ID', id)" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Aktivasi Magang: <span x-text="name" class="font-bold"></span>
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                <p class="mb-4">Pastikan mahasiswa sudah mengupload Pakta Integritas yang ditandatangani sebelum mengaktifkan status magang.</p>
                                <p class="mb-4">Mentor dan Divisi sudah ditentukan pada tahap sebelumnya.</p>
                                
                                <div class="space-y-4 border-t pt-4">
                                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                                        <span>📅</span> Jadwal Induksi Mahasiswa
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="induction_date" class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Induksi</label>
                                            <input type="date" name="induction_date" id="induction_date" required 
                                                class="w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                                        </div>
                                        <div>
                                            <label for="induction_time" class="block text-xs font-bold text-slate-700 uppercase mb-1">Waktu Induksi</label>
                                            <input type="time" name="induction_time" id="induction_time" required 
                                                class="w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 italic">Jadwal ini akan dikirimkan otomatis ke email mahasiswa setelah diaktivasi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Verifikasi & Aktifkan
                    </button>
                    <button type="button" @click="show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
