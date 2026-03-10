<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-slate-200 leading-tight transition-colors hidden">
            {{ __('Data User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Page Title Area -->
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Data User</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Manage all registered users, roles, and access across the application.</p>
            </div>

            <!-- Main Container -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                <div class="p-8">
                    
                    <!-- Controls Row: Tabs & Actions -->
                    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 border-b border-slate-100 dark:border-slate-800 pb-6 mb-6 transition-colors">
                        
                        <!-- Premium Tabs -->
                        <nav class="flex space-x-2 overflow-x-auto w-full xl:w-auto pb-2 xl:pb-0" aria-label="Tabs">
                            {{-- All Users --}}
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ !request('role') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                All Users
                                <span class="ml-2 {{ !request('role') ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalAll }}</span>
                            </a>

                            {{-- Intern --}}
                            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ request('role') == 'student' ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Intern
                                <span class="ml-2 {{ request('role') == 'student' ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalStudents }}</span>
                            </a>

                            {{-- Mentors --}}
                            <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ request('role') == 'mentor' ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Mentors
                                <span class="ml-2 {{ request('role') == 'mentor' ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalMentors }}</span>
                            </a>
                        </nav>
                        
                        <!-- Actions & Filters -->
                        <div class="flex flex-col lg:flex-row items-center gap-4 w-full xl:w-auto">
                            {{-- Sub Filter for Interns --}}
                            @if(request('role') == 'student')
                                <div class="inline-flex bg-slate-50 dark:bg-slate-950 rounded-xl shadow-inner border border-slate-200 dark:border-slate-800 p-1 shrink-0" role="group">
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['student_type' => 'mahasiswa', 'page' => null])) }}"
                                        class="px-4 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg transition-all flex items-center gap-2
                                        {{ !request('student_type') || request('student_type') == 'mahasiswa' 
                                            ? 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-700' 
                                            : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border border-transparent' }}">
                                            Mahasiswa
                                            <span class="bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-1.5 py-0.5 rounded text-[9px]">{{ $studentMahasiswaCount }}</span>
                                    </a>
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['student_type' => 'smk', 'page' => null])) }}" 
                                        class="px-4 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg transition-all flex items-center gap-2
                                        {{ request('student_type') == 'smk' 
                                            ? 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-700' 
                                            : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border border-transparent' }}">
                                            SMK
                                            <span class="bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-1.5 py-0.5 rounded text-[9px]">{{ $studentSmkCount }}</span>
                                    </a>
                                </div>
                            @endif

                            <!-- Search -->
                            <form action="{{ route('admin.users.index') }}" method="GET" class="relative w-full sm:flex-1 xl:w-72" x-data x-ref="form">
                                @if(request('role'))
                                    <input type="hidden" name="role" value="{{ request('role') }}">
                                @endif
                                @if(request('student_type'))
                                    <input type="hidden" name="student_type" value="{{ request('student_type') }}">
                                @endif
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Search user..." 
                                    @input.debounce.500ms="$refs.form.submit()"
                                    x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length);"
                                    class="pl-9 pr-4 py-2.5 w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all placeholder-slate-400 font-medium text-slate-700 dark:text-slate-300">
                            </form>
                        </div>
                    </div>


                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                            <thead class="bg-slate-50/50 dark:bg-slate-950/50">
                                <tr>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest sm:rounded-tl-xl sm:rounded-bl-xl">User Detail</th>
                                    <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Role</th>
                                    <th scope="col" class="px-6 py-5 text-center text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest sm:rounded-tr-xl sm:rounded-br-xl">Registered</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/80 dark:divide-slate-800/80">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors group {{ $loop->last ? 'border-b-0' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="relative">
                                                    @php
                                                        $avatarColors = [
                                                            'admin' => 'from-purple-500 to-indigo-500',
                                                            'mentor' => 'from-blue-500 to-cyan-500',
                                                            'student' => 'from-emerald-400 to-teal-500',
                                                        ];
                                                        $isSmk = optional($user->studentProfile)->student_type === 'siswa' || optional($user->studentProfile)->education_level === 'SMK';
                                                        if ($user->role === 'student' && $isSmk) {
                                                            $avatarColors['student'] = 'from-amber-400 to-orange-500';
                                                        }
                                                        $bgGradient = $avatarColors[$user->role] ?? 'from-slate-400 to-slate-500';
                                                    @endphp
                                                    <div class="h-11 w-11 rounded-full bg-gradient-to-tr {{ $bgGradient }} flex items-center justify-center text-white font-bold text-lg shadow-sm border-2 border-white dark:border-slate-800 group-hover:scale-105 transition-transform">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 transition-colors group-hover:text-red-600 dark:group-hover:text-red-400">{{ $user->name }}</div>
                                                    <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 tracking-wider mt-0.5">{{ $user->email }}</div>
                                                    
                                                    @if($user->role === 'mentor' && $user->relationLoaded('mentoredInternships') && $user->mentoredInternships->isNotEmpty())
                                                        <div class="mt-2 flex flex-wrap gap-1">
                                                            @foreach($user->mentoredInternships->take(2) as $internship)
                                                                @if($internship->student)
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 transition-colors">
                                                                        <svg class="mr-1 h-3 w-3 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        {{ explode(' ', $internship->student->name)[0] }}
                                                                    </span>
                                                                @endif
                                                            @endforeach
                                                            @if($user->mentoredInternships->count() > 2)
                                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700">+{{ $user->mentoredInternships->count() - 2 }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $roleConfig = [
                                                    'admin' => ['bg' => 'bg-purple-50 dark:bg-purple-500/10', 'text' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-100 dark:border-purple-500/20', 'dot' => 'bg-purple-500'],
                                                    'mentor' => ['bg' => 'bg-blue-50 dark:bg-blue-500/10', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-100 dark:border-blue-500/20', 'dot' => 'bg-blue-500'],
                                                    'student' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'text' => 'text-emerald-600 dark:text-emerald-400', 'border' => 'border-emerald-100 dark:border-emerald-500/20', 'dot' => 'bg-emerald-500'],
                                                ];
                                                
                                                if ($user->role === 'student' && $isSmk) {
                                                    $roleConfig['student'] = ['bg' => 'bg-indigo-50 dark:bg-indigo-500/10', 'text' => 'text-indigo-600 dark:text-indigo-400', 'border' => 'border-indigo-100 dark:border-indigo-500/20', 'dot' => 'bg-indigo-500'];
                                                }
                                                
                                                $config = $roleConfig[$user->role] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-100', 'dot' => 'bg-slate-500'];
                                                
                                                $displayRole = ucfirst($user->role);
                                                if ($user->role === 'student') {
                                                    $displayRole = $isSmk ? 'SMK' : 'Mahasiswa';
                                                }
                                            @endphp
                                            <span class="px-3 py-1 inline-flex items-center text-[10px] uppercase tracking-widest font-black rounded-lg shadow-sm {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }} transition-all">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }} mr-1.5"></span>
                                                {{ $displayRole }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell text-center">
                                            <div class="text-sm font-bold text-slate-600 dark:text-slate-300 transition-colors">{{ $user->created_at->format('d M Y') }}</div>
                                            <div class="text-[11px] font-medium text-slate-400 dark:text-slate-500 mt-0.5 block transition-colors">{{ $user->created_at->diffForHumans() }}</div>
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400 min-h-[160px]">
                                            <div class="flex flex-col items-center justify-center h-full gap-2">
                                                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                                <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">No users found for this category.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $users->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
