<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight transition-colors">
            {{ __('Intern Bimbingan') }}
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm transition-colors">Kelola data dan pantau progres intern bimbingan Anda</p>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-8">
                    {{-- Tabs Navigation & Filters --}}
                    <div class="border-b border-slate-200 dark:border-slate-800 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-colors">
                        <nav class="-mb-px flex space-x-10 overflow-x-auto w-full md:w-auto" aria-label="Tabs">
                            {{-- Active Tab --}}
                            <a href="{{ route('mentor.students.index', ['status' => 'active']) }}" 
                               class="{{ $status === 'active' ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700' }} 
                                      whitespace-nowrap py-5 px-1 border-b-2 font-black text-sm flex items-center transition-all">
                                Active Intern
                                <span class="{{ $status === 'active' ? 'bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-500' }} ml-3 py-0.5 px-3 rounded-full text-[10px] font-black inline-block transition-colors">
                                    {{ $activeCount }}
                                </span>
                            </a>

                            {{-- Finished Tab --}}
                            <a href="{{ route('mentor.students.index', ['status' => 'finished']) }}" 
                               class="{{ $status === 'finished' ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700' }} 
                                      whitespace-nowrap py-5 px-1 border-b-2 font-black text-sm flex items-center transition-all">
                                Intern Selesai
                                <span class="{{ $status === 'finished' ? 'bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-500' }} ml-3 py-0.5 px-3 rounded-full text-[10px] font-black inline-block transition-colors">
                                    {{ $finishedCount }}
                                </span>
                            </a>
                        </nav>

                        {{-- Sub Filter (Only for Active Tab) --}}
                        @if($status === 'active')
                            <div class="inline-flex bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-1" role="group">
                                 <a href="{{ route('mentor.students.index', ['status' => 'active', 'type' => 'all']) }}" 
                                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                    {{ $type === 'all' 
                                       ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                       : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    Semua
                                 </a>
                                 <a href="{{ route('mentor.students.index', ['status' => 'active', 'type' => 'mahasiswa']) }}" 
                                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                    {{ $type === 'mahasiswa' 
                                       ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                       : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    Mahasiswa ({{ $activeMahasiswaCount }})
                                 </a>
                                 <a href="{{ route('mentor.students.index', ['status' => 'active', 'type' => 'smk']) }}" 
                                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                    {{ $type === 'smk' 
                                       ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                       : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    SMK ({{ $activeSmkCount }})
                                 </a>
                            </div>
                        @endif
                    </div>
                <!-- Merged container padding applies naturally here -->
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                            <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Informasi Intern</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Instansi / Pendidikan</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Divisi</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Periode Magang</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Navigasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                @forelse($internships as $index => $data)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white font-bold text-base shadow-sm group-hover:scale-110 transition-transform">
                                                {{ substr($data->student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-700 dark:text-slate-300 transition-colors">{{ $data->student->name }}</div>
                                                <div class="text-xs text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5 transition-colors">{{ $data->student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-700 dark:text-slate-300 font-bold transition-colors">
                                            {{ $data->student->studentProfile->university ?? 'Belum Lengkap' }}
                                        </div>
                                        <div class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5 transition-colors">
                                            {{ $data->student->studentProfile->major ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition-colors">
                                            {{ $data->division->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col items-center justify-center gap-1">
                                            <div class="px-3 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg border border-slate-100 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors">
                                                {{ \Carbon\Carbon::parse($data->start_date)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="w-px h-2 bg-slate-200 dark:bg-slate-700"></div>
                                            <div class="px-3 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg border border-slate-100 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors">
                                                {{ \Carbon\Carbon::parse($data->end_date)->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusConfig = [
                                                'active' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'text' => 'text-emerald-700 dark:text-emerald-400', 'border' => 'border-emerald-100 dark:border-emerald-500/20', 'label' => 'AKTIF'],
                                                'onboarding' => ['bg' => 'bg-amber-50 dark:bg-amber-500/10', 'text' => 'text-amber-700 dark:text-amber-400', 'border' => 'border-amber-100 dark:border-amber-500/20', 'label' => 'ONBOARDING'],
                                                'finished' => ['bg' => 'bg-slate-100 dark:bg-slate-800', 'text' => 'text-slate-600 dark:text-slate-400', 'border' => 'border-slate-200 dark:border-slate-700', 'label' => 'SELESAI'],
                                                'dropped' => ['bg' => 'bg-rose-50 dark:bg-rose-500/10', 'text' => 'text-rose-700 dark:text-rose-400', 'border' => 'border-rose-100 dark:border-rose-500/20', 'label' => 'DROPPED'],
                                            ];
                                            $config = $statusConfig[$data->status] ?? ['bg' => 'bg-gray-50 dark:bg-slate-800', 'text' => 'text-gray-600 dark:text-slate-400', 'border' => 'border-gray-200 dark:border-slate-700', 'label' => strtoupper($data->status)];
                                        @endphp
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.1em] {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} border transition-colors shadow-sm">
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('mentor.students.show', $data->id) }}" 
                                           class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl text-xs font-bold hover:bg-red-600 dark:hover:bg-red-50 hover:text-white transition-all shadow-sm active:scale-95">
                                            Detail
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                            </svg>
                                        </a> 
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                        <div class="flex flex-col items-center justify-center h-full gap-2">
                                            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada intern untuk status ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>