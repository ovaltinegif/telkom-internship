@props(['logbooks', 'todayLogbook'])

<div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Riwayat Logbook</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Catat aktivitas harianmu disini</p>
            </div>
            
            @if(isset($todayLogbook) && $todayLogbook)
                <button disabled 
                   class="inline-flex items-center gap-2 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 px-5 py-2.5 rounded-xl text-sm font-semibold cursor-not-allowed border border-slate-200 dark:border-slate-700"
                   title="Anda sudah mengisi logbook hari ini">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                    Logbook Terisi
                </button>
            @else
                <a href="{{ route('logbooks.create') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-500 text-white px-5 py-2.5 rounded-xl hover:shadow-lg hover:shadow-red-500/30 transition-all duration-300 text-sm font-semibold group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 group-hover:scale-110 transition-transform">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                    </svg>
                    Isi Logbook
                </a>
            @endif
        </div>

        {{-- Logbook Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50/50 dark:bg-slate-800/30 border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Aktivitas</th>
                        <th class="px-6 py-4 font-semibold">Bukti</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Catatan Mentor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($logbooks as $logbook)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-200">
                                {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 max-w-xs truncate" title="{{ strip_tags($logbook->activity) }}">
                                {{ Str::limit(strip_tags($logbook->activity), 40) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($logbook->evidence)
                                    <a href="{{ Storage::url($logbook->evidence) }}" target="_blank" class="inline-flex items-center gap-1.5 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.551a.75.75 0 111.061 1.06l-3.45 3.551a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                        </svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-slate-400 dark:text-slate-600 text-xs italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <x-status-badge :status="$logbook->status" />
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-500 italic text-xs">
                                {{ $logbook->mentor_note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-slate-300 dark:text-slate-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <p>Belum ada logbook yang diisi.</p>
                                    <a href="{{ route('logbooks.create') }}" class="text-red-600 dark:text-red-400 font-semibold hover:underline">Yuk isi logbook pertamamu!</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
