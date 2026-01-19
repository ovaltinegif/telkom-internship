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
                    <p class="mb-6">Berikut adalah ringkasan aktivitas mahasiswa bimbingan Anda.</p>

                    {{-- Ubah grid jadi 2 kolom saja biar lebih pas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- 1. Widget GABUNGAN (Data Mahasiswa + Notif Logbook) --}}
                        <div class="p-6 border rounded-xl shadow-sm bg-indigo-50 hover:bg-indigo-100 transition relative overflow-hidden">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-xl text-indigo-700">👥 Aktivitas Mahasiswa</h4>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Pantau logbook, absensi, dan progress mahasiswa.
                                    </p>
                                    
                                    {{-- Notifikasi Pintar: Muncul cuma kalau ada yang pending --}}
                                    @if(isset($pendingLogbooks) && $pendingLogbooks > 0)
                                        <div class="mt-4 bg-white px-3 py-2 rounded-lg border border-indigo-200 inline-flex items-center gap-2">
                                            <span class="flex h-3 w-3 relative">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                            </span>
                                            <span class="text-sm font-semibold text-indigo-600">
                                                {{ $pendingLogbooks }} Logbook Menunggu Validasi
                                            </span>
                                        </div>
                                    @else
                                        <div class="mt-4 text-sm text-gray-500 italic">
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Ikon Hiasan (Opsional) --}}
                                <div class="opacity-10 absolute right-[-10px] bottom-[-10px] text-9xl">
                                    👨‍🎓
                                </div>
                            </div>

                            <a href="{{ route('mentor.students.index') }}" class="inline-block mt-6 px-5 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 transition shadow-md">
                                Buka Daftar Mahasiswa 
                            </a>
                        </div>

                        {{-- 2. Widget Penilaian --}}
                        <div class="p-6 border rounded-xl shadow-sm bg-yellow-50 hover:bg-yellow-100 transition relative overflow-hidden">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-xl text-yellow-700">⭐ Penilaian Akhir</h4>
                                    <p class="text-sm text-gray-600 mt-2">Input nilai magang setelah periode berakhir.</p>
                                </div>
                                <div class="opacity-10 absolute right-[-10px] bottom-[-10px] text-9xl">
                                    📝
                                </div>
                            </div>

                            <button class="mt-6 px-5 py-2.5 bg-yellow-600 text-white font-medium text-sm rounded-lg hover:bg-yellow-700 transition shadow-md">
                                Input Nilai
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>