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

            {{-- area Stats --}}
            @if($internship->status !== 'finished')
                <x-attendance-stats :totalPresent="$totalPresent" :attendancePercentage="$attendancePercentage" :totalPermit="$totalPermit" />
            @endif

            {{-- Graduation Showcase / Banner Kelulusan --}}
            @if($internship->status === 'finished')
                <div class="bg-gradient-to-br from-red-600 via-red-500 to-rose-500 rounded-3xl shadow-2xl overflow-hidden relative mb-8">
                    <!-- Decorative patterns -->
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    
                    <div class="px-8 py-10 md:px-12 md:py-16 relative z-10 text-center md:text-left flex flex-col md:flex-row items-center gap-8">
                        <div class="shrink-0">
                            <div class="w-24 h-24 md:w-32 md:h-32 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/30 shadow-xl animate-bounce">
                                <span class="text-5xl md:text-6xl text-white">🎓</span>
                            </div>
                        </div>
                        
                        <div class="flex-1 text-white">
                            <h3 class="text-3xl md:text-5xl font-black mb-4 tracking-tight">Selamat! Magang Tuntas.</h3>
                            <p class="text-lg md:text-xl text-red-50 opacity-90 leading-relaxed max-w-2xl">
                                Anda telah resmi menyelesaikan program magang MBKM di <span class="font-bold underline decoration-red-200">Telkom Witel Semarang Jateng Utara</span>. Terima kasih atas dedikasi dan kontribusi luar biasa Anda selama program ini.
                            </p>
                            
                            <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                                {{-- 1. Rekap Logbook --}}
                                <a href="{{ route('logbooks.exportExcel') }}" class="inline-flex items-center gap-2 bg-white text-red-600 px-6 py-3 rounded-2xl font-bold hover:bg-red-50 transition-all shadow-lg hover:shadow-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125h-7.5a1.125 1.125 0 0 1-1.125-1.125m0 0h7.5m-7.5 0V5.625m0 12.75v1.5c0 .621-.504 1.125-1.125 1.125M9 5.625v9.75m6-9.75v9.75M3.375 5.625h17.25c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125H3.375a1.125 1.125 0 0 1-1.125-1.125V6.75c0-.621.504-1.125 1.125-1.125Z" />
                                    </svg>
                                    Rekap Logbook (.xlsx)
                                </a>

                                {{-- 2. Transkrip Nilai --}}
                                @php
                                    $transcriptDoc = $internship->documents->where('type', 'transcript')->first();
                                @endphp
                                @if($transcriptDoc)
                                    <a href="{{ Storage::url($transcriptDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-red-700 text-white px-6 py-3 rounded-2xl font-bold hover:bg-red-800 transition-all shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        Transkrip Nilai
                                    </a>
                                @else
                                    <div class="inline-flex items-center gap-2 bg-red-400/30 text-white/70 px-6 py-3 rounded-2xl font-bold cursor-not-allowed border border-white/20 italic text-sm">
                                        Transkrip sedang diproses...
                                    </div>
                                @endif

                                {{-- 3. Sertifikat --}}
                                @php
                                    $certificateDoc = $internship->documents->where('type', 'certificate')->first();
                                @endphp
                                @if($certificateDoc)
                                    <a href="{{ Storage::url($certificateDoc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-amber-400 text-slate-900 px-6 py-3 rounded-2xl font-bold hover:bg-amber-500 transition-all shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A57.419 57.419 0 0 0 12 15.75a57.415 57.415 0 0 0 5.25-4.425V15" />
                                        </svg>
                                        Sertifikat Magang
                                    </a>
                                @else
                                    <div class="inline-flex items-center gap-2 bg-red-400/30 text-white/70 px-6 py-3 rounded-2xl font-bold cursor-not-allowed border border-white/20 italic text-sm">
                                        Sertifikat sedang diproses...
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Column: Logbook List (Takes 2/3 width on large screens) --}}
                <div class="lg:col-span-2 space-y-6">
                    <x-logbook-history :logbooks="$logbooks" :todayLogbook="$todayLogbook" />
                </div> {{-- End Left Column --}}

                {{-- Right Column: Absensi & Mentor --}}
                <div class="space-y-6">
                    {{-- Absensi Card --}}
                    @if($internship->status !== 'finished')
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
                                        
                                        {{-- isCheckInTime variable is now passed from DashboardController --}}

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

                                        {{-- isCheckOutTime variable is now passed from DashboardController --}}

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
                                                <span class="text-xs font-normal text-slate-500">Check Out tersedia pukul 17:00 - 19:00</span>
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
                    @endif

                    {{-- Mentor Card --}}
                    @if($internship->mentor)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="p-1 bg-gradient-to-r from-red-600 to-rose-500"></div>
                            <div class="p-6">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center text-2xl shadow-inner border border-slate-200">
                                        👤
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-lg leading-tight">Mentor Anda</h4>
                                        <p class="text-slate-500 text-xs">Informasi Mentor Pendamping</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                                        <p class="text-slate-800 font-bold">{{ $internship->mentor->name }}</p>
                                    </div>

                                    @if($internship->mentor->mentorProfile)
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jabatan & Unit</p>
                                            <p class="text-slate-700 text-sm font-semibold">{{ $internship->mentor->mentorProfile->position ?? '-' }}</p>
                                            <p class="text-slate-500 text-xs mt-0.5">{{ $internship->division->name ?? ($internship->mentor->mentorProfile->division->name ?? '-') }}</p>
                                        </div>
                                    @endif

                                    <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
                                        <a href="mailto:{{ $internship->mentor->email }}" class="flex items-center gap-3 text-sm text-slate-600 hover:text-red-600 transition-colors group">
                                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-red-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                </svg>
                                            </div>
                                            <span class="truncate">{{ $internship->mentor->email }}</span>
                                        </a>

                                        @if($internship->mentor->mentorProfile && $internship->mentor->mentorProfile->phone_number)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $internship->mentor->mentorProfile->phone_number) }}" target="_blank" class="flex items-center gap-3 text-sm text-slate-600 hover:text-emerald-600 transition-colors group">
                                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-emerald-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                                    </svg>
                                                </div>
                                                <span>{{ $internship->mentor->mentorProfile->phone_number }}</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div> {{-- End Right Column --}}

            </div> {{-- End Grid --}}
        </div> {{-- End Max Width Container --}}
    </div> {{-- End Padding Wrapper --}}

    {{-- MODALS --}}

    {{-- 1. Permission Modal --}}
    <x-permission-modal />

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