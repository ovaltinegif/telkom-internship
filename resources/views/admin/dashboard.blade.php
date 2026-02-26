<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen font-sans transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4 border-b border-gray-200 dark:border-slate-800 pb-6 transition-colors duration-300">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-slate-200 tracking-tight">Dashboard</h1>
                    <p class="text-gray-500 dark:text-slate-400 mt-1">Welcome back, <span class="font-bold text-red-600 dark:text-red-400">{{ Auth::user()->name }}</span>. Here's your daily overview.</p>
                </div>
                
                
            </div>

            {{-- Stats Grid (Refined & Clean) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card 1: Total Intern --}}
                <div class="bg-gradient-to-br from-[#ce0024] to-[#a0001c] rounded-2xl p-6 text-white shadow-lg dark:shadow-red-900/20 relative overflow-hidden group hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 border-b-4 border-red-800/50">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all duration-500"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1 opacity-80">Total Intern</p>
                            <h3 class="text-5xl font-black tracking-tight">{{ $totalStudents }}</h3>
                        </div>
                        <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex items-center gap-2 relative z-10">
                        @if($studentGrowth > 0)
                            <div class="flex items-center gap-1 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full font-bold text-xs border border-white/30">
                                <span>+{{ $studentGrowth }}</span>
                            </div>
                            <span class="text-xs font-medium text-red-50 opacity-80">Orang Baru</span>
                        @else
                             <span class="text-xs font-medium text-red-100 opacity-60 italic tracking-wide">Data Stabil</span>
                        @endif
                    </div>

                    <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="absolute inset-0 z-10"></a>
                </div>

                {{-- Card 2: Magang Aktif --}}
                <div class="bg-gradient-to-br from-[#ce0024] to-[#a0001c] rounded-2xl p-6 text-white shadow-lg dark:shadow-red-900/20 relative overflow-hidden group hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 border-b-4 border-red-800/50">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all duration-500"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1 opacity-80">Active Intern</p>
                            <h3 class="text-5xl font-black tracking-tight">{{ $activeInternships }}</h3>
                        </div>
                        <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-2 relative z-10">
                        @if($internshipGrowth > 0)
                            <div class="flex items-center gap-1 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full font-bold text-xs border border-white/30">
                                <span>+{{ $internshipGrowth }}</span>
                            </div>
                            <span class="text-xs font-medium text-red-50 opacity-80">Posisi Terisi</span>
                        @else
                            <span class="text-xs font-medium text-red-100 opacity-60 italic tracking-wide">Tidak Ada Penambahan</span>
                        @endif
                    </div>
                     <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" class="absolute inset-0 z-10"></a>
                </div>

                {{-- Card 3: Mentor --}}
                <div class="bg-gradient-to-br from-[#ce0024] to-[#a0001c] rounded-2xl p-6 text-white shadow-lg dark:shadow-red-900/20 relative overflow-hidden group hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 border-b-4 border-red-800/50">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all duration-500"></div>
                    <div class="flex justify-between items-start relative z-10">
                         <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1 opacity-80">Total Mentor</p>
                            <h3 class="text-5xl font-black tracking-tight">{{ $totalMentors }}</h3>
                        </div>
                        <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-2 relative z-10">
                         @if($mentorGrowth > 0)
                            <div class="flex items-center gap-1 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full font-bold text-xs border border-white/30">
                                <span>+{{ $mentorGrowth }}</span>
                            </div>
                            <span class="text-xs font-medium text-red-50 opacity-80">Mentor Baru</span>
                        @else
                            <span class="text-xs font-medium text-red-100 opacity-60 italic tracking-wide">Tim Mentor Stabil</span>
                        @endif
                    </div>
                    <a href="{{ route('admin.mentors.create') }}" class="absolute inset-0 z-10"></a>
                </div>
            </div>


            {{-- Action Items Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Pending Applicants -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm dark:shadow-slate-950 border border-gray-100 dark:border-slate-800 transition-colors duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200">Pending Applicants</h3>
                        </div>
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 text-xs font-bold rounded-full">{{ $pendingApplicants }} Waiting</span>
                    </div>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mb-4">Intern baru menunggu review and persetujuan.</p>
                    
                    @if($pendingApplicants > 0)
                        <a href="{{ route('admin.internships.index', ['status' => 'pending']) }}" class="block w-full text-center py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition dark:shadow-lg dark:shadow-red-900/20">
                            Review Applications
                        </a>
                    @else
                        <button onclick="showInfoModal('Info', 'Tidak ada aplikasi pending saat ini.')" class="block w-full text-center py-2.5 bg-gray-300 dark:bg-slate-800 text-gray-500 dark:text-slate-600 font-semibold rounded-lg cursor-not-allowed">
                            Review Applications
                        </button>
                    @endif
                </div>

                <!-- Pending Extensions -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm dark:shadow-slate-950 border border-gray-100 dark:border-slate-800 transition-colors duration-300">
                     <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200">Extension Requests</h3>
                        </div>
                        <span class="px-3 py-1 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-full">{{ $pendingExtensions->count() }} Requests</span>
                    </div>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mb-4">Pengajuan perpanjangan durasi intern.</p>
                    
                    @if($pendingExtensions->count() > 0)
                        <a href="{{ route('admin.internships.index', ['status' => 'extension']) }}" class="block w-full text-center py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg transition dark:shadow-lg dark:shadow-amber-900/20">
                            Review Extensions
                        </a>
                    @else
                        <button onclick="showInfoModal('Info', 'Tidak ada pengajuan perpanjangan saat ini.')" class="block w-full text-center py-2.5 bg-gray-300 dark:bg-slate-800 text-gray-500 dark:text-slate-600 font-semibold rounded-lg cursor-not-allowed">
                            Review Extensions
                        </button>
                    @endif
                </div>
            </div>

            {{-- Recent Activity Table --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden mb-8 transition-colors duration-300">
                <div class="p-6 border-b border-gray-100 dark:border-slate-800 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200">Recent Internship Activity</h3>
                    <a href="{{ route('admin.internships.index') }}" class="text-sm text-red-600 dark:text-red-400 font-semibold hover:text-red-800">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                        <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Student</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Division</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                            @forelse($recentInternships as $internship)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900 dark:text-slate-100 transition-colors">{{ $internship->student->name }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 transition-colors">{{ $internship->student->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                    {{ $internship->division->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border shadow-sm transition-colors cursor-default
                                        {{ $internship->status == 'active' ? 'bg-green-100 dark:bg-emerald-500/10 text-green-700 dark:text-emerald-400 border-green-200 dark:border-emerald-800/50' : 
                                          ($internship->status == 'pending' ? 'bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50' : 
                                          ($internship->status == 'finished' ? 'bg-blue-100 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-800/50' : 'bg-gray-100 dark:bg-slate-800/50 text-gray-700 dark:text-slate-400 border-gray-200 dark:border-slate-700/50')) }}">
                                        {{ ucfirst($internship->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">
                                    {{ $internship->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
                                    <div class="flex flex-col items-center justify-center h-full gap-2">
                                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">No recent activity found.</p>
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
    
    @include('admin.internships.partials.extension-modal')

    @push('scripts')
    <script>
        function showInfoModal(title, text) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'info',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        }
    </script>
    @endpush
</x-app-layout>