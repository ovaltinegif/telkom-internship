<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Standard Tabs Navigation --}}
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            {{-- All Users --}}
                            <a href="{{ route('admin.users.index') }}" 
                               class="{{ !request('role') ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                All Users
                            </a>

                            {{-- Intern --}}
                            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" 
                               class="{{ request('role') == 'student' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Intern
                            </a>

                            {{-- Mentors --}}
                            <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" 
                               class="{{ request('role') == 'mentor' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Mentors
                            </a>

                            {{-- Admins --}}
                            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
                               class="{{ request('role') == 'admin' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Admins
                            </a>
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white font-bold shadow-sm border border-white">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $roleClasses = [
                                                    'admin' => 'bg-purple-100 text-purple-800',
                                                    'mentor' => 'bg-blue-100 text-blue-800',
                                                    'student' => 'bg-green-100 text-green-800', // Default student color
                                                ];
                                                
                                                // Check for specific student type (SMK)
                                                if ($user->role === 'student' && optional($user->studentProfile)->student_type === 'siswa') {
                                                    $roleClasses['student'] = 'bg-indigo-100 text-indigo-800'; // Different color for SMK
                                                }
                                                
                                                $classes = $roleClasses[$user->role] ?? 'bg-gray-100 text-gray-800';
                                                
                                                $displayRole = ucfirst($user->role);
                                                if ($user->role === 'student') {
                                                    $displayRole = optional($user->studentProfile)->student_type === 'siswa' ? 'SMK' : 'Mahasiswa';
                                                }
                                            @endphp
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full {{ $classes }}">
                                                {{ $displayRole }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->format('d M Y') }}
                                            <span class="text-xs text-gray-400 block">{{ $user->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 whitespace-nowrap text-center text-sm text-gray-500 opacity-60">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            No users found for this category.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $users->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
