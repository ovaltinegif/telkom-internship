<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mentor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Bapak/Ibu Mentor!</h3>
                    <p class="mb-6">Ini adalah halaman khusus untuk memantau aktivitas anak magang.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 border rounded-lg shadow-sm bg-indigo-50 hover:bg-indigo-100 transition">
                            <h4 class="font-bold text-indigo-700">👥 Data Mahasiswa</h4>
                            <p class="text-sm text-gray-600 mt-1">Lihat daftar mahasiswa yang Anda bimbing.</p>
                            <a href="{{ route('mentor.students.index') }}" class="inline-block mt-3 px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                                Lihat Mahasiswa
                            </a>
                        </div>

                        <div class="p-4 border rounded-lg shadow-sm bg-green-50 hover:bg-green-100 transition">
                            <h4 class="font-bold text-green-700">✅ Validasi Logbook</h4>
                            <p class="text-sm text-gray-600 mt-1">Periksa dan setujui logbook harian.</p>
                            <button class="mt-3 px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">Cek Logbook</button>
                        </div>

                        <div class="p-4 border rounded-lg shadow-sm bg-yellow-50 hover:bg-yellow-100 transition">
                            <h4 class="font-bold text-yellow-700">⭐ Penilaian Magang</h4>
                            <p class="text-sm text-gray-600 mt-1">Input nilai akhir magang mahasiswa.</p>
                            <button class="mt-3 px-4 py-2 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">Input Nilai</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>