<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setup Program Magang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Tampilkan Error Validasi jika ada --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 text-red-600 p-4 rounded-lg">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.internship.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="student_id" :value="__('Pilih Mahasiswa')" />
                        <select name="student_id" id="student_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Cari Mahasiswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="division_id" :value="__('Penempatan Divisi')" />
                        <select name="division_id" id="division_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="mentor_id" :value="__('Mentor Pembimbing')" />
                        <select name="mentor_id" id="mentor_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Pilih Mentor --</option>
                            @foreach($mentors as $mentor)
                                <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                            <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                            <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4 pt-4 border-t">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 underline text-sm mr-4">Batal</a>
                        <x-primary-button>
                            {{ __('Simpan & Aktifkan Magang') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>