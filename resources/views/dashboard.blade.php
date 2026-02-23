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

            {{-- Statistik Kehadiran --}}
            <x-attendance-stats :totalPresent="$totalPresent" :attendancePercentage="$attendancePercentage" :totalPermit="$totalPermit" />

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Column: Logbook List (Takes 2/3 width on large screens) --}}
                <div class="lg:col-span-2 space-y-6">
                    <x-logbook-history :logbooks="$logbooks" :todayLogbook="$todayLogbook" />
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