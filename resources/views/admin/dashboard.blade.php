<x-app-layout>
    {{-- No default header slot, we use custom layout in body --}}
    
    <div class="py-12 bg-white min-h-screen relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col gap-12 items-center">
                
                {{-- Welcome & Quick Actions (Centered) --}}
                <div class="flex flex-col items-center text-center w-full max-w-4xl">
                   <h1 class="text-6xl font-serif text-black mb-1">Welcome,</h1>
                    <h1 class="text-6xl font-serif text-black mb-10">{{ Auth::user()->name }}.</h1>

                    {{-- Admin Quick Stats / Tasks (Center Aligned) --}}
                    {{-- Refined Widget: Matches Telkomsel App "Menu Grid" Style --}}
                    <div class="bg-transparent w-full relative z-10 flex justify-center">
                        <div class="grid grid-cols-3 gap-12">
                            
                            {{-- Menu Item 1: Setup Magang --}}
                            <a href="{{ route('admin.internship.create') }}" class="flex flex-col items-center group">
                                <div class="w-16 h-16 bg-white rounded-[24px] shadow-sm border border-gray-100 flex items-center justify-center mb-3 group-hover:shadow-md group-hover:scale-105 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-gray-700 text-center leading-tight">Setup<br>Magang</span>
                            </a>

                            {{-- Menu Item 2: Data User --}}
                            <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center group">
                                <div class="w-16 h-16 bg-white rounded-[24px] shadow-sm border border-gray-100 flex items-center justify-center mb-3 group-hover:shadow-md group-hover:scale-105 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-gray-700 text-center leading-tight">Data<br>User</span>
                            </a>

                            {{-- Menu Item 3: Divisi --}}
                            <a href="{{ route('admin.divisions.index') }}" class="flex flex-col items-center group">
                                <div class="w-16 h-16 bg-white rounded-[24px] shadow-sm border border-gray-100 flex items-center justify-center mb-3 group-hover:shadow-md group-hover:scale-105 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-gray-700 text-center leading-tight">Kelola<br>Divisi</span>
                            </a>

                        </div>
                    </div>
                </div>

            </div>
            
            {{-- Additional Stats Area (Below the main fold) --}}
            <div class="mt-24 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Statistic Card 1: Total Mahasiswa --}}
                    <div class="rounded-[24px] bg-gradient-to-br from-[#FF0022] to-[#B00020] p-6 text-white shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                        <!-- Background Pattern mimicking Telkomsel 'Mesh' -->
                        <div class="absolute -right-12 -top-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-[#800000]/30 rounded-full blur-2xl pointer-events-none"></div>
                        
                        <div class="relative z-10 flex flex-col justify-between h-full min-h-[140px]">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-2 text-red-50 text-sm font-medium mb-1 drop-shadow-sm">
                                        Total Mahasiswa
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="text-5xl font-bold tracking-tight drop-shadow-md">{{ $totalStudents }}</div>
                                    <div class="text-xs text-red-100 mt-1 font-light opacity-90">Terdaftar dalam sistem</div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition backdrop-blur-sm shadow-sm border border-white/10 group-hover:border-white/30" title="Tambah Mahasiswa">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-white/10">
                                <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="flex items-center justify-between group-hover:pl-1 transition-all">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-[#B71C1C] px-3 py-1 rounded-full text-[10px] font-bold shadow-inner uppercase tracking-wider border border-white/5">Regular</span>
                                        <span class="text-xs font-semibold tracking-wide">Lihat Detail</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Statistic Card 2: Magang Aktif --}}
                    <div class="rounded-[24px] bg-gradient-to-br from-[#FF0022] to-[#B00020] p-6 text-white shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                         <!-- Background Pattern -->
                        <div class="absolute -right-12 -top-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-[#800000]/30 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col justify-between h-full min-h-[140px]">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-2 text-red-50 text-sm font-medium mb-1 drop-shadow-sm">
                                        Magang Aktif
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="text-5xl font-bold tracking-tight drop-shadow-md">{{ $activeInternships }}</div>
                                    <div class="text-xs text-red-100 mt-1 font-light opacity-90">Sedang Berjalan</div>
                                </div>
                                <div class="flex gap-2">
                                     <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition backdrop-blur-sm shadow-sm border border-white/10 group-hover:border-white/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                             <div class="mt-6 pt-4 border-t border-white/10">
                                <a href="{{ route('admin.internships.index') }}" class="flex items-center justify-between group-hover:pl-1 transition-all">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-[#B71C1C] px-3 py-1 rounded-full text-[10px] font-bold shadow-inner uppercase tracking-wider border border-white/5">Report</span>
                                        <span class="text-xs font-semibold tracking-wide">Monitoring</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Statistic Card 3: Total Mentor --}}
                    <div class="rounded-[24px] bg-gradient-to-br from-[#FF0022] to-[#B00020] p-6 text-white shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                         <!-- Background Pattern -->
                        <div class="absolute -right-12 -top-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-[#800000]/30 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col justify-between h-full min-h-[140px]">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-2 text-red-50 text-sm font-medium mb-1 drop-shadow-sm">
                                        Total Mentor
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="text-5xl font-bold tracking-tight drop-shadow-md">{{ $totalMentors }}</div>
                                    <div class="text-xs text-red-100 mt-1 font-light opacity-90">Mentor Aktif</div>
                                </div>
                                <div class="flex gap-2">
                                     <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition backdrop-blur-sm shadow-sm border border-white/10 group-hover:border-white/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                             <div class="mt-6 pt-4 border-t border-white/10">
                                <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" class="flex items-center justify-between group-hover:pl-1 transition-all">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-[#B71C1C] px-3 py-1 rounded-full text-[10px] font-bold shadow-inner uppercase tracking-wider border border-white/5">Access</span>
                                        <span class="text-xs font-semibold tracking-wide">Kelola Mentor</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>



</x-app-layout>