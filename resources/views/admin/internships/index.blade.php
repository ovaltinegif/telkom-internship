<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Monitoring Intern</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Monitor and manage all internship applications and active interns.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] dark:bg-slate-950 min-h-screen transition-colors duration-300" x-data="{
        init() {
            if (!document.getElementById('alpine-search-script')) {
                const script = document.createElement('script');
                script.id = 'alpine-search-script';
                script.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
                script.defer = true;
                document.head.appendChild(script);
            }
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Main Container -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                <div class="p-8">
                    
                    <!-- Controls Row: Tabs & Actions -->
                    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 border-b border-slate-100 dark:border-slate-800 pb-6 mb-6">
                        
                        <!-- Premium Tabs -->
                        <nav class="flex space-x-2 overflow-x-auto w-full xl:w-auto pb-2 xl:pb-0" aria-label="Tabs" style="-ms-overflow-style: none; scrollbar-width: none;">
                            {{-- Pending --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'pending']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'pending' ? 'bg-telkom-50 dark:bg-telkom-500/10 text-telkom-700 dark:text-telkom-400 border border-telkom-100 dark:border-telkom-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Pending
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm
                                    {{ $status === 'pending' ? 'bg-white dark:bg-telkom-500/20 text-telkom-600 dark:text-telkom-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $pendingCount }}
                                </span>
                            </a>

                            {{-- Onboarding --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'onboarding']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'onboarding' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Onboarding
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm
                                    {{ $status === 'onboarding' ? 'bg-white dark:bg-amber-500/20 text-amber-600 dark:text-amber-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $onboardingCount }}
                                </span>
                            </a>

                            {{-- Active --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Active
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm
                                    {{ $status === 'active' ? 'bg-white dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $activeCount }}
                                </span>
                            </a>

                            {{-- Finished --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'finished']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'finished' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Finished
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm
                                    {{ $status === 'finished' ? 'bg-white dark:bg-blue-500/20 text-blue-600 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $finishedCount }}
                                </span>
                            </a>

                            {{-- Extended --}}
                            @if($extensionCount > 0)
                            <a href="{{ route('admin.internships.index', ['status' => 'extension']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'extension' ? 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Extended
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm animate-pulse
                                    {{ $status === 'extension' ? 'bg-white dark:bg-amber-500/30 text-amber-600 dark:text-amber-300' : 'bg-amber-100/50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400' }}">
                                    {{ $extensionCount }}
                                </span>
                            </a>
                            @endif
                        </nav>

                        <!-- Filters -->
                        <div class="flex items-center gap-3 w-full xl:w-auto">
                            <div class="inline-flex bg-slate-50 dark:bg-slate-950 rounded-xl shadow-inner border border-slate-200 dark:border-slate-800 p-1" role="group">
                                <a href="{{ route('admin.internships.index', ['status' => $status, 'student_type' => 'mahasiswa']) }}" 
                                   class="px-5 py-1.5 text-xs font-bold rounded-lg transition-all 
                                   {{ (!$studentType || $studentType == 'mahasiswa') 
                                      ? 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-700' 
                                      : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300' }}">
                                    Mahasiswa
                                </a>
                                <a href="{{ route('admin.internships.index', ['status' => $status, 'student_type' => 'smk']) }}" 
                                   class="px-5 py-1.5 text-xs font-bold rounded-lg transition-all 
                                   {{ $studentType == 'smk' 
                                      ? 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-700' 
                                      : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300' }}">
                                    SMK
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                            <thead class="bg-slate-50/50 dark:bg-slate-950/50 transition-colors">
                                <tr>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest rounded-tl-xl rounded-bl-xl transition-colors">Intern</th>
                                    <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest transition-colors">Pendidikan</th>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest transition-colors">Divisi</th>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest hidden sm:table-cell transition-colors">Mentor</th>
                                    <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest transition-colors">
                                        @if($status === 'active')
                                            Sisa Durasi
                                        @elseif($status === 'extension')
                                            Detail Perpanjangan
                                        @else
                                            Durasi
                                        @endif
                                    </th>
                                    @if(!in_array($status, ['active', 'finished']))
                                    <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest rounded-tr-xl rounded-br-xl transition-colors">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                @forelse ($internships as $internship)
                                    @php
                                        $isClickableRow = in_array($status, ['active', 'finished']);
                                        $rowUrl = route('admin.internships.show', $internship->id);
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors {{ $isClickableRow ? 'cursor-pointer' : '' }}" 
                                        {!! $isClickableRow ? 'onclick="window.location=\'' . $rowUrl . '\'"' : '' !!}>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center">
                                                <div class="flex items-center gap-4 text-left w-full max-w-[220px]">
                                                    <div class="relative flex-shrink-0">
                                                        <div class="h-11 w-11 rounded-full bg-gradient-to-tr from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-lg shadow-sm border-2 border-white dark:border-slate-800 transition-transform hover:scale-105">
                                                            {{ substr($internship->student->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="truncate w-full">
                                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200 transition-colors group-hover:text-emerald-600 dark:group-hover:text-emerald-400 truncate" title="{{ $internship->student->name }}">{{ $internship->student->name }}</div>
                                                        <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 tracking-wider mt-0.5 truncate" title="{{ $internship->student->email }}">{{ $internship->student->email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $eduLevel = $internship->student->studentProfile?->education_level ?? '-';
                                                $classes = $eduLevel === 'SMK' 
                                                    ? 'bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-100 dark:border-purple-500/20' 
                                                    : 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-[10px] uppercase tracking-widest font-black rounded-lg shadow-sm {{ $classes }} transition-all">
                                                {{ $eduLevel }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="max-w-[150px] mx-auto truncate text-sm font-medium text-slate-700 dark:text-slate-300 transition-colors" title="{{ $internship->division?->name ?? '-' }}">{{ $internship->division?->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="max-w-[150px] mx-auto truncate text-sm font-medium text-slate-700 dark:text-slate-300 transition-colors" title="{{ $internship->mentor?->name ?? '-' }}">{{ $internship->mentor?->name ?? '-' }}</div>
                                        </td>

                                        {{-- Unified Date Info Cell --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($status === 'active')
                                                @php
                                                    $endDate = \Carbon\Carbon::parse($internship->end_date)->endOfDay();
                                                    $now = \Carbon\Carbon::now()->startOfDay();
                                                    $diff = $now->diff($endDate);
                                                    $isExpired = $now->gt($endDate);
                                                    $remainingDays = $now->diffInDays($endDate, false);
                                                @endphp

                                                <div class="flex items-center justify-center">
                                                    <div class="w-[150px] flex items-center gap-3 text-left">
                                                        <div class="flex-shrink-0">
                                                            <div class="p-2 rounded-xl {{ $remainingDays > 10 ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400' : ($remainingDays > 0 ? 'bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-500') }} transition-colors">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            @if(!$isExpired)
                                                                <div class="text-sm font-bold {{ $remainingDays > 10 ? 'text-slate-800 dark:text-slate-200' : 'text-orange-600 dark:text-orange-400' }} transition-colors">
                                                                    @if($diff->y > 0) {{ $diff->y }} Th @endif
                                                                    @if($diff->m > 0) {{ $diff->m }} Bln @endif
                                                                    @if($diff->d > 0) {{ $diff->d }} Hr @endif
                                                                </div>
                                                                <div class="text-xs text-slate-500 dark:text-slate-500 font-bold transition-colors">
                                                                    Selesai {{ $endDate->format('d M Y') }}
                                                                </div>
                                                            @elseif($remainingDays == 0)
                                                                <div class="text-sm font-bold text-orange-600 dark:text-orange-400 transition-colors">
                                                                    Hari Terakhir
                                                                </div>
                                                                <div class="text-xs text-slate-500 dark:text-slate-500 font-bold transition-colors">
                                                                    Selesai Hari Ini
                                                                </div>
                                                            @else
                                                                <div class="text-sm font-bold text-slate-500 dark:text-slate-600 transition-colors">
                                                                    Selesai
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($status === 'extension')
                                                @php
                                                    $extension = $internship->extensions->first();
                                                @endphp
                                                <div class="flex items-center justify-center">
                                                    <div class="w-[150px] flex flex-col items-center justify-center text-center">
                                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider transition-colors">Current: <span class="text-slate-700 dark:text-slate-300 transition-colors">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</span></div>
                                                        <div class="text-sm font-bold text-emerald-600 dark:text-emerald-400 transition-colors">New: {{ \Carbon\Carbon::parse($extension->new_end_date)->format('d M Y') }}</div>
                                                        <div class="text-[10px] font-bold text-slate-400 dark:text-slate-600 transition-colors">
                                                            (+{{ \Carbon\Carbon::parse($extension->new_start_date)->diffInDays(\Carbon\Carbon::parse($extension->new_end_date)->addDay()) }} Days)
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex items-center justify-center">
                                                    <div class="w-[150px] flex flex-col items-center justify-center text-center">
                                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200 transition-colors">
                                                            {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                                                        </div>
                                                        <div class="text-xs font-bold text-slate-500 dark:text-slate-500 transition-colors">
                                                            s/d {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>

                                        @if(!in_array($status, ['active', 'finished']))
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium" {!! $isClickableRow ? 'onclick="event.stopPropagation()"' : '' !!}>
                                            <div class="flex items-center justify-center gap-2">
                                                @if($status === 'pending')
                                                    <button @click="$dispatch('open-review-modal', { 
                                                        id: {{ $internship->id }}, 
                                                        name: '{{ $internship->student->name }}', 
                                                        docs: {{ json_encode($internship->documents) }},
                                                        photo: '{{ $internship->student->studentProfile && $internship->student->studentProfile->photo ? $internship->student->studentProfile->photo : null }}'
                                                    })" 
                                                        class="inline-flex items-center px-4 py-2 text-[11px] uppercase tracking-wider font-extrabold rounded-xl text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 border border-indigo-200 dark:border-indigo-500/20 shadow-sm transition-all shadow-indigo-500/10 active:scale-95">
                                                        Review Pengajuan
                                                    </button>
                                                @elseif($status === 'extension')
                                                    @php
                                                        $extension = $internship->extensions->first();
                                                    @endphp
                                                    <a href="{{ Storage::url($extension->file_path) }}" target="_blank" class="inline-flex items-center justify-center p-2.5 rounded-xl text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 bg-indigo-50 dark:bg-indigo-500/10 transition-all shadow-sm" title="Lihat Surat">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </a>
                                                    <form id="approve-extension-form-{{ $extension->id }}" action="{{ route('admin.internships.approveExtension', $extension->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" onclick="confirmApproveExtension('{{ $extension->id }}')" class="inline-flex items-center p-2.5 rounded-xl text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 bg-emerald-50 dark:bg-emerald-500/10 transition-all shadow-sm" title="Setujui">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form id="reject-extension-form-{{ $extension->id }}" action="{{ route('admin.internships.rejectExtension', $extension->id) }}" method="POST" class="flex items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" onclick="confirmRejectExtension('{{ $extension->id }}')" class="inline-flex items-center p-2.5 rounded-xl text-red-600 dark:text-red-400 hover:text-red-900 bg-red-50 dark:bg-red-500/10 transition-all shadow-sm" title="Tolak">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @elseif($status === 'onboarding')
                                                    <div class="flex items-center gap-2">
                                                        @php
                                                            $signedPact = $internship->documents->where('type', 'pakta_integritas_signed')->first();
                                                        @endphp
                                                        
                                                        @if($signedPact)
                                                            <a href="{{ Storage::url($signedPact->file_path) }}" target="_blank" 
                                                               class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all shadow-sm" title="Lihat Pakta">
                                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                            </a>
                                                            <button @click="$dispatch('open-activation-modal', { id: {{ $internship->id }}, name: '{{ $internship->student->name }}' })" 
                                                                class="inline-flex items-center px-4 py-2 text-[11px] uppercase tracking-wider font-extrabold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 shadow-[0_4px_14px_0_rgba(5,150,105,0.39)] hover:shadow-[0_6px_20px_rgba(5,150,105,0.23)] transition-all active:scale-95">
                                                                Activate
                                                            </button>
                                                        @else
                                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-[11px] uppercase tracking-wider font-extrabold bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 border border-slate-200 dark:border-slate-800 transition-colors">
                                                                Wait for Upload
                                                            </span>
                                                        @endif
                                                    </div>
                                                @elseif($status === 'finished')
                                                    @php
                                                        $isSmk = optional($internship->student->studentProfile)->education_level === 'SMK';
                                                        $hasCertificate = $internship->documents->where('type', 'sertifikat_kelulusan')->count() > 0;
                                                    @endphp
                                                    
                                                    <button @click="$dispatch('open-completion-modal', { id: {{ $internship->id }}, name: '{{ $internship->student->name }}', isSmk: {{ $isSmk ? 'true' : 'false' }} })" 
                                                        class="inline-flex items-center px-4 py-2 text-[11px] uppercase tracking-wider font-extrabold rounded-xl border {{ $hasCertificate ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 border-indigo-200 dark:border-indigo-500/20' : 'text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 border-blue-200 dark:border-blue-500/20' }} hover:opacity-80 transition-all shadow-sm">
                                                        {{ $hasCertificate ? 'Update Docs' : 'Send Certificate' }}
                                                    </button>
                                                @else
                                                    <a href="{{ route('admin.internships.show', $internship->id) }}" 
                                                       class="inline-flex items-center px-4 py-2 text-[11px] uppercase tracking-wider font-extrabold rounded-xl text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 border border-emerald-200 dark:border-emerald-500/20 shadow-sm transition-all shadow-emerald-500/10 active:scale-95">
                                                        Detail Magang
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                            <div class="flex flex-col items-center justify-center h-full gap-2">
                                                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                                <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">No data found for this status.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-8">
                        {{ $internships->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        
        @include('admin.internships.partials.review-modal')
        @include('admin.internships.partials.completion-modal')
        @include('admin.internships.partials.activation-modal')
        @include('admin.internships.partials.extension-modal')

    </div>
    @push('scripts')
    <script>
        function confirmApproveExtension(id) {
            Swal.fire({
                title: 'Setujui Perpanjangan?',
                text: "Durasi magang akan diperbarui sesuai tanggal yang diajukan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-extension-form-' + id).submit();
                }
            })
        }

        function confirmRejectExtension(id) {
            Swal.fire({
                title: 'Tolak Perpanjangan?',
                text: "Pengajuan perpanjangan akan ditolak dan status kembali menjadi aktif.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reject-extension-form-' + id).submit();
                }
            })
        }

        function submitExtensionModalApprove() {
            const dateInput = document.getElementById('new_end_date');
            if (!dateInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Mohon isi tanggal selesai baru.',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all active:scale-95',
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: "Apakah Anda yakin ingin menyetujui perpanjangan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('extension-modal-approve-form').submit();
                }
            })
        }

        function submitExtensionModalReject() {
            Swal.fire({
                title: 'Konfirmasi Penolakan',
                text: "Apakah Anda yakin ingin menolak perpanjangan ini? Dokumen akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('extension-modal-reject-form').submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        @endif
    </script>
    @endpush
</x-app-layout>
