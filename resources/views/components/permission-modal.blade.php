<div id="permissionModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal('permissionModal')"></div>
        
        <div class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl dark:shadow-slate-950 transform transition-all w-full max-w-xl border border-slate-100 dark:border-slate-800">
            
            {{-- Modal Header --}}
            <div class="bg-white dark:bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl leading-6 font-black text-slate-800 dark:text-slate-100 tracking-tight">Pengajuan Izin Keluar</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-500 font-medium mt-1">Sampaikan alasan ketidakhadiran Anda secara sementara</p>
                </div>
                <button type="button" onclick="closeModal('permissionModal')" class="text-slate-400 hover:text-red-500 transition-all bg-slate-50 dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl p-2 border border-slate-200 dark:border-slate-700 hover:border-red-100 dark:hover:border-red-900 shadow-sm active:scale-90">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="permit_type" value="temporary">
                
                @php
                    $displayDate = \Carbon\Carbon::now()->hour < 7 ? \Carbon\Carbon::yesterday() : \Carbon\Carbon::today();
                @endphp
                <input type="hidden" name="date" value="{{ $displayDate->format('Y-m-d') }}">
                
                <div class="px-8 py-8 bg-slate-50 dark:bg-slate-900/50 space-y-6">
                    
                    {{-- Date Display Context (Read-Only) --}}
                    <div>
                        <p class="text-[12px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Tanggal Izin</p>
                        <div class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold px-5 py-3 rounded-2xl shadow-sm ring-1 ring-slate-100 dark:ring-slate-700 flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-500">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <span>{{ $displayDate->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>

                    {{-- Time Inputs (Modern Layout) --}}
                    <div>
                        <p class="text-[12px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Rentang Waktu Izin Keluar</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            {{-- Start Time Box --}}
                            <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 relative hover:border-red-200 dark:hover:border-red-900/50 transition-colors group">
                                <label for="start_time" class="block text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-500 font-bold mb-1">Pukul Berangkat</label>
                                <div class="flex flex-col gap-3 relative justify-center items-center">
                                    <input type="text" name="start_time" id="start_time" class="absolute opacity-0 w-0 h-0 pointer-events-none" required tabindex="-1">
                                </div>
                            </div>
                            
                            {{-- End Time Box --}}
                            <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 relative hover:border-red-200 dark:hover:border-red-900/50 transition-colors group">
                                <label for="end_time" class="block text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-500 font-bold mb-1">Perkiraan Kembali</label>
                                <div class="flex flex-col gap-3 relative justify-center items-center">
                                    <input type="text" name="end_time" id="end_time" class="absolute opacity-0 w-0 h-0 pointer-events-none" required tabindex="-1">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Reason Input --}}
                    <div>
                        <p class="text-[12px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Alasan Izin</p>
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 relative hover:border-red-200 dark:hover:border-red-900/50 transition-colors group">
                            <textarea id="note" name="note" rows="3" placeholder="Tuliskan alasan singkat izin Anda..." required
                                class="block w-full border-0 focus:ring-0 sm:text-sm bg-transparent text-slate-700 dark:text-slate-300 placeholder-slate-400 resize-none font-medium"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Footer Section --}}
                <div class="px-8 py-5 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 items-center bg-white dark:bg-slate-900 rounded-b-[2.5rem]">
                    <button type="button" onclick="closeModal('permissionModal')" 
                        class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold py-2.5 px-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit" 
                        class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 text-sm">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
