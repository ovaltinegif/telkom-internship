<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Detail Magang') }}
                </h2>
                <p class="text-slate-500 text-sm">Informasi lengkap terkait mahasiswa dan program magang</p>
            </div>
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transitionease-in-out duration-150">
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
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Photo -->
                <div class="shrink-0">
                    @if($profile && $profile->photo)
                        <img class="h-28 w-28 rounded-full object-cover shadow-md border-4 border-slate-50" src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $internship->student->name }}">
                    @else
                        <div class="h-28 w-28 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white text-4xl font-bold shadow-md border-4 border-slate-50">
                            {{ substr($internship->student->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="grow text-center md:text-left space-y-2">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">{{ $internship->student->name }}</h1>
                        <p class="text-slate-500 font-medium">{{ $internship->student->email }}</p>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
                        <x-status-badge :status="$internship->status" class="px-3 py-1 text-sm" />
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 uppercase tracking-wider">
                            {{ $internship->division->name ?? 'Belum Ada Divisi' }}
                        </span>
                        @if($internship->mentor)
                             <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100 uppercase tracking-wider flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                                Mentor: {{ $internship->mentor->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column (Detail Mahasiswa) -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="font-bold text-slate-800">Informasi Mahasiswa</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Institusi Pendidikan</p>
                                <p class="text-slate-700 font-semibold">{{ $profile->university ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Jurusan</p>
                                <p class="text-slate-700 font-semibold">{{ $profile->major ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase mb-1">{{ optional($profile)->student_type === 'siswa' ? 'NIS/NISN' : 'NIM' }}</p>
                                    <p class="text-slate-700 font-mono">{{ $profile->nim ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase mb-1">Jenjang</p>
                                    <p class="text-slate-700 font-semibold">{{ $profile->education_level ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Kontak (WA/HP)</p>
                                <p class="text-slate-700 font-mono">{{ $profile->phone_number ?? '-' }}</p>
                            </div>
                             <div>
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Alamat Domisili</p>
                                <p class="text-slate-700 text-sm leading-relaxed">{{ $profile->address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Detail Magang & Dokumen) -->
                <div class="lg:col-span-2 space-y-6">
                     <!-- Durasi & Lokasi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800">Detail Pelaksanaan</h3>
                             @if($internship->status === 'active')
                                <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-lg font-bold">Sedang Berlangsung</span>
                            @endif
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-500">Periode Magang</p>
                                </div>
                                <p class="text-lg font-bold text-slate-800 pl-11">
                                    {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }} 
                                    <span class="text-slate-400 mx-1">-</span> 
                                    {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                </p>
                            </div>

                             <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-500">Lokasi Penempatan</p>
                                </div>
                                <p class="text-lg font-bold text-slate-800 pl-11">
                                    {{ $internship->location ?? 'Witel Semarang' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="font-bold text-slate-800">Dokumen Pendukung</h3>
                        </div>
                        <ul class="divide-y divide-slate-100">
                             @if($internship->pact_integrity)
                                <li class="p-4 hover:bg-slate-50 transition-colors flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-100 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">Pakta Integritas</p>
                                            <p class="text-xs text-slate-400">Telah ditandatangani</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($internship->pact_integrity) }}" target="_blank" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-colors shadow-sm">
                                        Lihat File
                                    </a>
                                </li>
                            @endif

                            @forelse($internship->documents as $doc)
                                 <li class="p-4 hover:bg-slate-50 transition-colors flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <div class="p-2 bg-slate-100 text-slate-500 rounded-lg group-hover:bg-slate-200 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" />
                                                <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">{{ $doc->name }}</p>
                                            <p class="text-xs text-slate-400 uppercase tracking-wide">{{ str_replace('_', ' ', $doc->type) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-colors shadow-sm">
                                        Lihat File
                                    </a>
                                </li>
                            @empty
                                @if(!$internship->pact_integrity)
                                    <li class="p-8 text-center text-slate-400 italic">
                                        Belum ada dokumen yang diunggah.
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
