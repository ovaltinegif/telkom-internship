<x-app-layout>
    {{-- 1. LOAD LIBRARY SWEETALERT --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Mahasiswa: {{ $internship->student->name }}
            </h2>
            <a href="{{ route('mentor.students.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Universitas</p>
                    <p class="font-bold">{{ $internship->student->studentProfile->university ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Divisi</p>
                    <p class="font-bold text-indigo-600">{{ $internship->division->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Logbook</p>
                    <p class="font-bold">{{ $internship->dailyLogbooks->count() }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">📝 Logbook Harian</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3 w-1/3">Aktivitas</th>
                                    <th class="px-6 py-3">Bukti</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Aksi Mentor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($internship->dailyLogbooks as $logbook)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium">
                                        {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-900">{{ $logbook->activity }}</p>
                                        @if($logbook->mentor_note)
                                            <p class="text-xs text-indigo-600 mt-1">💬 Note: {{ $logbook->mentor_note }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($logbook->evidence)
                                            <a href="{{ asset('storage/' . $logbook->evidence) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-bold">Lihat</a>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($logbook->status == 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Approved</span>
                                        @elseif($logbook->status == 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Rejected</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        
                                        {{-- Cek jika status masih Pending, tampilkan tombol --}}
                                        @if($logbook->status == 'pending')
                                            <form action="{{ route('mentor.logbook.update', $logbook->id) }}" method="POST" class="flex flex-col gap-2">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <input type="text" name="mentor_note" placeholder="Catatan (opsional)" class="text-xs border-gray-300 rounded px-2 py-1 w-full" value="{{ $logbook->mentor_note }}">
                                                
                                                <div class="flex gap-2 justify-center">
                                                    <button type="button" data-status="approved" class="btn-action bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs transition">
                                                        ✓ Terima
                                                    </button>
                                                    <button type="button" data-status="rejected" class="btn-action bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition">
                                                        ✕ Tolak
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            {{-- JIKA SUDAH DINILAI: Tampilkan Badge Saja (LEBIH BERSIH) --}}
                                            <div class="flex justify-center">
                                                <span class="bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full border border-gray-200 uppercase tracking-wider">
                                                    ✔ Sudah Diverifikasi
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Belum ada logbook.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVA SCRIPT UNTUK SWEETALERT --}}
    <script>
        // 1. Cek Session Success (Berhasil Disimpan)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        // 2. Event Listener untuk Tombol Terima/Tolak
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.btn-action');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const status = this.getAttribute('data-status'); // ambil data-status (approved/rejected)
                    const isApproved = status === 'approved';

                    Swal.fire({
                        title: isApproved ? 'Terima Logbook?' : 'Tolak Logbook?',
                        text: isApproved 
                            ? "Logbook ini akan validasi sebagai 'Approved'." 
                            : "Logbook ini akan ditolak. Pastikan sudah memberi catatan.",
                        icon: isApproved ? 'question' : 'warning',
                        showCancelButton: true,
                        confirmButtonColor: isApproved ? '#16a34a' : '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: isApproved ? 'Ya, Terima' : 'Ya, Tolak',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Karena tombol type="button" tidak mengirim value, saya buat input hidden manual
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'status';
                            input.value = status;
                            form.appendChild(input);
                            
                            // Submit form
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>