<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Penilaian Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Mahasiswa: {{ $internship->student->name ?? 'Nama Mahasiswa' }}</h3>

                <form action="{{ route('evaluations.store', $internship->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nilai Kedisiplinan (0-100)</label>
                        <input type="number" name="discipline_score" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required min="0" max="100">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nilai Kemampuan Teknis (0-100)</label>
                        <input type="number" name="technical_score" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required min="0" max="100">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nilai Soft Skill (Komunikasi/Kerjasama) (0-100)</label>
                        <input type="number" name="soft_skill_score" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required min="0" max="100">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pesan / Masukan untuk Mahasiswa</label>
                        <textarea name="feedback" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"></textarea>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan Nilai
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>