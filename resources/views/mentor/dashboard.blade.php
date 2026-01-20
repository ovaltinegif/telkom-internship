<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mentor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian Atas: Ringkasan / Widget Status --}}
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-indigo-50 border border-indigo-100 p-6 rounded-xl shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-indigo-600">Logbook Menunggu Validasi</p>
                        <h3 class="text-3xl font-bold text-indigo-800 mt-2">
                            {{ $pendingLogbooks ?? 0 }}
                        </h3>
                    </div>
                    <div class="text-indigo-200 text-5xl">
                        📚
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Mahasiswa Bimbingan</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ $internships->count() }}
                        </h3>
                    </div>
                    <div class="text-gray-200 text-5xl">
                        👨‍🎓
                    </div>
                </div>
            </div>

            {{-- Bagian Utama: Langsung Tampilkan Tabel Mahasiswa (Tanpa Klik-Klik Lagi) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📋 Daftar Mahasiswa Bimbingan Anda</h3>
                    
                    @if($internships->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            Belum ada mahasiswa yang ditugaskan kepada Anda.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-gray-700 uppercase font-bold">
                                    <tr>
                                        <th class="px-6 py-3">Nama Mahasiswa</th>
                                        <th class="px-6 py-3">Divisi</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3 text-center">Aksi Cepat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($internships as $internship)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $internship->student->name }}
                                            <div class="text-xs text-gray-400 font-normal">{{ $internship->student->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                {{ $internship->division->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($internship->status == 'active')
                                                <span class="text-green-600 font-semibold flex items-center gap-1">
                                                    ● Aktif
                                                </span>
                                            @elseif($internship->status == 'finished')
                                                <span class="text-gray-500 font-semibold flex items-center gap-1">
                                                    ✔ Selesai
                                                </span>
                                            @else
                                                <span class="text-yellow-600 font-semibold">
                                                    {{ ucfirst($internship->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('mentor.students.show', $internship->student->id) }}" 
                                               class="text-gray-600 hover:text-blue-600 border border-gray-300 hover:border-blue-500 px-3 py-1 rounded-md text-xs transition">
                                                Detail
                                            </a>

                                            {{-- Tombol Penilaian (Langsung Disini!) --}}
                                            @if(!$internship->evaluation)
                                                <a href="{{ route('mentor.evaluations.create', $internship->student->id) }}" 
                                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-md text-xs shadow transition">
                                                    ★ Input Nilai
                                                </a>
                                            @else
                                                <span class="text-green-600 text-xs font-bold border border-green-200 bg-green-50 px-3 py-1 rounded-md">
                                                    Sudah Dinilai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>