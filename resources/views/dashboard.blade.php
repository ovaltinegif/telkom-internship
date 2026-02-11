<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Hello, ') }} <span class="text-red-600">{{ Auth::user()->name }}!</span> 👋
            </h2>
            <p class="text-slate-500 text-sm">Selamat datang di Dashboard Kegiatan Internship Telkom</p>
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
                                                    @if($logbook->status == 'approved')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            Disetujui
                                                        </span>
                                                    @elseif($logbook->status == 'rejected')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">
                                                            Ditolak
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                            Menunggu
                                                        </span>
                                                    @endif
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
                                        
                                        <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm" class="w-full">
                                            @csrf
                                            <input type="hidden" name="latitude" id="lat_in">
                                            <input type="hidden" name="longitude" id="long_in">
                                            <button type="button" onclick="confirmCheckIn()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                               CHECK IN SEKARANG
                                            </button>
                                        </form>
                                        
                                        <div class="pt-2">
                                            <button onclick="openPermissionModal()" class="text-xs text-indigo-300 hover:text-white hover:underline transition-colors pb-1">
                                                Tidak masuk kerja? Ajukan Izin
                                            </button>
                                        </div>
                                    </div>

                                @elseif(!$todayAttendance->check_out_time)
                                    <div class="text-center space-y-4 w-full">
                                        <div class="bg-emerald-500/20 border border-emerald-500/30 rounded-xl p-4 w-full mb-2">
                                            <p class="text-emerald-200 text-xs uppercase tracking-wide font-bold">Waktu Masuk</p>
                                            <p class="text-2xl font-mono text-emerald-400 font-bold mt-1">{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</p>
                                        </div>

                                        <form action="{{ route('attendance.checkOut') }}" method="POST" id="checkOutForm" class="w-full">
                                            @csrf
                                            <button type="button" onclick="confirmCheckOut()" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-rose-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                               CHECK OUT PULANG
                                            </button>
                                        </form>
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
    <div id="permissionModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('permissionModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Pengajuan Izin</h3>
                        <button type="button" onclick="closeModal('permissionModal')" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <div class="relative">
                                <input type="text" name="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white" required placeholder="dd/mm/yyyy" id="permission_date">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Izin</label>
                            <select name="permit_type" id="permit_type" onchange="toggleAttachment()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="temporary">Izin Sementara Waktu</option>
                                <option value="full">Izin Penuh (Full Day)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1" id="permit_desc">Pilih jenis izin.</p>
                        </div>

                        {{-- Attachment removed as per user request --}}

                        <div id="time_div" class="hidden grid grid-cols-2 gap-4 transition-all duration-300">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                                <input type="time" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                                <input type="time" name="end_time" id="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alasan</label>
                            <textarea name="note" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required placeholder="Jelaskan alasan izin Anda..."></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('permissionModal')" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
    // Modal Functions
    function openPermissionModal() { 
        document.getElementById('permissionModal').classList.remove('hidden'); 
        toggleAttachment(); // Ensure correct initial state
    }
    
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        // Logic for Time Input (Temporary Permit)
        function toggleAttachment() {
            const type = document.getElementById('permit_type').value;
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
        flatpickr("#permission_date", {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd/m/Y',
            locale: 'id',
            disableMobile: true
        });
    });
    </script>
</x-app-layout>
