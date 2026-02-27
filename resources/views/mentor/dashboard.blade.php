<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Hello, ') }} <span class="text-red-600 dark:text-red-400">{{ Auth::user()->name }}!</span> 👋
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Selamat datang di Dashboard Mentor Telkom Internship</p>
        </div>
    </x-slot>

    <div class="py-8 bg-white dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card 1: Total Students -->
                <div class="bg-gradient-to-br from-[#ce0024] to-[#a0001c] rounded-2xl p-6 text-white shadow-lg dark:shadow-red-900/20 relative overflow-hidden group hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 border-b-4 border-red-800/50">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all duration-500"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1 opacity-80">Intern Bimbingan</p>
                            <h3 class="text-5xl font-black tracking-tight">{{ $internships->where('status', 'active')->count() }}</h3>
                        </div>
                        <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-2 relative z-10">
                        @if($internships->where('status', 'active')->count() > 0)
                            <div class="flex items-center gap-1 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full font-bold text-xs border border-white/30">
                                <span>Aktif</span>
                            </div>
                            <span class="text-xs font-medium text-red-50 opacity-80">Lihat profil dan aktivitas</span>
                        @else
                            <span class="text-sm font-medium text-red-100 opacity-60 normal tracking-wide">Belum ada intern aktif</span>
                        @endif
                    </div>
                    <a href="{{ route('mentor.students.index', ['status' => 'active']) }}" class="absolute inset-0 z-10 w-full h-full cursor-pointer" aria-label="Daftar Intern"></a>
                </div>

                <!-- Card 2: Pending Validations -->
                <div class="bg-gradient-to-br from-[#ce0024] to-[#a0001c] rounded-2xl p-6 text-white shadow-lg dark:shadow-red-900/20 relative overflow-hidden group hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 border-b-4 border-red-800/50">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all duration-500"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1 opacity-80">Menunggu Validasi</p>
                            <h3 class="text-5xl font-black tracking-tight">{{ $pendingLogbooks ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 opacity-90 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-2 relative z-10">
                        @if(($pendingLogbooks ?? 0) > 0)
                            <div class="flex items-center gap-1 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full font-bold text-xs border border-white/30">
                                <span>Tindakan Diperlukan</span>
                            </div>
                            <span class="text-xs font-medium text-red-50 opacity-80">Klik untuk validasi</span>
                        @else
                            <span class="text-sm font-medium text-red-100 opacity-60 normal tracking-wide">Semua laporan sudah divalidasi</span>
                        @endif
                    </div>
                    <a href="{{ route('mentor.approvals.index') }}" class="absolute inset-0 z-10"></a>
                </div>

            </div>

            {{-- Main List: Mahasiswa --}}
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-3xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-10">
                        <div>
                            <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 transition-colors tracking-tight">Daftar Intern Aktif</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium transition-colors">Kelola dan pantau progres intern bimbingan Anda</p>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                            <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Intern</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Divisi</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Status Program</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                @forelse($internships as $internship)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-2xl bg-gradient-to-tr from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-black text-lg shadow-sm border border-white dark:border-slate-700 transition-all group-hover:scale-110 group-hover:rotate-3 group-hover:shadow-lg dark:group-hover:shadow-slate-900/40">
                                                {{ substr($internship->student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-700 dark:text-slate-300 transition-colors">{{ $internship->student->name }}</div>
                                                <div class="text-xs text-slate-500 dark:text-slate-500 font-bold transition-colors mt-0.5">{{ $internship->student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 uppercase tracking-widest transition-colors shadow-sm">
                                            {{ $internship->division->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($internship->status == 'active')
                                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-[10px] font-black bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 uppercase tracking-widest transition-colors shadow-sm ring-1 ring-emerald-500/20">
                                                <span class="flex h-2 w-2 relative">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                                                </span>
                                                Aktif
                                            </span>
                                        @elseif($internship->status == 'finished')
                                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-[10px] font-black bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-500 border border-slate-200 dark:border-slate-700 uppercase tracking-widest transition-colors shadow-sm">
                                                 Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-[10px] font-black bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20 uppercase tracking-widest transition-colors shadow-sm">
                                                {{ $internship->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('mentor.students.show', $internship->id) }}" 
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold hover:bg-red-600 dark:hover:bg-red-600 hover:text-white dark:hover:text-white hover:border-red-600 dark:hover:border-red-600 transition-all shadow-sm group-hover:shadow-md active:scale-95" title="Lihat Profil Mahasiswa">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                        <div class="flex flex-col items-center justify-center h-full gap-2">
                                            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada intern yang ditugaskan kepada Anda.</p>
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

        </div>
    </div>
</x-app-layout>