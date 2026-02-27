<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
            {{ __('Activity Log') }}
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Riwayat lengkap aktivitas magang kamu</p>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: 'logbook', showModal: false, modalContent: '', modalDate: '', modalTitle: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tabs Navigation --}}
            <div class="border-b border-slate-200 dark:border-slate-800 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'logbook'" 
                        :class="{ 'border-red-500 text-red-600 dark:text-red-400': activeTab === 'logbook', 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:border-slate-300 dark:hover:border-slate-700': activeTab !== 'logbook' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Logbook Aktivitas
                    </button>
                    <button @click="activeTab = 'permission'" 
                        :class="{ 'border-red-500 text-red-600 dark:text-red-400': activeTab === 'permission', 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:border-slate-300 dark:hover:border-slate-700': activeTab !== 'permission' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Riwayat Izin
                    </button>
                    <button @click="activeTab = 'attendance'" 
                        :class="{ 'border-red-500 text-red-600 dark:text-red-400': activeTab === 'attendance', 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:border-slate-300 dark:hover:border-slate-700': activeTab !== 'attendance' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Riwayat Absensi
                    </button>
                </nav>
            </div>

            {{-- Logbook Section --}}
            <div x-show="activeTab === 'logbook'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Semua Aktivitas</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pantau terus perkembangan magangmu</p>
                            </div>
                            @if(Auth::user()->internship && Auth::user()->internship->status === 'active')
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                    <a href="{{ route('logbooks.exportPdf') }}" class="inline-flex items-center gap-2 bg-slate-800 dark:bg-slate-700 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold hover:bg-slate-900 dark:hover:bg-slate-600 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <span class="hidden xs:inline">Unduh</span> PDF
                                    </a>
                                    <a href="{{ route('logbooks.exportExcel') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold hover:bg-emerald-700 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125h-7.5a1.125 1.125 0 0 1-1.125-1.125m0 0h7.5m-7.5 0V5.625m0 12.75v1.5c0 .621-.504 1.125-1.125 1.125M9 5.625v9.75m6-9.75v9.75M3.375 5.625h17.25c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125H3.375a1.125 1.125 0 0 1-1.125-1.125V6.75c0-.621.504-1.125 1.125-1.125Z" />
                                        </svg>
                                        <span class="hidden xs:inline">Unduh</span> Excel
                                    </a>
                                    <a href="{{ route('logbooks.create') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold hover:shadow-lg hover:shadow-red-500/30 transition-all">
                                        + Isi Logbook
                                    </a>
                                </div>
                            @endif
                        </div>
    
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                                <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Tanggal</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Judul</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Aktivitas</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Bukti</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Status</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Catatan Mentor</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                    @forelse($logbooks as $logbook)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                <span class="font-bold">{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                <span class="font-bold">{{ $logbook->title ?? '-' }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300 transition-colors max-w-sm">
                                                <div class="line-clamp-2" title="{{ strip_tags($logbook->activity) }}">
                                                    {{ Str::limit(strip_tags($logbook->activity), 80) }}
                                                </div>
                                                <button 
                                                    @click="showModal = true; modalContent = {{ json_encode($logbook->activity) }}; modalDate = '{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}'; modalTitle = '{{ addslashes($logbook->title) }}'"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-medium mt-1 inline-flex items-center gap-1 transition-colors">
                                                    Lihat Selengkapnya
                                                </button>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                @if($logbook->evidence)
                                                    <a href="{{ Storage::url($logbook->evidence) }}" target="_blank" class="text-red-600 dark:text-red-400 hover:underline">Lihat</a>
                                                @else
                                                    <span class="text-slate-400 dark:text-slate-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                <x-status-badge :status="$logbook->status" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors italic">
                                                {{ $logbook->mentor_note ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                                <div class="flex flex-col items-center justify-center h-full gap-2">
                                                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada aktivitas yang dicatat.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
    
                        <div class="mt-4">
                            {{ $logbooks->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Izin Section --}}
            <div x-show="activeTab === 'permission'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Riwayat Pengajuan Izin</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar izin yang telah Anda ajukan</p>
                        </div>
    
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                                <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Tanggal</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Jenis Izin</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Waktu</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Alasan</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                    @forelse($permissions as $permit)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                <span class="font-bold">{{ \Carbon\Carbon::parse($permit->date)->format('d M Y') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                @if($permit->permit_type == 'full')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-500/20 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50">
                                                        Full Day
                                                    </span>
                                                @elseif($permit->permit_type == 'temporary')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-500/20 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800/50">
                                                        Sementara
                                                    </span>
                                                @else
                                                    <span class="text-slate-500 dark:text-slate-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors font-mono">
                                                @if($permit->permit_type == 'temporary' && $permit->permit_start_time)
                                                    {{ \Carbon\Carbon::parse($permit->permit_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($permit->permit_end_time)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors max-w-xs truncate" title="{{ $permit->note }}">
                                                {{ Str::limit($permit->note, 50) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                                    Tercatat
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                                <div class="flex flex-col items-center justify-center h-full gap-2">
                                                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada riwayat izin.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Riwayat Absensi Section --}}
            <div x-show="activeTab === 'attendance'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Riwayat Absensi</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Catatan kehadiran check-in dan check-out</p>
                        </div>
    
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                                <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Tanggal</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Waktu Masuk</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Waktu Keluar</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Lokasi</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Status</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Durasi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                    @forelse($attendances as $attendance)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                <span class="font-bold">{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors font-mono">
                                                {{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors font-mono">
                                                {{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i:s') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                @if($attendance->check_in_lat && $attendance->check_in_long)
                                                    <a href="https://www.google.com/maps?q={{ $attendance->check_in_lat }},{{ $attendance->check_in_long }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 flex items-center gap-1 text-xs font-bold transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.62.829.799 1.654 1.38 2.274 1.766a11.267 11.267 0 00.758.433l.017.007.006.003.002.001.309.066zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                                        </svg>
                                                        Lihat Peta
                                                    </a>
                                                @else
                                                    <span class="text-slate-400 dark:text-slate-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                                    Hadir
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                                @if($attendance->check_in_time && $attendance->check_out_time)
                                                    @php
                                                        $start = \Carbon\Carbon::parse($attendance->check_in_time);
                                                        $end = \Carbon\Carbon::parse($attendance->check_out_time);
                                                        $diff = $start->diff($end);
                                                    @endphp
                                                    <span class="font-bold">{{ $diff->h }} Jam {{ $diff->i }} Menit</span>
                                                @else
                                                    <span class="text-slate-400 dark:text-slate-500">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                                <div class="flex flex-col items-center justify-center h-full gap-2">
                                                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada riwayat absensi.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Activity Detail Modal -->
            <div x-show="showModal" 
                class="fixed inset-0 z-[1000] overflow-y-auto" 
                aria-labelledby="modal-title" 
                role="dialog" 
                aria-modal="true"
                style="display: none;">
                
                <!-- Backdrop -->
                <div x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" 
                    @click="showModal = false"></div>

                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl w-full border border-slate-200 dark:border-slate-800">
                        
                        <!-- Header -->
                        <div class="bg-white dark:bg-slate-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div class="sm:flex sm:items-start justify-between">
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-slate-100" id="modal-title" x-text="modalTitle || 'Detail Aktivitas'">
                                                Detail Aktivitas
                                            </h3>
                                            <div class="mt-1 text-sm text-slate-500 dark:text-slate-400" x-text="modalDate"></div>
                                        </div>
                                        <button @click="showModal = false" type="button" class="text-slate-400 hover:text-red-500 focus:outline-none transition-colors">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="bg-white dark:bg-slate-900 px-4 py-6 sm:p-6 max-h-[60vh] overflow-y-auto">
                            <div class="prose prose-sm dark:prose-invert max-w-none text-slate-700 dark:text-slate-300" x-html="modalContent"></div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="bg-slate-50 dark:bg-slate-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" 
                                class="inline-flex w-full justify-center rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-5 py-2.5 text-sm font-bold shadow-sm hover:bg-slate-800 dark:hover:bg-slate-100 sm:ml-3 sm:w-auto transition-all"
                                @click="showModal = false">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
