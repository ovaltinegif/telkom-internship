<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex flex-col gap-1">
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Hello, ') }} <span class="text-red-600">{{ Auth::user()->name }}!</span> 👋
                </h2>
                <p class="text-slate-500 text-sm">Selamat datang di Dashboard Kegiatan Internship Telkom</p>
            </div>
            
            @if(isset($internship) && $internship->end_date)
                @php
                    $endDate = \Carbon\Carbon::parse($internship->end_date);
                    $now = \Carbon\Carbon::now();
                    $diff = $now->diff($endDate);
                    $isExpired = $now->gt($endDate);
                @endphp
                
                <div class="flex flex-col items-start md:items-end">
                    <p class="text-slate-900 font-semibold text-sm mb-1">Sisa Waktu Magang Anda</p>
                    <div class="flex items-center gap-2">
                         @if(!$isExpired)
                            @if($diff->y > 0)
                                <div class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-xl font-bold text-xl shadow-sm border border-emerald-200">
                                    {{ $diff->y }} <span class="text-sm font-medium">th</span>
                                </div>
                            @endif
                            @if($diff->m > 0 || $diff->y > 0)
                                <div class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-xl font-bold text-xl shadow-sm border border-emerald-200">
                                    {{ $diff->m }} <span class="text-sm font-medium">bl</span>
                                </div>
                            @endif
                            <div class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-xl font-bold text-xl shadow-sm border border-emerald-200">
                                {{ $diff->d }} <span class="text-sm font-medium">hr</span>
                            </div>
                        @else
                             <div class="bg-red-100 text-red-800 px-4 py-1 rounded-xl font-bold text-lg shadow-sm border border-red-200">
                                Masa Magang Berakhir
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4 mb-4 flex items-start gap-3 shadow-sm" role="alert">
                    <div class="shrink-0 text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <strong class="block text-sm font-bold text-emerald-800">Berhasil!</strong>
                        <span class="text-sm text-emerald-700">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Pesan Error --}}
            @if(session('error') || $errors->any())
                <div class="rounded-xl bg-red-50 border border-red-100 p-4 mb-4 flex items-start gap-3 shadow-sm" role="alert">
                    <div class="shrink-0 text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <strong class="block text-sm font-bold text-red-800">Perhatian!</strong>
                        <span class="text-sm text-red-700">{{ session('error') ?? $errors->first() }}</span>
                    </div>
                </div>
            @endif

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Column: Logbook List (Takes 2/3 width on large screens) --}}
                <div class="lg:col-span-2 space-y-6">
                   <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Riwayat Logbook</h3>
                                    <p class="text-sm text-slate-500">Catat aktivitas harianmu disini</p>
                                </div>
                                
                                @if(isset($todayLogbook) && $todayLogbook)
                                    <button disabled 
                                       class="inline-flex items-center gap-2 bg-slate-100 text-slate-400 px-5 py-2.5 rounded-xl text-sm font-semibold cursor-not-allowed border border-slate-200"
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
                                                <td class="px-6 py-4 text-slate-600 max-w-xs truncate" title="{{ strip_tags($logbook->activity) }}">
                                                    {{ Str::limit(strip_tags($logbook->activity), 40) }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($logbook->evidence)
                                                        <a href="{{ Storage::url($logbook->evidence) }}" target="_blank" class="inline-flex items-center gap-1.5 text-red-600 hover:text-red-700 font-medium transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                                <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.551a.75.75 0 111.061 1.06l-3.45 3.551a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                                            </svg>
                                                            Lihat
                                                        </a>
                                                    @else
                                                        <span class="text-slate-400 text-xs italic">Tidak ada</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    <x-status-badge :status="$logbook->status" />
                                                </td>
                                                <td class="px-6 py-4 text-slate-500 italic text-xs">
                                                    {{ $logbook->mentor_note ?? '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                                    <div class="flex flex-col items-center justify-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-slate-300">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                        <p>Belum ada logbook yang diisi.</p>
                                                        <a href="{{ route('logbooks.create') }}" class="text-red-600 font-semibold hover:underline">Yuk isi logbook pertamamu!</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> {{-- End Left Column --}}

                {{-- Right Column: Absensi --}}
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-2xl shadow-xl overflow-hidden text-white relative">
                        <!-- Decorative bg -->
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-red-500/20 rounded-full blur-2xl"></div>

                        <div class="p-6 relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-xl font-bold">Absensi Hari Ini</h3>
                                    <p class="text-indigo-200 text-sm">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                                </div>
                                <div class="bg-white/10 backdrop-blur-md px-3 py-1 rounded-full border border-white/20">
                                    <span class="text-xs font-semibold tracking-wider">LIVE</span>
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-center py-4 space-y-4">
                                @if(!$todayAttendance)
                                    <div class="text-center space-y-4 w-full">
                                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-2 animate-pulse">
                                            <span class="text-3xl">📍</span>
                                        </div>
                                        <div>
                                            <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                            <p class="text-white font-bold text-lg">Belum Check-In</p>
                                        </div>
                                        
                                        @php
                                            $now = \Carbon\Carbon::now();
                                            $startCheckIn = $now->copy()->hour(7)->minute(0)->second(0);
                                            $endCheckIn = $now->copy()->hour(9)->minute(0)->second(0);
                                            // Developer Mode: Testing Attendance
                                            // $isCheckInTime = $now->between($startCheckIn, $endCheckIn);
                                            $isCheckInTime = true; // Always allow check-in for testing
                                        @endphp

                                        @if($isCheckInTime)
                                            <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm" class="w-full">
                                                @csrf
                                                <input type="hidden" name="latitude" id="lat_in">
                                                <input type="hidden" name="longitude" id="long_in">
                                                <button type="button" onclick="confirmCheckIn()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                                   CHECK IN SEKARANG
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-full bg-slate-800/50 border border-slate-700 text-slate-400 font-bold py-3.5 rounded-xl text-center flex flex-col items-center justify-center gap-1 cursor-not-allowed">
                                                <span>Check In Ditutup</span>
                                                <span class="text-xs font-normal text-slate-500">Hanya tersedia pukul 07:00 - 09:00</span>
                                            </div>
                                        @endif
                                        
                                        <div class="pt-2">
                                            <button onclick="openPermissionModal()" class="text-sm text-indigo-300 hover:text-white hover:underline transition-colors pb-1">
                                                Tidak masuk kerja? Ajukan Izin
                                            </button>
                                        </div>
                                    </div>

                                @elseif($todayAttendance->permit_type === 'temporary' && !$todayAttendance->check_in_time)
                                    @php
                                        $permitEndTime = \Carbon\Carbon::parse($todayAttendance->date . ' ' . $todayAttendance->permit_end_time);
                                        $isLocked = \Carbon\Carbon::now()->lt($permitEndTime);
                                    @endphp

                                    <div class="text-center space-y-4 w-full">
                                        @if($isLocked)
                                            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-2 border border-amber-200">
                                                <span class="text-3xl">⏳</span>
                                            </div>
                                            <div>
                                                <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                                <p class="text-white font-bold text-lg">Sedang Izin Sementara</p>
                                                <p class="text-indigo-200 text-xs mt-1">Check-in akan terbuka pukul {{ $permitEndTime->format('H:i') }}</p>
                                            </div>
                                        @else
                                            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-2 animate-pulse">
                                                <span class="text-3xl">📍</span>
                                            </div>
                                            <div>
                                                <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                                <p class="text-white font-bold text-lg">Waktu Izin Habis</p>
                                                <p class="text-emerald-300 text-xs mt-1">Silakan Check-in untuk melanjutkan magang.</p>
                                            </div>
                                            
                                            <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm" class="w-full">
                                                @csrf
                                                <input type="hidden" name="latitude" id="lat_in">
                                                <input type="hidden" name="longitude" id="long_in">
                                                <button type="button" onclick="confirmCheckIn()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                                   CHECK IN KEMBALI
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                @elseif($todayAttendance->permit_type === 'full')
                                     <div class="text-center space-y-4 w-full">
                                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-2 border border-amber-200">
                                            <span class="text-3xl">📝</span>
                                        </div>
                                        <div>
                                            <p class="text-indigo-100 text-sm mb-1">Status Kehadiran</p>
                                            <p class="text-white font-bold text-lg">Sedang Izin Full Day</p>
                                        </div>
                                    </div>

                                @elseif(!$todayAttendance->check_out_time)
                                    <div class="text-center space-y-4 w-full">
                                        <div class="bg-emerald-500/20 border border-emerald-500/30 rounded-xl p-4 w-full mb-2">
                                            <p class="text-emerald-200 text-xs uppercase tracking-wide font-bold">Waktu Masuk</p>
                                            <p class="text-2xl font-mono text-emerald-400 font-bold mt-1">{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</p>
                                        </div>

                                        @php
                                            $now = \Carbon\Carbon::now();
                                            $startCheckOut = $now->copy()->hour(17)->minute(0)->second(0);
                                            // Developer Mode: Testing Attendance
                                            // $isCheckOutTime = $now->gte($startCheckOut);
                                            $isCheckOutTime = true; // Always allow check-out for testing
                                        @endphp

                                        @if($isCheckOutTime)
                                            <form action="{{ route('attendance.checkOut') }}" method="POST" id="checkOutForm" class="w-full">
                                                @csrf
                                                <button type="button" onclick="confirmCheckOut()" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-rose-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                                   CHECK OUT PULANG
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-full bg-slate-800/50 border border-slate-700 text-slate-400 font-bold py-3.5 rounded-xl text-center flex flex-col items-center justify-center gap-1 cursor-not-allowed">
                                                <span>Belum Waktunya Pulang</span>
                                                <span class="text-xs font-normal text-slate-500">Check Out terbuka pukul 17:00</span>
                                            </div>
                                        @endif

                                        <div class="pt-2">
                                            <button onclick="openPermissionModal(true)" class="text-sm text-indigo-300 hover:text-white hover:underline transition-colors pb-1">
                                                Izin Setengah Hari / Keluar Sementara?
                                            </button>
                                        </div>
                                    </div>

                                @else
                                    <div class="text-center space-y-4 w-full">
                                        <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-2 shadow-lg shadow-emerald-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-bold text-lg">Kehadiran Terekam!</p>
                                            <p class="text-emerald-300 text-sm">Terima kasih atas kerja kerasmu hari ini.</p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 w-full mt-4">
                                            <div class="bg-white/5 rounded-lg p-3 text-center">
                                                <p class="text-xs text-indigo-300 uppercase">Masuk</p>
                                                <p class="font-mono text-sm font-bold text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</p>
                                            </div>
                                            <div class="bg-white/5 rounded-lg p-3 text-center">
                                                <p class="text-xs text-indigo-300 uppercase">Keluar</p>
                                                <p class="font-mono text-sm font-bold text-white">{{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i:s') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> {{-- End Right Column --}}

            </div> {{-- End Grid --}}
        </div> {{-- End Max Width Container --}}
    </div> {{-- End Padding Wrapper --}}

    {{-- MODALS --}}

    {{-- 1. Permission Modal --}}
    {{-- 1. Permission Modal --}}
    {{-- 1. Permission Modal --}}
    <div id="permissionModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal('permissionModal')"></div>
            
            {{-- Spacer removed --}}
            
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-lg border border-slate-100">
                
                {{-- Modal Header --}}
                <div class="bg-white px-6 py-4 flex justify-between items-center border-b border-slate-100">
                    <h3 class="text-lg leading-6 font-bold text-slate-800">Pengajuan Izin</h3>
                    <button type="button" onclick="closeModal('permissionModal')" class="text-slate-400 hover:text-red-500 transition-colors bg-white hover:bg-red-50 rounded-lg p-1.5 border border-transparent hover:border-red-100">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" class="px-6 pb-6 pt-2">
                    @csrf
                    
                    <div class="space-y-5">
                        {{-- 1. Date Section --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Tanggal Pengajuan</label>
                            
                            @php
                                $displayDate = \Carbon\Carbon::now()->hour < 7 ? \Carbon\Carbon::yesterday() : \Carbon\Carbon::today();
                            @endphp

                            {{-- Badge Display --}}
                            <div id="date_badge_container" class="hidden flex items-center justify-center gap-2">
                                <div class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xl border border-red-100 shadow-sm">
                                    {{ $displayDate->format('d') }}
                                </div>
                                <div class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xl border border-red-100 shadow-sm">
                                    {{ $displayDate->translatedFormat('F') }}
                                </div>
                                <div class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xl border border-red-100 shadow-sm">
                                    {{ $displayDate->format('Y') }}
                                </div>
                            </div>

                            <input type="hidden" name="date" value="{{ $displayDate->format('Y-m-d') }}" id="hidden_date_input">

                            {{-- Date Input --}}
                            <div id="date_input_container" class="relative group w-full">
                                <input type="text" name="date" id="permission_date"
                                    class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm bg-white py-3 pl-10 transition-all text-left font-semibold text-slate-700" 
                                    placeholder="Pilih tanggal..." required>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                        <path fill-rule="evenodd" d="M6.75 2.25a.75.75 0 01.75.75v.75h9v-.75a.75.75 0 011.5 0v.75h1.5a3 3 0 013 3v15a3 3 0 01-3 3h-15a3 3 0 01-3-3v-15a3 3 0 013-3h1.5v-.75a.75.75 0 01.75-.75zM3.75 6.75a1.5 1.5 0 00-1.5 1.5v12a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-12a1.5 1.5 0 00-1.5-1.5h-15z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Permit Type --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Jenis Izin</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Temporary Permit Card -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="permit_type" value="temporary" class="peer sr-only" onchange="toggleAttachment()" checked>
                                    <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-red-200 bg-white transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:ring-1 peer-checked:ring-red-500">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-lg bg-red-100 text-red-600 peer-checked:bg-red-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-700 peer-checked:text-red-700">Izin Keluar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute top-2 right-2 peer-checked:block hidden text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </label>

                                <!-- Full Day Permit Card -->
                                <label class="cursor-pointer relative" id="full_permit_label">
                                    <input type="radio" name="permit_type" value="full" class="peer sr-only" onchange="toggleAttachment()">
                                    <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-red-200 bg-white transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:ring-1 peer-checked:ring-red-500 peer-disabled:opacity-50 peer-disabled:cursor-not-allowed">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-lg bg-slate-100 text-slate-600 peer-checked:bg-red-200 peer-checked:text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 1.5h-3c-1.103 0-2 .897-2 2s.897 2 2 2h3c1.103 0 2-.897 2-2s-.897-2-2-2z" clip-rule="evenodd" />
                                                    <path d="M4.5 9h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9A2.25 2.25 0 012.25 20.25v-9A2.25 2.25 0 014.5 9z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-700 peer-checked:text-red-700">Izin Full / Sakit</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute top-2 right-2 peer-checked:block hidden text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 3. Time Inputs (Conditional) --}}
                        <div id="time_div" class="hidden space-y-3">
                                <label class="block text-sm font-semibold text-slate-700">Durasi Izin</label>
                                <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-200">
                                    {{-- Start Time --}}
                                    <div class="relative flex-1">
                                        <input type="text" name="start_time" id="start_time" 
                                            class="block w-full text-center bg-transparent border-0 focus:ring-0 text-slate-800 font-bold text-lg placeholder-slate-400 p-0"
                                            placeholder="Jam Mulai">
                                        <span class="text-xs text-slate-400 block text-center uppercase tracking-wider font-semibold">Mulai</span>
                                    </div>

                                    <div class="text-slate-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                            <path fill-rule="evenodd" d="M16.72 7.72a.75.75 0 011.06 0l3.75 3.75a.75.75 0 010 1.06l-3.75 3.75a.75.75 0 11-1.06-1.06l2.47-2.47H3a.75.75 0 010-1.5h16.19l-2.47-2.47a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </div>

                                    {{-- End Time --}}
                                    <div class="relative flex-1">
                                        <input type="text" name="end_time" id="end_time" 
                                            class="block w-full text-center bg-transparent border-0 focus:ring-0 text-slate-800 font-bold text-lg placeholder-slate-400 p-0"
                                            placeholder="Jam Selesai">
                                        <span class="text-xs text-slate-400 block text-center uppercase tracking-wider font-semibold">Selesai</span>
                                    </div>
                                </div>
                        </div>

                        {{-- 4. Reason --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alasan Izin</label>
                            <textarea name="note" rows="3" 
                                class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 px-3 transition-all" 
                                required placeholder="Jelaskan alasan izin Anda secara detail..."></textarea>
                        </div>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="pt-2 flex justify-end gap-3 border-t border-slate-100 mt-6 md:-mx-6 md:bg-slate-50/50 md:px-6 md:py-4 -mb-6 rounded-b-2xl">
                        <button type="button" onclick="closeModal('permissionModal')" 
                            class="bg-white hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-5 rounded-xl border border-slate-200 shadow-sm transition-all text-sm">
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

    {{-- Scripts --}}
    <script>
    // Modal Functions
    function openPermissionModal(isCheckedIn = false) { 
        document.getElementById('permissionModal').classList.remove('hidden'); 
        
        const typeSelect = document.getElementById('permit_type');
        
        // Elements for Date Toggle
        const badgeContainer = document.getElementById('date_badge_container');
        const inputContainer = document.getElementById('date_input_container');
        const dateInput = document.getElementById('permission_date');
        const hiddenDateInput = document.getElementById('hidden_date_input');

        // Radio Buttons
        const tempRadio = document.querySelector('input[name="permit_type"][value="temporary"]');
        const fullRadio = document.querySelector('input[name="permit_type"][value="full"]');
        const fullLabel = document.getElementById('full_permit_label');

        if (isCheckedIn) {
            // 1. Show Badge, Hide Input
            badgeContainer.classList.remove('hidden');
            inputContainer.classList.add('hidden');
            
            // Manage Inputs: Enable Hidden, Disable Manual
            dateInput.removeAttribute('required'); 
            dateInput.disabled = true; 
            hiddenDateInput.disabled = false;

            // 2. Lock Permit Type to 'temporary'
            tempRadio.checked = true;
            fullRadio.disabled = true;
            
            // Visual disable for Label/Card
            fullLabel.classList.add('opacity-50', 'cursor-not-allowed');
            fullLabel.classList.remove('cursor-pointer');
        } else {
            // 1. Show Input, Hide Badge
            badgeContainer.classList.add('hidden');
            inputContainer.classList.remove('hidden');
            
            // Manage Inputs: Disable Hidden, Enable Manual
            dateInput.setAttribute('required', 'required');
            dateInput.disabled = false; 
            hiddenDateInput.disabled = true;

             // 2. Unlock Permit Type
             fullRadio.disabled = false;
             
             // Restore Visual
             fullLabel.classList.remove('opacity-50', 'cursor-not-allowed');
             fullLabel.classList.add('cursor-pointer');
        }

        toggleAttachment(); // Ensure correct initial state
    }
    
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        // Logic for Time Input (Temporary Permit)
        function toggleAttachment() {
            // Get checked radio value
            const type = document.querySelector('input[name="permit_type"]:checked')?.value || 'temporary';
            const timeDiv = document.getElementById('time_div');
            const startTime = document.getElementById('start_time');
            const endTime = document.getElementById('end_time');

            if (type === 'temporary') {
                timeDiv.classList.remove('hidden');
                startTime.setAttribute('required', 'required');
                endTime.setAttribute('required', 'required');
            } else {
                timeDiv.classList.add('hidden');
                startTime.removeAttribute('required');
                endTime.removeAttribute('required');
            }
        }

    // 1. Fungsi Konfirmasi CHECK-IN
    // ... existing scripts below ...
    function confirmCheckIn() {
        Swal.fire({
            title: 'Siap untuk Check-In?',
            text: "Pastikan kamu sudah berada di lokasi kantor!",
            icon: 'question',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#10b981', // Emerald 500
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Check In!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengambil Lokasi...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                getLocationAndSubmit();
            }
        });
    }

    // 2. Fungsi Ambil Lokasi & Submit Otomatis
    function getLocationAndSubmit() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lat_in').value = position.coords.latitude;
                    document.getElementById('long_in').value = position.coords.longitude;
                    document.getElementById('checkInForm').submit();
                },
                function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengambil lokasi. Pastikan GPS aktif.',
                    });
                }
            );
        } else { 
            Swal.fire('Error', 'Browser tidak mendukung Geolocation.', 'error');
        }
    }

    // 3. Fungsi Konfirmasi CHECK-OUT
    function confirmCheckOut() {
        Swal.fire({
            title: 'Mau pulang sekarang?',
            text: 'Pastikan pekerjaan hari ini sudah selesai ya!',
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#f43f5e', // Rose 500
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Check Out',
            cancelButtonText: 'Masih lembur'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkOutForm').submit();
            }
        });
    }

    // GPS Helper for legacy/debugging
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latEl = document.getElementById('lat_in');
                const longEl = document.getElementById('long_in');
                if (latEl && longEl) {
                    latEl.value = position.coords.latitude;
                    longEl.value = position.coords.longitude;
                }
            });
        }
    }
    // Call once on load
    getLocation(); 

    // Init Flatpickr for Permission Date
    document.addEventListener('DOMContentLoaded', function() {
        // Date Picker
        flatpickr("#permission_date", {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd F Y',
            locale: 'id',
            disableMobile: true,
            minDate: "today"
        });

        // Time Pickers
        flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: true,
            allowInput: true
        });

        flatpickr("#end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: true,
            allowInput: true
        });
    });
    </script>
</x-app-layout>