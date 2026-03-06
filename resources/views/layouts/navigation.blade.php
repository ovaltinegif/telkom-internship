<nav x-data="{ open: false }" class="sticky top-0 inset-x-0 z-[999] bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-gray-100 dark:border-slate-800 shadow-[0_4px_20px_rgb(0,0,0,0.03)] dark:shadow-[0_8px_32px_rgb(0,0,0,0.4)] transition-all duration-500">
    {{-- Full Width Navbar Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between items-center py-4 min-h-[100px] transition-all duration-300">
            
            <div class="shrink-0 flex items-center gap-4">
                <a href="{{ auth()->user()->role === 'mentor' ? route('mentor.dashboard') : route('dashboard') }}" class="flex items-center gap-3 group transition-transform duration-300 hover:scale-105">
                   <img src="{{ asset('images/logo-telkom.png') }}" class="h-[80px] w-auto dark:hidden" alt="Telkom Indonesia">
                   <img src="{{ asset('images/logo-telkom-white.png') }}" class="h-[80px] w-auto hidden dark:block" alt="Telkom Indonesia logo">
                </a>
            </div>

            {{-- Center: Modern Navigation Links --}}
            <div class="hidden md:flex items-center gap-1 absolute left-1/2 -translate-x-1/2">
                @php
                    $roleFn = fn($r) => auth()->user()->role === $r;
                    $links = [];
                    
                    if ($roleFn('mentor')) {
                         $links = []; // Mentors use the vertical Sidebar now.
                    } elseif ($roleFn('admin')) {
                         $links = []; // Admins use the vertical Sidebar now.
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
                       class="px-5 py-2.5 rounded-full text-[16px] font-bold transition-all duration-300 flex items-center gap-2 group {{ $link['active'] ? 'text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/10 shadow-sm border border-red-100 dark:border-red-500/20 ring-1 ring-red-500/50 dark:ring-red-400/30' : 'text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-500 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $link['name'] }}
                        @if(isset($link['badge']) && $link['badge'])
                            <span class="bg-red-600 text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[20px] text-center shadow-sm shadow-red-500/30">
                                {{ $link['badge'] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Right: User Profile & Actions --}}
            <div class="hidden sm:flex items-center gap-4">
                 
                {{-- Theme Toggle (Pill Shape) --}}
                <button @click="toggleTheme()" 
                        class="relative flex items-center justify-between p-1.5 w-[76px] h-10 rounded-full bg-slate-200 dark:bg-slate-800 transition-colors duration-500 focus:outline-none border border-slate-300 dark:border-slate-700 shadow-inner group">
                    <!-- Sliding background indicator -->
                    <div class="absolute w-7 h-7 bg-white dark:bg-slate-700 rounded-full shadow-[0_2px_8px_rgba(0,0,0,0.1)] dark:shadow-[0_2px_8px_rgba(0,0,0,0.5)] transform transition-transform duration-500 ease-[cubic-bezier(0.68,-0.55,0.26,1.55)]"
                         :class="darkMode ? 'translate-x-0' : 'translate-x-9'"></div>
                    
                    <!-- Moon Icon (Left) -->
                    <div class="relative w-7 h-7 flex justify-center items-center z-10 transition-transform duration-500"
                         :class="darkMode ? 'text-slate-800 dark:text-slate-100 scale-110' : 'text-slate-400 dark:text-slate-500 scale-75 group-hover:scale-90'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </div>

                    <!-- Sun Icon (Right) -->
                    <div class="relative w-7 h-7 flex justify-center items-center z-10 transition-transform duration-500"
                         :class="!darkMode ? 'text-slate-800 dark:text-slate-100 scale-110' : 'text-slate-400 dark:text-slate-500 scale-75 group-hover:scale-90'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591 1.591M12 18.75a6.75 6.75 0 1 1 0-13.5 6.75 6.75 0 0 1 0 13.5Z" />
                        </svg>
                    </div>
                </button>

                <div class="h-8 w-px bg-gray-200 dark:bg-slate-800 mx-1"></div>

                {{-- Notifications Dropdown --}}
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 text-slate-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 transition-colors focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border border-white dark:border-slate-900 rounded-full animate-pulse"></span>
                        @endif
                    </button>

                    <div x-cloak x-show="notifOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-80 max-w-[90vw] bg-white dark:bg-slate-800 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 dark:border-slate-700 overflow-hidden py-0 z-50 origin-top-right flex flex-col max-h-[85dvh]">
                        
                        <div class="px-4 py-3 border-b border-gray-50 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center z-10 sticky top-0">
                            <h3 class="font-bold text-slate-800 dark:text-slate-200">Notifikasi</h3>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllRead') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-bold">Tandai Dibaca</button>
                                </form>
                            @endif
                        </div>

                        <div class="overflow-y-auto flex-1">
                            @forelse(Auth::user()->unreadNotifications as $notification)
                                <div class="px-4 py-3 border-b border-gray-50 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors {{ loop->last ? 'border-b-0' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 rounded-full {{ $notification->data['icon'] === 'check-circle' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400' }}">
                                            @if($notification->data['icon'] === 'check-circle')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $notification->data['title'] }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</p>
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-sm text-slate-500 dark:text-slate-400">
                                    Belum ada notifikasi baru.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="h-8 w-px bg-gray-200 dark:bg-slate-800 mx-1"></div>

                {{-- Profile Dropdown Trigger --}}
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button 
                        @click="dropdownOpen = !dropdownOpen" 
                        class="flex items-center gap-4 pl-3 pr-1.5 py-1.5 rounded-full hover:bg-gray-50 dark:hover:bg-slate-800 cursor-pointer transition-colors border border-transparent focus:outline-none">
                        <div class="text-right hidden lg:block">
                            <div class="text-[15px] font-bold text-gray-800 dark:text-slate-200 leading-none">{{ Auth::user()->name }}</div>
                            <div class="text-[11px] font-medium text-gray-400 dark:text-slate-500 uppercase tracking-wider mt-1">{{ Auth::user()->role }}</div>
                        </div>
                        <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-red-600 to-red-500 flex items-center justify-center text-white text-sm font-bold shadow-md shadow-red-500/20 ring-2 ring-white dark:ring-slate-900 border border-transparent">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                     {{-- Dropdown Menu --}}
                    <div x-cloak x-show="dropdownOpen" 
                         @click.away="dropdownOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.5)] border border-gray-100 dark:border-slate-700 overflow-hidden py-1 z-50 origin-top-right">
                        
                        <div class="px-4 py-3 border-b border-gray-50 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50">
                            <p class="text-[10px] text-gray-500 dark:text-slate-400 uppercase font-bold tracking-widest">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Account' }}</p>
                        </div>
                        
                        <div class="py-1">
                            @if(Auth::user()->role !== 'admin')
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 dark:text-slate-500">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Profile Settings
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" class="block w-full m-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 font-bold transition-colors shadow-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="-mr-2 flex items-center sm:hidden gap-2">
                {{-- Notifications Dropdown (Mobile) --}}
                <div class="relative" x-data="{ notifOpenMobile: false }">
                    <button @click="notifOpenMobile = !notifOpenMobile" @click.away="notifOpenMobile = false" class="relative p-2 text-slate-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 transition-colors focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border border-white dark:border-slate-900 rounded-full animate-pulse"></span>
                        @endif
                    </button>

                    <div x-cloak x-show="notifOpenMobile"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-80 max-w-[85vw] bg-white dark:bg-slate-800 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 dark:border-slate-700 overflow-hidden py-0 z-50 origin-top-right flex flex-col max-h-[85dvh]">
                        
                        <div class="px-4 py-3 border-b border-gray-50 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center z-10 sticky top-0">
                            <h3 class="font-bold text-slate-800 dark:text-slate-200">Notifikasi</h3>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllRead') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-bold">Tandai Dibaca</button>
                                </form>
                            @endif
                        </div>

                        <div class="overflow-y-auto flex-1 max-h-[60vh]">
                            @forelse(Auth::user()->unreadNotifications as $notification)
                                <div class="px-4 py-3 border-b border-gray-50 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors {{ loop->last ? 'border-b-0' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 rounded-full {{ $notification->data['icon'] === 'check-circle' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400' }}">
                                            @if($notification->data['icon'] === 'check-circle')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $notification->data['title'] }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</p>
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-sm text-slate-500 dark:text-slate-400">
                                    Belum ada notifikasi baru.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Theme Toggle Mobile --}}
                <button @click="toggleTheme()" 
                        class="relative flex items-center justify-between p-1 w-14 h-7 rounded-full bg-slate-200 dark:bg-slate-800 transition-colors duration-500 focus:outline-none border border-slate-300 dark:border-slate-700 shadow-inner group">
                    <div class="absolute w-5 h-5 bg-white dark:bg-slate-700 rounded-full shadow-md transform transition-transform duration-500 ease-[cubic-bezier(0.68,-0.55,0.26,1.55)]"
                         :class="darkMode ? 'translate-x-0' : 'translate-x-7'"></div>
                    
                    <div class="relative w-5 h-5 flex justify-center items-center z-10 transition-transform duration-500"
                         :class="darkMode ? 'text-slate-800 dark:text-slate-100 scale-110' : 'text-slate-400 dark:text-slate-500 scale-75'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </div>

                    <div class="relative w-5 h-5 flex justify-center items-center z-10 transition-transform duration-500"
                         :class="!darkMode ? 'text-slate-800 dark:text-slate-100 scale-110' : 'text-slate-400 dark:text-slate-500 scale-75'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591 1.591M12 18.75a6.75 6.75 0 1 1 0-13.5 6.75 6.75 0 0 1 0 13.5Z" />
                        </svg>
                    </div>
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
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="sm:hidden bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border-t border-gray-100 dark:border-slate-800 shadow-2xl rounded-b-[2rem] mt-2 mx-4 overflow-hidden border border-white/20 dark:border-slate-700/30">
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