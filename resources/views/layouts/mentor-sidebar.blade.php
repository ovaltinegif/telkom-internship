<nav x-data="{ open: false }" class="bg-white dark:bg-slate-900 w-64 border-r border-gray-100 dark:border-slate-800 hidden lg:flex flex-col z-20 h-screen sticky top-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transition-colors duration-300">
    {{-- Logo Area --}}
    <div class="h-20 flex items-center px-6 border-b border-gray-100 dark:border-slate-800 transition-colors duration-300">
        <a href="{{ route('mentor.dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-red-500/30">
                T
            </div>
            <span class="font-extrabold text-xl tracking-tight text-slate-900 dark:text-white transition-colors duration-300">Internship</span>
        </a>
    </div>

    {{-- Main Menu --}}
    @php
        $pendingCount = \App\Models\DailyLogbook::whereHas('internship', function($q) {
            $q->where('mentor_id', auth()->id());
        })->where('status', 'pending')->count();
    @endphp

    <div class="px-6 py-4 flex-1 overflow-y-auto">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Mentees Panel</p>
        <nav class="space-y-1">
            <a href="{{ route('mentor.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition-all {{ request()->routeIs('mentor.dashboard') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('mentor.dashboard') ? 'opacity-80' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            
            <a href="{{ route('mentor.students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition-all {{ request()->routeIs('mentor.students*') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('mentor.students*') ? 'opacity-80' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                My Interns
            </a>

            <a href="{{ route('mentor.approvals.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg font-semibold transition-all {{ request()->routeIs('mentor.approvals*') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 group' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('mentor.approvals*') ? 'opacity-80' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Approvals
                </div>
                @if($pendingCount > 0)
                    <span class="bg-amber-500/20 text-amber-500 dark:text-amber-400 text-[10px] font-black px-2 py-0.5 rounded-md">{{ $pendingCount }}</span>
                @endif
            </a>
        </nav>
    </div>

    {{-- Bottom Section (Logout etc) --}}
    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-800">
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full text-left text-red-600 hover:bg-red-50 dark:hover:bg-slate-800 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</nav>
