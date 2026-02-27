<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-slate-200 leading-tight transition-colors">
            {{ __('Data User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-8">
                    
                    {{-- Standard Tabs Navigation --}}
                    <div class="border-b border-gray-200 dark:border-slate-800 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-colors">
                        <nav class="-mb-px flex space-x-8 overflow-x-auto w-full md:w-auto" aria-label="Tabs">
                            {{-- All Users --}}
                            <a href="{{ route('admin.users.index') }}" 
                               class="{{ !request('role') ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm flex items-center transition-all">
                                All Users
                            </a>

                            {{-- Intern --}}
                            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" 
                               class="{{ request('role') == 'student' ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm flex items-center transition-all">
                                Intern
                            </a>

                            {{-- Mentors --}}
                            <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" 
                               class="{{ request('role') == 'mentor' ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm flex items-center transition-all">
                                Mentors
                            </a>

                        </nav>
                        
                        {{-- Sub Filter for Interns --}}
                        @if(request('role') == 'student')
                            <div class="inline-flex bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-1" role="group">
                                <a href="{{ route('admin.users.index', ['role' => 'student', 'student_type' => 'mahasiswa']) }}" 
                                   class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                   {{ !request('student_type') || request('student_type') == 'mahasiswa' 
                                      ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                      : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    Mahasiswa
                                </a>
                                <a href="{{ route('admin.users.index', ['role' => 'student', 'student_type' => 'smk']) }}" 
                                   class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                   {{ request('student_type') == 'smk' 
                                      ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                      : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    SMK
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                            <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">User</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Role</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Registered</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white font-bold shadow-md border border-white dark:border-slate-800 transition-colors">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900 dark:text-slate-200 transition-colors">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-slate-500 transition-colors">{{ $user->email }}</div>
                                                    
                                                    @if($user->role === 'mentor' && $user->relationLoaded('mentoredInternships') && $user->mentoredInternships->isNotEmpty())
                                                        <div class="mt-2 flex flex-wrap gap-1">
                                                            @foreach($user->mentoredInternships as $internship)
                                                                @if($internship->student)
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition-colors">
                                                                        <svg class="mr-1 h-3 w-3 text-slate-400 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        {{ $internship->student->name }}
                                                                    </span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $roleClasses = [
                                                    'admin' => 'bg-purple-100 dark:bg-purple-500/10 text-purple-800 dark:text-purple-400 border border-purple-200 dark:border-purple-500/20',
                                                    'mentor' => 'bg-blue-100 dark:bg-blue-500/10 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20',
                                                    'student' => 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20',
                                                ];
                                                
                                                $isSmk = optional($user->studentProfile)->student_type === 'siswa' || optional($user->studentProfile)->education_level === 'SMK';

                                                if ($user->role === 'student' && $isSmk) {
                                                    $roleClasses['student'] = 'bg-indigo-100 dark:bg-indigo-500/10 text-indigo-800 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/20';
                                                }
                                                
                                                $classes = $roleClasses[$user->role] ?? 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700';
                                                
                                                $displayRole = ucfirst($user->role);
                                                if ($user->role === 'student') {
                                                    $displayRole = $isSmk ? 'SMK' : 'Mahasiswa';
                                                }
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg shadow-sm {{ $classes }} transition-all">
                                                {{ $displayRole }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 transition-colors">
                                            {{ $user->created_at->format('d M Y') }}
                                            <span class="text-xs text-gray-400 dark:text-slate-500 block transition-colors">{{ $user->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 min-h-[160px]">
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
