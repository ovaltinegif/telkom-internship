<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Penilaian Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Header Info Mahasiswa --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold">Mahasiswa: {{ $internship->student->name ?? 'Nama Mahasiswa' }}</h3>
                    <p class="text-gray-600 text-sm">Divisi: {{ $internship->division->name ?? '-' }}</p>
                </div>

                {{-- PERBAIKAN: Gunakan route name yang lengkap 'mentor.evaluations.store' --}}
                <form action="{{ route('mentor.evaluations.store', $internship->id) }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        {{-- Nilai Kedisiplinan --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Kedisiplinan (0-100)</label>
                            <input type="number" name="discipline_score" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required min="0" max="100" placeholder="80">
                        </div>

                        {{-- Nilai Teknis --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Kemampuan Teknis (0-100)</label>
                            <input type="number" name="technical_score" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required min="0" max="100" placeholder="85">
                        </div>

                        {{-- Nilai Soft Skill --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Soft Skill (0-100)</label>
                            <input type="number" name="soft_skill_score" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required min="0" max="100" placeholder="90">
                            <p class="text-xs text-gray-500 mt-1">Komunikasi & Kerjasama</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Pesan / Masukan untuk Mahasiswa</label>
                        <textarea name="feedback" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" placeholder="Tuliskan evaluasi kinerja..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded transition">
                            Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>