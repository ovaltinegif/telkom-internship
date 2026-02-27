<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 transition-colors leading-tight">
                    {{ __('Detail Magang') }}
                </h2>
                <p class="text-slate-500 dark:text-slate-400 transition-colors text-sm">Informasi lengkap terkait mahasiswa dan program magang</p>
            </div>
            <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" class="inline-flex items-center px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition-all duration-200">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @php
                $profile = \App\Models\StudentProfile::where('user_id', $internship->student_id)->first();
            @endphp

            <!-- 1. Header Card: Identity & Status -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center md:items-start gap-8 transition-colors duration-300">
                <!-- Photo -->
                <div class="shrink-0 relative">
                    @if($profile && $profile->photo)
                        <img class="h-32 w-32 rounded-3xl object-cover shadow-lg border-4 border-white dark:border-slate-800 transition-colors" src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $internship->student->name }}">
                    @else
                        <div class="h-32 w-32 rounded-3xl bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white text-5xl font-bold shadow-lg border-4 border-white dark:border-slate-800 transition-colors">
                            {{ substr($internship->student->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-emerald-500 border-4 border-white dark:border-slate-900 rounded-full flex items-center justify-center shadow-lg" title="Active Account">
                         <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>

                <!-- Info -->
                <div class="grow text-center md:text-left space-y-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 transition-colors tracking-tight">{{ $internship->student->name }}</h1>
                        <p class="text-slate-500 dark:text-slate-400 font-bold flex items-center justify-center md:justify-start gap-1.5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $internship->student->email }}
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <x-status-badge :status="$internship->status" class="px-4 py-1.5 text-xs font-bold" />
                        <span class="px-4 py-1.5 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 text-xs font-bold border border-blue-100 dark:border-blue-500/20 uppercase tracking-widest transition-colors">
                            {{ $internship->division->name ?? 'Belum Ada Divisi' }}
                        </span>
                        @if($internship->mentor)
                             <span class="px-4 py-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 text-xs font-bold border border-indigo-100 dark:border-indigo-500/20 uppercase tracking-widest flex items-center gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                                Mentor: {{ $internship->mentor->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column (Detail Mahasiswa) -->
                <div class="space-y-8">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
                        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30">
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 transition-colors">Informasi Intern</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1.5">Institusi Pendidikan</p>
                                <p class="text-slate-700 dark:text-slate-200 font-bold transition-colors">{{ $profile->university ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1.5">Jurusan</p>
                                <p class="text-slate-700 dark:text-slate-200 font-bold transition-colors">{{ $profile->major ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1.5">{{ optional($profile)->student_type === 'siswa' ? 'NIS/NISN' : 'NIM' }}</p>
                                    <p class="text-slate-700 dark:text-slate-200 font-mono text-sm font-bold transition-colors">{{ $profile->nim ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1.5">Jenjang</p>
                                    <p class="text-slate-700 dark:text-slate-200 font-bold transition-colors">{{ $profile->education_level ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1.5">Kontak (WA/HP)</p>
                                <p class="text-slate-700 dark:text-slate-200 font-mono text-sm font-bold transition-colors">{{ $profile->phone_number ?? '-' }}</p>
                            </div>
                             <div>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1.5">Alamat Domisili</p>
                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-relaxed transition-colors">{{ $profile->address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Detail Magang & Dokumen) -->
                <div class="lg:col-span-2 space-y-8">
                     <!-- Durasi & Lokasi -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
                        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 transition-colors">Detail Pelaksanaan</h3>
                             @if($internship->status === 'active')
                                <span class="bg-emerald-500 text-white text-[10px] px-2.5 py-1 rounded-lg font-black uppercase tracking-wider shadow-lg shadow-emerald-500/20">Active</span>
                            @endif
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Periode Magang</p>
                                </div>
                                <p class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors">
                                    {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }} 
                                    <span class="text-slate-300 dark:text-slate-700 mx-2 text-lg">/</span> 
                                    {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                </p>
                            </div>

                             <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Lokasi Penempatan</p>
                                </div>
                                <p class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors">
                                    {{ $internship->location ?? 'Witel Semarang' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
                        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30">
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 transition-colors">Dokumen Pendukung</h3>
                        </div>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800 transition-colors">
                             @if($internship->pact_integrity)
                                <li class="px-6 py-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors flex items-center justify-between group">
                                    <div class="flex items-center gap-5">
                                        <div class="p-3 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl group-hover:bg-emerald-100 transition-colors shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-700 dark:text-slate-200 transition-colors">Pakta Integritas</p>
                                            <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mt-0.5">Verified & Signed</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($internship->pact_integrity) }}" target="_blank" class="px-5 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-slate-100 transition-all shadow-sm active:scale-95">
                                        Lihat File
                                    </a>
                                </li>
                             @endif

                            @forelse($internship->documents as $doc)
                                 <li class="px-6 py-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors flex items-center justify-between group">
                                    <div class="flex items-center gap-5">
                                        <div class="p-3 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl group-hover:bg-slate-200 transition-colors shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" />
                                                <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-700 dark:text-slate-200 transition-colors">{{ $doc->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5">{{ str_replace('_', ' ', $doc->type) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="px-5 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-slate-100 transition-all shadow-sm active:scale-95">
                                        Lihat File
                                    </a>
                                </li>
                            @empty
                                @if(!$internship->pact_integrity)
                                    <li class="p-12 text-center text-slate-400 dark:text-slate-600 italic">
                                        <svg class="mx-auto h-12 w-12 text-slate-200 dark:text-slate-800 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-sm">Belum ada dokumen yang diunggah.</p>
                                    </li>
                                @endif
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
