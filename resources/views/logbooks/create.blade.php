<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Isi Logbook Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Form Start --}}
                    <form action="{{ route('logbooks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Input Tanggal --}}
                        <div>
                            <x-input-label for="date" :value="__('Tanggal Kegiatan')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        {{-- Input Aktivitas (Textarea) --}}
                        <div>
                            <x-input-label for="activity" :value="__('Deskripsi Kegiatan')" />
                            <textarea id="activity" name="activity" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ceritakan apa yang kamu kerjakan hari ini..." required>{{ old('activity') }}</textarea>
                            <x-input-error :messages="$errors->get('activity')" class="mt-2" />
                        </div>

                        {{-- Input Bukti (File Upload) --}}
                        <div>
                            <x-input-label for="evidence" :value="__('Bukti Kegiatan (Foto/Dokumen)')" />
                            <input id="evidence" type="file" name="evidence" class="block mt-1 w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Logbook') }}</x-primary-button>
                        </div>
                    </form>
                    {{-- Form End --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>