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
             class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-transparent dark:border-slate-800">
            
            <form :action="'{{ route('admin.internships.activate', 'PLACEHOLDER_ID') }}'.replace('PLACEHOLDER_ID', id)" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="bg-white dark:bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-6 transition-colors duration-300">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4 transition-colors" id="modal-title">
                                Aktivasi Magang: <span x-text="name" class="text-red-600 dark:text-red-400"></span>
                            </h3>
                            <div class="mt-2 text-sm text-slate-500 dark:text-slate-400 space-y-4 transition-colors">
                                <p>Pastikan mahasiswa sudah mengupload Pakta Integritas yang ditandatangani sebelum mengaktifkan status magang.</p>
                                <p>Mentor dan Divisi sudah ditentukan pada tahap sebelumnya.</p>
                                
                                <div class="space-y-6 border-t border-slate-100 dark:border-slate-800 pt-6 mt-6 transition-colors">
                                    <h4 class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                                        <span class="p-1.5 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400">📅</span> 
                                        Jadwal Induksi Mahasiswa
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="space-y-1.5">
                                            <label for="induction_date" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Tanggal Induksi</label>
                                            <input type="date" name="induction_date" id="induction_date" required 
                                                class="w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 text-sm font-bold transition-all">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label for="induction_time" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Waktu Induksi</label>
                                            <input type="time" name="induction_time" id="induction_time" required 
                                                class="w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 text-sm font-bold transition-all">
                                        </div>
                                    </div>
                                    <div class="p-4 bg-slate-50 dark:bg-slate-950/30 rounded-xl border border-slate-100 dark:border-slate-800 transition-colors">
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">Jadwal ini akan dikirimkan otomatis ke email mahasiswa setelah diaktivasi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-950/50 px-6 py-4 sm:px-8 flex flex-col-reverse sm:flex-row-reverse gap-3 transition-colors">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-green-200 dark:shadow-green-900/20 transition-all active:scale-95">
                        Verifikasi & Aktifkan
                    </button>
                    <button type="button" @click="show = false" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
