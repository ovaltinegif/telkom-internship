<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Sukses (Muncul kalau habis simpan logbook) --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Header Tabel & Tombol Tambah --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Riwayat Logbook Harian</h3>
                        <a href="{{ route('logbooks.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                            + Isi Logbook Baru
                        </a>
                    </div>
                                        {{-- Widget Absensi --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold">Absensi Hari Ini</h3>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                            </div>

                            <div>
                                @if(!$todayAttendance)
                                    {{-- Tombol Check In --}}
                                    <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm">
                                        @csrf
                                        <input type="hidden" name="latitude" id="lat_in">
                                        <input type="hidden" name="longitude" id="long_in">
                                        <button type="submit" onclick="getLocation('checkInForm')" class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-700 transition">
                                            📍 CHECK IN (DATANG)
                                        </button>
                                    </form>

                                @elseif(!$todayAttendance->check_out_time)
                                    {{-- Tombol Check Out --}}
                                    <div class="flex items-center gap-4">
                                        <span class="text-green-600 font-semibold">
                                            Masuk: {{ $todayAttendance->check_in_time }}
                                        </span>
                                        <form action="{{ route('attendance.checkOut') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition">
                                                👋 CHECK OUT (PULANG)
                                            </button>
                                        </form>
                                    </div>

                                @else
                                    {{-- Sudah Selesai --}}
                                    <div class="text-right">
                                        <span class="block text-green-600 font-bold">✅ Hadir</span>
                                        <span class="text-sm text-gray-500">
                                            {{ $todayAttendance->check_in_time }} - {{ $todayAttendance->check_out_time }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Script GPS Sederhana --}}
                    <script>
                        function getLocation(formId) {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(function(position) {
                                    document.getElementById('lat_in').value = position.coords.latitude;
                                    document.getElementById('long_in').value = position.coords.longitude;
                                    // Submit form setelah dapat lokasi (opsional, atau user klik 2x)
                                });
                            } else { 
                                alert("Geolocation tidak didukung browser ini.");
                            }
                        }
                        // Panggil sekali saat halaman load biar siap
                        getLocation(); 
                    </script>
                    {{-- Tabel --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Mentor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($logbooks as $logbook)
                                    <tr>
                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                        </td>
                                        
                                        {{-- Aktivitas (Dibatasi panjangnya biar gak ngerusak tabel) --}}
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ Str::limit($logbook->activity, 50) }}
                                        </td>

                                        {{-- Bukti --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:underline">
                                            @if($logbook->evidence)
                                                <a href="{{ Storage::url($logbook->evidence) }}" target="_blank">Lihat Bukti</a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>

                                        {{-- Status (Pakai Badge Warna) --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($logbook->status == 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                            @elseif($logbook->status == 'rejected')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                            @endif
                                        </td>

                                        {{-- Catatan Mentor --}}
                                        <td class="px-6 py-4 text-sm text-gray-500 italic">
                                            {{ $logbook->mentor_note ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            Belum ada logbook yang diisi. <br>
                                            <a href="{{ route('logbooks.create') }}" class="text-indigo-600 hover:underline">Yuk isi logbook pertamamu!</a>
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
</x-app-layout>
