<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Activity Log') }}
        </h2>
        <p class="text-slate-500 text-sm">Riwayat lengkap aktivitas magang kamu</p>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: 'logbook' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tabs Navigation --}}
            <div class="border-b border-slate-200 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'logbook'" 
                        :class="{ 'border-red-500 text-red-600': activeTab === 'logbook', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'logbook' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Logbook Aktivitas
                    </button>
                    <button @click="activeTab = 'permission'" 
                        :class="{ 'border-red-500 text-red-600': activeTab === 'permission', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'permission' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Riwayat Izin
                    </button>
                    <button @click="activeTab = 'attendance'" 
                        :class="{ 'border-red-500 text-red-600': activeTab === 'attendance', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'attendance' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Riwayat Absensi
                    </button>
                </nav>
            </div>

            {{-- Logbook Section --}}
            <div x-show="activeTab === 'logbook'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Semua Aktivitas</h3>
                                <p class="text-sm text-slate-500 mt-1">Pantau terus perkembangan magangmu</p>
                            </div>
                            @can('create', App\Models\DailyLogbook::class)
                            <a href="{{ route('logbooks.create') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-red-500/30 transition-all">
                                + Isi Logbook
                            </a>
                            @endcan
                            {{-- Fallback button if policy not used --}}
                            <a href="{{ route('logbooks.create') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-red-500/30 transition-all">
                                + Isi Logbook
                            </a>
                        </div>
    
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold">Aktivitas</th>
                                        <th class="px-6 py-4 font-semibold">Bukti</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold">Catatan Mentor</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($logbooks as $logbook)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-medium text-slate-900">
                                                {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 max-w-lg" title="{{ strip_tags($logbook->activity) }}">
                                                {{ Str::limit(strip_tags($logbook->activity), 100) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($logbook->evidence)
                                                    <a href="{{ Storage::url($logbook->evidence) }}" target="_blank" class="text-red-600 hover:underline">Lihat</a>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($logbook->status == 'approved')
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">Disetujui</span>
                                                @elseif($logbook->status == 'rejected')
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">Ditolak</span>
                                                @else
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">Menunggu</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 italic text-xs">
                                                {{ $logbook->mentor_note ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                                Belum ada aktivitas yang tercatat.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
    
                        <div class="mt-4">
                            {{ $logbooks->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Izin Section --}}
            <div x-show="activeTab === 'permission'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-slate-800">Riwayat Pengajuan Izin</h3>
                            <p class="text-sm text-slate-500 mt-1">Daftar izin yang telah Anda ajukan</p>
                        </div>
    
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold">Jenis Izin</th>
                                        <th class="px-6 py-4 font-semibold">Waktu</th>
                                        <th class="px-6 py-4 font-semibold">Alasan</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($permissions as $permit)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-medium text-slate-900">
                                                {{ \Carbon\Carbon::parse($permit->date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($permit->permit_type == 'full')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                        Full Day
                                                    </span>
                                                @elseif($permit->permit_type == 'temporary')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                                        Sementara
                                                    </span>
                                                @else
                                                    <span class="text-slate-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 font-mono text-xs">
                                                @if($permit->permit_type == 'temporary' && $permit->permit_start_time)
                                                    {{ \Carbon\Carbon::parse($permit->permit_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($permit->permit_end_time)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 max-w-xs truncate" title="{{ $permit->note }}">
                                                {{ Str::limit($permit->note, 50) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    Tercatat
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                                Belum ada riwayat izin.
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-slate-800">Riwayat Absensi</h3>
                            <p class="text-sm text-slate-500 mt-1">Catatan kehadiran check-in dan check-out</p>
                        </div>
    
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold">Waktu Masuk</th>
                                        <th class="px-6 py-4 font-semibold">Waktu Keluar</th>
                                        <th class="px-6 py-4 font-semibold">Lokasi</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold">Durasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($attendances as $attendance)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-medium text-slate-900">
                                                {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 font-mono text-xs">
                                                {{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 font-mono text-xs">
                                                {{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i:s') : '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($attendance->check_in_lat && $attendance->check_in_long)
                                                    <a href="https://www.google.com/maps?q={{ $attendance->check_in_lat }},{{ $attendance->check_in_long }}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center gap-1 text-xs font-medium">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.62.829.799 1.654 1.38 2.274 1.766a11.267 11.267 0 00.758.433l.017.007.006.003.002.001.309.066zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                                        </svg>
                                                        Lihat Peta
                                                    </a>
                                                @else
                                                    <span class="text-slate-400 text-xs">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    Hadir
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs">
                                                @if($attendance->check_in_time && $attendance->check_out_time)
                                                    @php
                                                        $start = \Carbon\Carbon::parse($attendance->check_in_time);
                                                        $end = \Carbon\Carbon::parse($attendance->check_out_time);
                                                        $diff = $start->diff($end);
                                                    @endphp
                                                    {{ $diff->h }} Jam {{ $diff->i }} Menit
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                                Belum ada riwayat absensi.
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
    </div>
</x-app-layout>
