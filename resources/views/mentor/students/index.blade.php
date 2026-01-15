<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Mahasiswa Bimbingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($internships->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500">Anda belum memiliki mahasiswa bimbingan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">No</th>
                                        <th class="py-3 px-6 text-left">Nama Mahasiswa</th>
                                        <th class="py-3 px-6 text-left">Email</th>
                                        <th class="py-3 px-6 text-left">Divisi</th>
                                        <th class="py-3 px-6 text-center">Periode Magang</th>
                                        <th class="py-3 px-6 text-center">Status</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($internships as $index => $data)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="py-3 px-6 text-left font-bold">
                                            {{ $data->student->name }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            {{ $data->student->email }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            {{ $data->division->name ?? '-' }}
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }} - 
                                            {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <span class="px-3 py-1 rounded-full text-xs 
                                                {{ $data->status == 'active' ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                                {{ ucfirst($data->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 font-bold">Detail</a>
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