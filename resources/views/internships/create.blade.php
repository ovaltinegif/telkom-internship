<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setup Data Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-4 text-sm text-gray-600">
                    Halo! Sebelum mulai mengisi logbook, silakan lengkapi data magangmu terlebih dahulu.
                </div>

                <form action="{{ route('internships.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Pilih Divisi --}}
                    <div>
                        <x-input-label for="division_id" :value="__('Pilih Divisi')" />
                        <select id="division_id" name="division_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div>
                        <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" required />
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div>
                        <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                        <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" required />
                    </div>

                    <x-primary-button class="w-full justify-center">
                        {{ __('Simpan & Mulai Magang') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>