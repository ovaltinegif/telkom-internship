<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Penilaian Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 border-b pb-4">
                        <h3 class="text-lg font-bold">Mahasiswa: {{ $student->name }}</h3>
                        {{-- Pastikan relasi division ada di model Internship, kalau error hapus bagian division ini --}}
                        <p class="text-sm text-gray-600">Divisi: {{ $internship->division->name ?? '-' }}</p>
                    </div>

                    <form action="{{ route('mentor.evaluations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="internship_id" value="{{ $internship->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Input Technical Score --}}
                            <div>
                                <x-input-label for="score_technical" :value="__('Nilai Teknis (Hard Skill)')" />
                                <p class="text-xs text-gray-500 mb-2">Pemahaman tools, coding, penyelesaian tugas.</p>
                                <x-text-input id="score_technical" class="block mt-1 w-full" type="number" name="score_technical" :value="old('score_technical')" required min="0" max="100" placeholder="0 - 100" />
                                <x-input-error :messages="$errors->get('score_technical')" class="mt-2" />
                            </div>

                            {{-- Input Soft Skill Score --}}
                            <div>
                                <x-input-label for="score_soft_skill" :value="__('Nilai Perilaku (Soft Skill)')" />
                                <p class="text-xs text-gray-500 mb-2">Komunikasi, disiplin, kerja sama tim.</p>
                                <x-text-input id="score_soft_skill" class="block mt-1 w-full" type="number" name="score_soft_skill" :value="old('score_soft_skill')" required min="0" max="100" placeholder="0 - 100" />
                                <x-input-error :messages="$errors->get('score_soft_skill')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Input Feedback --}}
                        <div class="mb-6">
                            <x-input-label for="feedback" :value="__('Catatan / Feedback Mentor')" />
                            <textarea id="feedback" name="feedback" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tuliskan kesan, pesan, atau evaluasi untuk mahasiswa ini..."></textarea>
                            <x-input-error :messages="$errors->get('feedback')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Simpan Nilai Akhir
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>