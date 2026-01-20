<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-gray-500 text-sm">Total Mahasiswa</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-green-200 bg-green-50">
                    <div class="text-green-600 text-sm font-semibold">Magang Aktif</div>
                    <div class="text-3xl font-bold text-green-800">{{ $activeInternships }}</div>
                </div>

                <div class="bg-indigo-600 p-6 rounded-lg shadow-sm flex flex-col justify-center items-center text-center">
                    <h3 class="text-white font-semibold text-lg mb-2">Kelola Magang</h3>
                    <a href="{{ route('admin.internship.create') }}" class="px-4 py-2 bg-white text-indigo-700 font-bold rounded-md hover:bg-gray-100 transition w-full">
                        + Setup Magang Baru
                    </a>
                </div>
            </div>

            {{-- Tabel Magang Terbaru --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Magang Terbaru</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-100 text-gray-700 uppercase font-bold">
                                <tr>
                                    <th class="px-6 py-3">Mahasiswa</th>
                                    <th class="px-6 py-3">Divisi</th>
                                    <th class="px-6 py-3">Mentor</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($recentInternships as $internship)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $internship->student->name }}
                                        <div class="text-xs text-gray-400">{{ $internship->student->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $internship->division->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $internship->mentor->name ?? 'Belum ada' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $internship->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($internship->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada data magang.</td>
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