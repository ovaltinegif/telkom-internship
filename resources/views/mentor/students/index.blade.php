<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Mahasiswa Bimbingan') }}
        </h2>
        <p class="text-slate-500 text-sm">Kelola data dan pantau progres mahasiswa bimbingan Anda</p>
    </x-slot>

    <div class="py-12"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-6">
                    
                    @if($internships->isEmpty())
                        <div class="text-center py-16 flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Belum Ada Mahasiswa</h3>
                            <p class="text-slate-500">Anda belum memiliki mahasiswa bimbingan saat ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs">Mahasiswa</th>
                                        <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs">Instansi / Kampus</th>
                                        <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs">Divisi</th>
                                        <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs text-center">Periode</th>
                                        <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs text-center">Status</th>
                                        <th class="px-6 py-4 font-semibold text-slate-600 uppercase tracking-wider text-xs text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($internships as $index => $data)
                                    <tr class="group hover:bg-slate-50/50 transition-colors">
                                        
                                        {{-- Mahasiswa (Avatar + Name) --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-slate-200 to-slate-100 flex items-center justify-center text-slate-600 font-bold border border-white shadow-sm ring-1 ring-slate-100">
                                                    {{ substr($data->student->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-slate-800 text-base">{{ $data->student->name }}</div>
                                                    <div class="text-xs text-slate-500">{{ $data->student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        {{-- Kampus --}}
                                        <td class="px-6 py-4">
                                            <div class="text-slate-700 font-medium">
                                                {{ $data->student->studentProfile->university ?? 'Belum Lengkap' }}
                                            </div>
                                        </td>

                                        {{-- Divisi (Badge) --}}
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $data->division->name ?? '-' }}
                                            </span>
                                        </td>      
                                        
                                        {{-- Periode --}}
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex flex-col items-center">
                                                <span class="text-xs font-semibold text-slate-700">
                                                    {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}
                                                </span>
                                                <span class="text-[10px] text-slate-400 my-0.5">s/d</span>
                                                <span class="text-xs font-semibold text-slate-700">
                                                    {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        {{-- Status --}}
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $statusConfig = [
                                                    'active' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'label' => 'Aktif'],
                                                    'onboarding' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'label' => 'Onboarding'],
                                                    'finished' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'label' => 'Selesai'],
                                                    'dropped' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100', 'label' => 'Dropped'],
                                                ];
                                                $config = $statusConfig[$data->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-200', 'label' => ucfirst($data->status)];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} border">
                                                {{ $config['label'] }}
                                            </span>
                                        </td>
                                        
                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('mentor.students.show', $data->id) }}" 
                                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm hover:shadow">
                                                Detail
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                                </svg>
                                            </a> 
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