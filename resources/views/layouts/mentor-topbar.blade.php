<header class="h-20 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-800 flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0 transition-colors duration-300">
    <div class="flex items-center gap-4">
        {{-- Mobile Hamburger --}}
        <button class="lg:hidden text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        {{-- Show Logo on mobile only --}}
        <a href="{{ route('mentor.dashboard') }}" class="lg:hidden flex items-center">
            <img src="{{ asset('images/logo-telkom.png') }}" class="h-8 w-auto dark:hidden" alt="Telkom">
            <img src="{{ asset('images/logo-telkom-white.png') }}" class="h-8 w-auto hidden dark:block" alt="Telkom">
        </a>
    </div>
    
    <div class="flex items-center gap-4 sm:gap-6">
        
        {{-- Search bar subtle --}}
        <div class="hidden md:flex items-center bg-slate-50 dark:bg-slate-950 rounded-full px-4 py-2 border border-slate-200 dark:border-slate-800 focus-within:bg-white dark:focus-within:bg-slate-900 focus-within:border-red-300 dark:focus-within:border-red-800/50 focus-within:shadow-sm transition-all w-64 group/search">
            <svg class="w-4 h-4 text-slate-400 group-focus-within/search:text-red-500 transition-colors mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" placeholder="Quick search..." class="bg-transparent border-none outline-none text-sm w-full text-slate-700 dark:text-slate-300 placeholder-slate-400 dark:placeholder-slate-500 focus:ring-0 p-0">
        </div>

        {{-- Theme Toggle --}}
        <button @click="toggleTheme()" 
                class="relative flex items-center justify-between p-1.5 w-[76px] h-10 rounded-full bg-slate-100 dark:bg-slate-800 transition-colors duration-500 focus:outline-none border border-slate-200 dark:border-slate-700 shadow-inner group">
            <div class="absolute w-7 h-7 bg-white dark:bg-slate-700 rounded-full shadow-sm transform transition-transform duration-500 ease-[cubic-bezier(0.68,-0.55,0.26,1.55)]"
                    :class="darkMode ? 'translate-x-0' : 'translate-x-9'"></div>
            
            <div class="relative w-7 h-7 flex justify-center items-center z-10 transition-transform duration-500"
                    :class="darkMode ? 'text-slate-800 dark:text-slate-100 scale-110' : 'text-slate-400 dark:text-slate-500 scale-75 group-hover:scale-90'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </div>

            <div class="relative w-7 h-7 flex justify-center items-center z-10 transition-transform duration-500"
                    :class="!darkMode ? 'text-slate-800 dark:text-slate-100 scale-110' : 'text-slate-400 dark:text-slate-500 scale-75 group-hover:scale-90'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-[18px] h-[18px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591 1.591M12 18.75a6.75 6.75 0 1 1 0-13.5 6.75 6.75 0 0 1 0 13.5Z" />
                </svg>
            </div>
        </button>

        <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>

        {{-- Notifications Dropdown --}}
        <div class="relative hidden sm:block" x-data="{ notifOpen: false }">
            <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 text-slate-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 transition-colors focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
                
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-slate-900 rounded-full animate-pulse"></span>
                @endif
            </button>

             {{-- Shared Notification logic from navigation --}}
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

        {{-- Profile Info (Static - No Dropdown) --}}
        <div class="relative pl-4 border-l border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-500 uppercase tracking-wider font-bold">Mentor</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-red-600 to-red-500 flex items-center justify-center text-white text-sm font-bold shadow-md shadow-red-500/20 ring-2 ring-white dark:ring-slate-900 border border-transparent">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>
</header>
