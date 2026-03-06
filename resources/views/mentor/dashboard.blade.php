<x-app-layout>
    {{-- No header slot needed since we have a dedicated topbar --}}
    
    <div class="max-w-7xl mx-auto space-y-10 w-full">
        
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Here's the summary of your mentees for today, {{ now()->translatedFormat('l, M d') }}.</p>
            </div>
            
            @if(($pendingLogbooks ?? 0) > 0)
            <div class="flex gap-3">
                <a href="{{ route('mentor.approvals.index') }}" class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-semibold text-sm shadow-lg shadow-red-500/30 hover:shadow-red-500/50 active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Validate {{ $pendingLogbooks }} Logbooks
                </a>
            </div>
            @endif
        </div>

        <!-- Premium Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Stat 1: Total Interns -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.3)] dark:shadow-none relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border border-slate-700/50">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-500/20 rounded-full blur-3xl group-hover:bg-emerald-500/30 group-hover:scale-110 transition-all duration-500"></div>
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.8)]"></span>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Active Mentees</p>
                        </div>
                        <h3 class="text-6xl font-black text-white tracking-tighter">{{ $internships->where('status', 'active')->count() }}</h3>
                    </div>
                    <div class="p-4 bg-white/5 backdrop-blur-md rounded-2xl text-white border border-white/10 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-8 relative z-10">
                    <div class="flex items-center gap-3 text-sm">
                        @if($internships->where('status', 'active')->count() > 0)
                            <span class="flex items-center text-white font-bold bg-white/10 backdrop-blur-md px-3 py-1 rounded-lg border border-white/10">
                                Across {{ $internships->where('status', 'active')->pluck('division_id')->unique()->count() }} Divisions
                            </span>
                            <a href="{{ route('mentor.students.index', ['status' => 'active']) }}" class="text-slate-400 font-medium hover:text-white transition-colors cursor-pointer flex items-center gap-1 group/link text-xs">
                                View details <svg class="w-3.5 h-3.5 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <span class="text-slate-400 font-medium">No active interns yet.</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stat 2: Pending Validations -->
            <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-8 shadow-[0_10px_40px_-10px_rgba(220,38,38,0.4)] dark:shadow-none relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border border-red-500/30">
                <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-orange-500/30 rounded-full blur-3xl group-hover:bg-orange-500/40 group-hover:scale-110 transition-all duration-500"></div>
                <div class="absolute right-10 top-10 w-32 h-32 bg-rose-500/20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full {{ ($pendingLogbooks ?? 0) > 0 ? 'bg-orange-400 shadow-[0_0_10px_rgba(251,146,60,0.8)]' : 'bg-red-400/50' }}"></span>
                            <p class="text-[11px] font-black text-red-200 uppercase tracking-widest">Requires Validation</p>
                        </div>
                        <h3 class="text-6xl font-black text-white tracking-tighter">{{ $pendingLogbooks ?? 0 }}</h3>
                    </div>
                    <div class="p-4 bg-black/10 backdrop-blur-md rounded-2xl text-white border border-white/20 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-8 relative z-10">
                    <div class="flex items-center flex-wrap gap-2 text-sm">
                        @if(($pendingLogbooks ?? 0) > 0)
                            <span class="flex items-center text-white font-bold bg-black/20 backdrop-blur-md px-3 py-1 rounded-lg border border-white/10 text-xs shadow-inner">
                                {{ $pendingLogbooks ?? 0 }} Logbooks
                            </span>
                            <a href="{{ route('mentor.approvals.index') }}" class="text-red-200 mt-2 sm:mt-0 sm:ml-2 font-medium hover:text-white transition-colors cursor-pointer flex items-center gap-1 group/link text-xs">
                                Validate now <svg class="w-3.5 h-3.5 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <span class="text-red-200 font-medium text-sm normal tracking-wide">All logbooks are validated!</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Mentees List Section -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-transparent relative z-10">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-white tracking-tight">Active Mentees</h3>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">Manage and monitor the progress of your assigned interns</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative hidden sm:block">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Search interns..." class="pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all dark:text-white w-full sm:w-64">
                    </div>
                    <a href="{{ route('mentor.students.index') }}" class="p-2 border border-slate-200 dark:border-slate-800 rounded-lg text-slate-500 hover:text-red-600 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" title="View all Interns">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                    <thead class="bg-slate-50/50 dark:bg-slate-950/50">
                        <tr>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Intern</th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Division</th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Program Status</th>
                            <th scope="col" class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden sm:table-cell">Progress</th>
                            <th scope="col" class="px-8 py-5 text-center text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80 dark:divide-slate-800/80">
                        @forelse($internships as $internship)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors group">
                            <td class="px-8 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="h-11 w-11 relative">
                                        @if($internship->student->studentProfile && $internship->student->studentProfile->photo)
                                            <img class="h-11 w-11 rounded-full object-cover shadow-sm border-2 border-white dark:border-slate-800" src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" alt="Student">
                                        @else
                                            <div class="h-11 w-11 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold border-2 border-white dark:border-slate-800 shadow-sm">
                                                {{ substr(optional($internship->student)->name ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                        
                                        @if($internship->status == 'active')
                                            <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800"></span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-red-600 transition-colors">{{ optional($internship->student)->name ?? 'Unknown' }}</div>
                                        <div class="text-[11px] font-bold text-slate-500 mt-0.5">{{ optional(optional($internship->student)->studentProfile)->university ?? 'Universitas' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ optional($internship->division)->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ optional($internship->position)->name ?? '-' }}</div>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap">
                                @if($internship->status == 'active')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50 uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active Intern
                                    </span>
                                @elseif($internship->status == 'finished')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 uppercase tracking-widest">
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50 uppercase tracking-widest">
                                        {{ $internship->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap hidden sm:table-cell">
                                <div class="w-48">
                                    <div class="flex justify-between items-end mb-1">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Logbooks Approved</span>
                                        @php
                                            $startDate = $internship->start_date ? \Carbon\Carbon::parse($internship->start_date) : null;
                                            $endDate = $internship->end_date ? \Carbon\Carbon::parse($internship->end_date) : now();
                                            $totalDates = $startDate ? $startDate->diffInWeekdays($endDate) : 0;
                                            $approvedLogbooks = $internship->dailyLogbooks()->where('status', 'approved')->count();
                                            $percentage = $totalDates > 0 ? min(100, round(($approvedLogbooks / $totalDates) * 100)) : 0;
                                        @endphp
                                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $approvedLogbooks }}/{{ $totalDates }}</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-red-500 h-1.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('mentor.students.show', $internship->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 dark:hover:bg-red-500/10 dark:hover:border-red-500/30 transition-all cursor-pointer shadow-sm group-hover:shadow hover:scale-105 active:scale-95" title="View Intern Details">
                                    <svg class="w-4 h-4 text-slate-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center text-slate-500 dark:text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center shadow-inner">
                                        <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold mt-2">No assigned interns</p>
                                    <p class="text-xs text-slate-400">You do not have any interns assigned to you currently.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>