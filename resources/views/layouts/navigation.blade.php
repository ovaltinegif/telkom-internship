<nav x-data="{ open: false }" class="sticky top-0 inset-x-0 z-[999] bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
    {{-- Full Width Navbar Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-28 transition-all duration-300">
            
            {{-- Left: Logo --}}
            <div class="shrink-0 flex items-center gap-4">
                <a href="{{ Auth::user()->role === 'mentor' ? route('mentor.dashboard') : route('dashboard') }}" class="flex items-center gap-3 group">
                   <img src="{{ asset('images/logo-telkom.png') }}" class="h-24 w-auto" alt="Telkom Indonesia">
                </a>
            </div>

            {{-- Center: Modern Navigation Links --}}
            <div class="hidden md:flex items-center gap-1">
                 @php
                    $roleFn = fn($r) => Auth::user()->role === $r;
                    $links = [];
                    if ($roleFn('mentor')) {
                        $links = [
                            ['name' => 'Dashboard', 'route' => 'mentor.dashboard', 'active' => request()->routeIs('mentor.dashboard')],
                            ['name' => 'Approval', 'route' => '#', 'active' => false],
                            ['name' => 'Grading', 'route' => '#', 'active' => false],
                        ];
                    } elseif ($roleFn('admin')) {
                         $links = [
                            ['name' => 'Overview', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard')],
                            ['name' => 'Database', 'route' => 'admin.users.index', 'active' => request()->routeIs('admin.users*') || request()->routeIs('admin.divisions*')],
                            ['name' => 'Monitoring', 'route' => 'admin.internships.index', 'active' => request()->routeIs('admin.internships*')],
                        ];
                    } else {
                        $links = [
                            ['name' => 'My Dashboard', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')],
                            ['name' => 'Activity', 'route' => 'logbooks.index', 'active' => request()->routeIs('logbooks.index')],
                            ['name' => 'Document', 'route' => 'documents.index', 'active' => request()->routeIs('documents.index')],
                        ];
                    }
                @endphp

                @foreach($links as $link)
                    <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}" 
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $link['active'] ? 'text-red-700 bg-red-50 shadow-sm border border-red-100' : 'text-slate-500 hover:text-red-600 hover:bg-slate-50' }}">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </div>

            {{-- Right: User Profile & Actions --}}
            <div class="hidden sm:flex items-center gap-4">
                 
                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-600 hover:bg-white transition-all text-xs font-bold uppercase tracking-wider">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>

                <div class="h-6 w-px bg-gray-200"></div>

                {{-- Profile Dropdown Trigger --}}
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-full hover:bg-gray-50 transition-colors border border-transparent">
                        <div class="text-right hidden lg:block">
                            <div class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ Auth::user()->role }}</div>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-red-600 to-red-500 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-red-500/20 ring-2 ring-white">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                     {{-- Dropdown Menu --}}
                    <div x-show="dropdownOpen" 
                         @click.away="dropdownOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden py-1 z-50 origin-top-right">
                        
                        <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Account</p>
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">Profile Settings</a>
                        <a href="{{ route('help.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">Help Center</a>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Dropdown --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 backdrop-blur-xl border-t border-gray-100 shadow-xl rounded-b-[2rem] mt-2 mx-4 overflow-hidden border border-white/20">
        <div class="pt-2 pb-3 space-y-1 px-4">
             @foreach($links as $link)
                <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}" 
                   class="block px-3 py-2 rounded-xl text-base font-medium transition-colors {{ $link['active'] ? 'bg-red-50 text-red-600 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
        <div class="pt-4 pb-4 border-t border-gray-100 px-4 bg-gray-50">
            <div class="flex items-center gap-3 mb-3">
                 <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white text-xs font-bold shadow-md">
                     {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                     <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                     <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                     <button type="submit" class="w-full text-center px-4 py-2 rounded-xl bg-white border border-gray-200 text-red-600 font-bold shadow-sm hover:bg-red-50 transition">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>