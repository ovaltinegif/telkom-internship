<div id="fullDayPermissionModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal('fullDayPermissionModal')"></div>
        
        <div class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl dark:shadow-slate-950 transform transition-all w-full max-w-2xl border border-slate-100 dark:border-slate-800">
            
            {{-- Modal Header --}}
            <div class="bg-white dark:bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl leading-6 font-black text-slate-800 dark:text-slate-100 tracking-tight">Pengajuan Izin Full Day</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-500 font-medium mt-1">Pilih rentang tanggal izin ketidakhadiran Anda</p>
                </div>
                <button type="button" onclick="closeModal('fullDayPermissionModal')" class="text-slate-400 hover:text-red-500 transition-all bg-slate-50 dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl p-2 border border-slate-200 dark:border-slate-700 hover:border-red-100 dark:hover:border-red-900 shadow-sm active:scale-90">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" id="fullDayPermissionForm">
                @csrf
                <input type="hidden" name="permit_type" value="full">
                <input type="hidden" name="date" id="full_day_date_range" required>

                <div class="px-8 py-8 flex flex-col md:flex-row gap-8 bg-slate-50 dark:bg-slate-900/50">
                    {{-- Calendar Section --}}
                    <div class="w-full md:w-[60%]">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-4 shadow-sm border border-slate-100 dark:border-slate-700">
                            <input type="text" id="inline_calendar" class="hidden">
                        </div>
                    </div>

                    {{-- Dates Info Section --}}
                    <div class="w-full md:w-[40%] flex flex-col justify-center space-y-8">
                        <div>
                            <p class="text-[12px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Tanggal Mulai</p>
                            <div class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold px-5 py-3 rounded-2xl shadow-sm ring-1 ring-slate-100 dark:ring-slate-700 flex items-center gap-3" id="display_start_date">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-500">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span>-</span>
                            </div>
                        </div>

                        <div>
                            <p class="text-[12px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Tanggal Selesai</p>
                            <div class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold px-5 py-3 rounded-2xl shadow-sm ring-1 ring-slate-100 dark:ring-slate-700 flex items-center gap-3" id="display_end_date">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-500">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span>-</span>
                            </div>
                        </div>

                        {{-- Reason Input --}}
                        <div>
                            <p class="text-[12px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Alasan Izin</p>
                            <div class="bg-white dark:bg-slate-800 rounded-3xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 relative hover:border-red-200 dark:hover:border-red-900/50 transition-colors group">
                                <textarea id="note_full" name="note" rows="3" placeholder="Tuliskan alasan lengkap izin Anda..." required
                                    class="block w-full border-0 focus:ring-0 sm:text-sm bg-transparent text-slate-700 dark:text-slate-300 placeholder-slate-400 resize-none font-medium"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Section --}}
                <div class="px-8 py-5 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white dark:bg-slate-900 rounded-b-[2.5rem]">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400 dark:text-slate-500 font-semibold text-sm">Durasi:</span>
                        <div class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 px-3 py-1 rounded-lg font-black text-sm border border-red-100 dark:border-red-900/50 shadow-sm">
                            <span id="display_duration">0</span> Hari
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('fullDayPermissionModal')" 
                            class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold py-2.5 px-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm transition-all text-sm">
                            Batal
                        </button>
                        <button type="submit" 
                            class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 text-sm">
                            Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Minimalist Outline Style for Flatpickr */
#inline_calendar .flatpickr-calendar {
    background: #ffffff !important;
    box-shadow: none !important;
    border: 2px solid #f1f5f9 !important; /* Tailwind border-slate-100 */
    border-radius: 1.5rem !important; /* Tailwind rounded-3xl */
    padding: 1rem !important;
    width: 100% !important;
}
.dark #inline_calendar .flatpickr-calendar {
    background: #0f172a !important; /* Tailwind bg-slate-950 */
    border-color: #1e293b !important; /* Tailwind border-slate-800 */
}
#inline_calendar .flatpickr-months {
    margin-bottom: 1rem !important;
}
#inline_calendar .flatpickr-month {
    color: #1e293b !important; /* Tailwind text-slate-800 */
    font-weight: 700 !important;
}
.dark #inline_calendar .flatpickr-month {
    color: #f1f5f9 !important;
}
#inline_calendar .flatpickr-weekday {
    color: #94a3b8 !important; /* Tailwind text-slate-400 */
    font-weight: 600 !important;
    font-size: 0.75rem !important;
    text-transform: capitalize !important;
}
#inline_calendar .flatpickr-day {
    color: #334155 !important;
    font-weight: 500 !important;
    border: 2px solid transparent !important;
    border-radius: 0 !important;
    background: transparent !important;
    margin-top: 2px !important;
}
.dark #inline_calendar .flatpickr-day {
    color: #cbd5e1 !important;
}
#inline_calendar .flatpickr-day:hover {
    color: #ef4444 !important; /* Tailwind hover:text-red-500 */
}
/* Range Selection - Outline Style */
#inline_calendar .flatpickr-day.startRange {
    border-top: 2px solid #ef4444 !important;
    border-bottom: 2px solid #ef4444 !important;
    border-left: 2px solid #ef4444 !important;
    border-radius: 9999px 0 0 9999px !important;
    color: #dc2626 !important;
    font-weight: 700 !important;
}
#inline_calendar .flatpickr-day.endRange {
    border-top: 2px solid #ef4444 !important;
    border-bottom: 2px solid #ef4444 !important;
    border-right: 2px solid #ef4444 !important;
    border-radius: 0 9999px 9999px 0 !important;
    color: #dc2626 !important;
    font-weight: 700 !important;
}
#inline_calendar .flatpickr-day.inRange {
    border-top: 2px solid #ef4444 !important;
    border-bottom: 2px solid #ef4444 !important;
    box-shadow: none !important;
    color: #dc2626 !important;
    font-weight: 700 !important;
}
#inline_calendar .flatpickr-day.selected:not(.startRange):not(.endRange):not(.inRange) {
    border: 2px solid #ef4444 !important;
    border-radius: 9999px !important;
    color: #dc2626 !important;
    font-weight: 700 !important;
}
</style>
