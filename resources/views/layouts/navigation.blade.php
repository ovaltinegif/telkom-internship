<nav x-data="{ open: false }" class="sticky top-0 inset-x-0 z-[999] bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border-b border-gray-100 dark:border-slate-800 shadow-[0_4px_20px_rgb(0,0,0,0.03)] dark:shadow-[0_4px_20px_rgb(0,0,0,0.2)] transition-colors duration-300">
    {{-- Full Width Navbar Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between items-center h-20 transition-all duration-300">
            
            {{-- Left: Logo --}}
            <div class="shrink-0 flex items-center gap-4">
                <a href="{{ auth()->user()->role === 'mentor' ? route('mentor.dashboard') : route('dashboard') }}" class="flex items-center gap-3 group">
                   <img src="{{ asset('images/logo-telkom.png') }}" class="h-20 w-auto dark:brightness-110" alt="Telkom Indonesia">
                </a>
            </div>

            {{-- Center: Modern Navigation Links --}}
            <div class="hidden md:flex items-center gap-1 absolute left-1/2 -translate-x-1/2">
                @php
                    $roleFn = fn($r) => auth()->user()->role === $r;
                    $links = [];
                    
                    if ($roleFn('mentor')) {
                        $pendingCount = \App\Models\DailyLogbook::whereHas('internship', function($q) {
                            $q->where('mentor_id', auth()->id());
                        })->where('status', 'pending')->count();

                        $links = [
                            ['name' => 'Dashboard', 'route' => 'mentor.dashboard', 'active' => request()->routeIs('mentor.dashboard')],
                            ['name' => 'Intern', 'route' => 'mentor.students.index', 'active' => request()->routeIs('mentor.students*')],
                            [
                                'name' => 'Approval', 
                                'route' => 'mentor.approvals.index', 
                                'active' => request()->routeIs('mentor.approvals*'),
                                'badge' => $pendingCount > 0 ? $pendingCount : null
                            ],
                        ];
                    } elseif ($roleFn('admin')) {
                         $links = [
                            ['name' => 'Overview', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard')],
                            ['name' => 'Database', 'route' => 'admin.users.index', 'active' => request()->routeIs('admin.users*')],
                            ['name' => 'Monitoring', 'route' => 'admin.internships.index', 'active' => request()->routeIs('admin.internships*')],
                        ];
                    } else {
                        // Student Menu
                        $internship = Auth::user()->internship;
                        $isActive = $internship && $internship->status === 'active';
                        $isFinished = $internship && $internship->status === 'finished';

                        $links = [];

                        // 1. Dashboard (Always visible for Students)
                        $links[] = ['name' => 'My Dashboard', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')];

                        // 2. Activity & Documents (Only if Active or Finished, but Docs hidden if Finished)
                        if ($isActive || $isFinished) {
                            $links[] = ['name' => 'Activity', 'route' => 'logbooks.index', 'active' => request()->routeIs('logbooks.index')];
                            
                            if (!$isFinished) {
                                $links[] = ['name' => 'Documents', 'route' => 'documents.index', 'active' => request()->routeIs('documents*')];
                            }
                        }
                    }
                @endphp

                @foreach($links as $link)
                    <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}" 
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 flex items-center gap-2 {{ $link['active'] ? 'text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/10 shadow-sm border border-red-100 dark:border-red-500/20' : 'text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-500 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $link['name'] }}
                        @if(isset($link['badge']) && $link['badge'])
                            <span class="bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center shadow-sm shadow-red-500/30">
                                {{ $link['badge'] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Right: User Profile & Actions --}}
            <div class="hidden sm:flex items-center gap-4">
                 
                {{-- Theme Toggle --}}
                <button @click="toggleTheme()" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all shadow-sm">
                    <template x-if="!darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </template>
                    <template x-if="darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591 1.591M12 18.75a6.75 6.75 0 1 1 0-13.5 6.75 6.75 0 0 1 0 13.5Z" />
                        </svg>
                    </template>
                </button>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-500 hover:border-red-600 dark:hover:border-red-500 hover:bg-white dark:hover:bg-slate-800 transition-all text-xs font-bold uppercase tracking-wider">
                        Logout
                    </button>
                </form>

                <div class="h-6 w-px bg-gray-200 dark:bg-slate-800"></div>

                {{-- Profile Dropdown Trigger --}}
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button 
                        @if(Auth::user()->role !== 'admin') @click="dropdownOpen = !dropdownOpen" @endif
                        class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-full {{ Auth::user()->role !== 'admin' ? 'hover:bg-gray-50 dark:hover:bg-slate-800 cursor-pointer' : 'cursor-default' }} transition-colors border border-transparent">
                        <div class="text-right hidden lg:block">
                            <div class="text-sm font-bold text-gray-800 dark:text-slate-200 leading-none">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] font-medium text-gray-400 dark:text-slate-500 uppercase tracking-wider mt-0.5">{{ Auth::user()->role }}</div>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-red-600 to-red-500 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-red-500/20 ring-2 ring-white dark:ring-slate-900 border border-transparent">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                     {{-- Dropdown Menu --}}
                    @if(Auth::user()->role !== 'admin')
                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden py-1 z-50 origin-top-right">
                            
                            <div class="px-4 py-3 border-b border-gray-50 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
                                <p class="text-xs text-gray-500 dark:text-slate-400 uppercase font-semibold tracking-wider">Account</p>
                            </div>
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400 transition-colors">Profile Settings</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="-mr-2 flex items-center sm:hidden gap-2">
                {{-- Theme Toggle Mobile --}}
                <button @click="toggleTheme()" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 transition-all">
                    <template x-if="!darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </template>
                    <template x-if="darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591 1.591M12 18.75a6.75 6.75 0 1 1 0-13.5 6.75 6.75 0 0 1 0 13.5Z" />
                        </svg>
                    </template>
                </button>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Dropdown --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border-t border-gray-100 dark:border-slate-800 shadow-xl rounded-b-[2rem] mt-2 mx-4 overflow-hidden border border-white/20 dark:border-slate-700/30">
        <div class="pt-2 pb-3 space-y-1 px-4">
             @foreach($links as $link)
                <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}" 
                   class="block px-3 py-2 rounded-xl text-base font-medium transition-colors {{ $link['active'] ? 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 font-bold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800' }}">
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
        <div class="pt-4 pb-4 border-t border-gray-100 dark:border-slate-800 px-4 bg-gray-50 dark:bg-slate-900/50">
            <div class="flex items-center gap-3 mb-3">
                 <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white text-xs font-bold shadow-md">
                     {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                     <div class="font-bold text-base text-gray-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                     <div class="font-medium text-sm text-gray-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                     <button type="submit" class="w-full text-center px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-red-600 dark:text-red-400 font-bold shadow-sm hover:bg-red-50 dark:hover:bg-slate-700 transition">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>