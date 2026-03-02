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
                            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-3xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 relative hover:border-red-200 dark:hover:border-red-900/50 focus-within:border-red-500 dark:focus-within:border-red-500 focus-within:ring-4 focus-within:ring-red-500/10 transition-all duration-300 group">
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
/* Modern Premium Soft Style for Flatpickr */
#inline_calendar .flatpickr-calendar {
    background: #ffffff !important;
    box-shadow: none !important;
    border: none !important; /* Hilangkan border kaku */
    padding: 1rem 0.5rem !important; /* Beri sedikit ruang bernapas */
    width: 100% !important;
}
.dark #inline_calendar .flatpickr-calendar {
    background: transparent !important;
}

/* Header (Bulan & Tahun) */
#inline_calendar .flatpickr-months {
    background: transparent !important;
    margin-bottom: 1.5rem !important;
    padding: 0 10px !important;
}
#inline_calendar .flatpickr-months .flatpickr-month {
    background: transparent !important;
    color: #1e293b !important; /* Tailwind text-slate-800 - Elegan */
    fill: #1e293b !important;
}
.dark #inline_calendar .flatpickr-months .flatpickr-month {
    color: #f1f5f9 !important;
    fill: #f1f5f9 !important;
}
#inline_calendar .flatpickr-current-month {
    font-size: 1.15rem !important;
    font-weight: 800 !important;
    padding-top: 0 !important;
}
#inline_calendar .flatpickr-current-month .numInputWrapper {
    width: 6.5ch !important; /* Ruang untuk dropdown tahun */
}
#inline_calendar .flatpickr-current-month input.cur-year {
    font-weight: 800 !important;
}
#inline_calendar .flatpickr-current-month .flatpickr-monthDropdown-months {
    font-weight: 800 !important;
    appearance: none;
    -moz-appearance: none;
    -webkit-appearance: none;
    background-color: transparent !important;
}

/* Panah Navigasi */
#inline_calendar .flatpickr-prev-month, 
#inline_calendar .flatpickr-next-month {
    fill: #64748b !important; /* Tailwind slate-500 */
    color: #64748b !important;
    padding: 10px !important;
    border-radius: 50% !important;
    transition: all 0.2s ease !important;
}
#inline_calendar .flatpickr-prev-month:hover, 
#inline_calendar .flatpickr-next-month:hover {
    background: #f1f5f9 !important; /* Tailwind slate-100 */
    fill: #0f172a !important; /* Tailwind slate-900 */
}
.dark #inline_calendar .flatpickr-prev-month:hover, 
.dark #inline_calendar .flatpickr-next-month:hover {
    background: #334155 !important;
    fill: #f8fafc !important;
}

/* Hari dalam Seminggu (Sen, Sel, dll) */
#inline_calendar .flatpickr-weekdays {
    background: transparent !important;
}
#inline_calendar span.flatpickr-weekday {
    color: #94a3b8 !important; /* Tailwind text-slate-400 - Subtle */
    font-weight: 800 !important;
    font-size: 0.70rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.1em !important; /* Tracking-widest */
    background: transparent !important;
}

/* Tanggal */
#inline_calendar .flatpickr-days {
    border: none !important;
}
#inline_calendar .dayContainer {
    width: 100% !important;
    min-width: 100% !important;
    max-width: 100% !important;
    justify-content: space-around !important; /* Spasi antar tanggal yang proporsional */
}
#inline_calendar .flatpickr-day {
    color: #334155 !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
    border: none !important;
    background: transparent !important;
    border-radius: 9999px !important; /* Lingkaran penuh default */
    transition: all 0.2s ease !important;
    box-shadow: none !important;
    width: 38px !important;
    height: 38px !important;
    line-height: 38px !important;
    max-width: 38px !important;
    margin: 2px 0 !important;
}
.dark #inline_calendar .flatpickr-day {
    color: #cbd5e1 !important;
}

/* Efek Hover Lingkaran Abu */
#inline_calendar .flatpickr-day:hover:not(.selected):not(.startRange):not(.endRange):not(.inRange):not(.disabled):not(.prevMonthDay):not(.nextMonthDay) {
    background: #f1f5f9 !important; /* Tailwind slate-100 */
    color: #0f172a !important;      /* Tailwind slate-900 */
}
.dark #inline_calendar .flatpickr-day:hover:not(.selected):not(.startRange):not(.endRange):not(.inRange):not(.disabled):not(.prevMonthDay):not(.nextMonthDay) {
    background: #334155 !important;
    color: #f8fafc !important;
}

/* Tanggal Terdiseble atau Bulan Lain */
#inline_calendar .flatpickr-day.prevMonthDay, 
#inline_calendar .flatpickr-day.nextMonthDay,
#inline_calendar .flatpickr-day.disabled {
    color: #cbd5e1 !important; /* Tailwind slate-300 */
    font-weight: 400 !important;
}
.dark #inline_calendar .flatpickr-day.prevMonthDay, 
.dark #inline_calendar .flatpickr-day.nextMonthDay,
.dark #inline_calendar .flatpickr-day.disabled {
    color: #475569 !important; /* Tailwind slate-600 */
}

/* Range Selection - Lingkaran Merah Solid dengan shadow premium */
#inline_calendar .flatpickr-day.startRange, 
#inline_calendar .flatpickr-day.endRange, 
#inline_calendar .flatpickr-day.selected {
    background: #ef4444 !important; /* Tailwind red-500 */
    color: #ffffff !important;
    font-weight: 800 !important;
    border: none !important;
    box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.39) !important; /* Glow merah tipis */
    z-index: 2 !important;
}

/* Rentang Tanggal di antara Start & End */
#inline_calendar .flatpickr-day.inRange {
    background: #fee2e2 !important; /* Tailwind red-50 (merah sangat muda) */
    color: #ef4444 !important; /* Tailwind red-500 */
    font-weight: 700 !important;
    border: none !important;
    border-radius: 0 !important; /* Buat persegi agar nyambung */
    box-shadow: none !important;
}
.dark #inline_calendar .flatpickr-day.inRange {
    background: rgba(239, 68, 68, 0.15) !important; /* Tembus pandang tipis untuk dark mode */
    color: #fca5a5 !important; /* Tailwind red-300 */
}

/* Extension background for start/end days to connect smoothly to inRange days */
#inline_calendar .flatpickr-day.startRange:not(.endRange)::before,
#inline_calendar .flatpickr-day.endRange:not(.startRange)::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 50%;
    z-index: -1;
    background: #fee2e2 !important; /* Sama dengan inRange */
}
.dark #inline_calendar .flatpickr-day.startRange:not(.endRange)::before,
.dark #inline_calendar .flatpickr-day.endRange:not(.startRange)::before {
    background: rgba(239, 68, 68, 0.15) !important;
}
/* Start nyambung ke kanan */
#inline_calendar .flatpickr-day.startRange:not(.endRange)::before {
    right: -2px; /* Pull into gap */
    left: 50%;
}
/* End nyambung ke kiri */
#inline_calendar .flatpickr-day.endRange:not(.startRange)::before {
    left: -2px; /* Pull into gap */
    right: 50%;
}

/* Hari ini (Today) Indikator */
#inline_calendar .flatpickr-day.today:not(.selected):not(.startRange):not(.endRange) {
    border: 2px solid #e2e8f0 !important; /* Tailwind slate-200 */
    background: transparent !important;
    color: #0f172a !important; /* Tailwind slate-900 */
}
.dark #inline_calendar .flatpickr-day.today:not(.selected):not(.startRange):not(.endRange) {
    border: 2px solid #334155 !important;
    color: #f8fafc !important;
}
</style>
