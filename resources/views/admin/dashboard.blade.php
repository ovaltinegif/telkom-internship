<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Dashboard</h1>
                    <p class="text-gray-500 mt-1">Welcome back, <span class="font-bold text-red-600">{{ Auth::user()->name }}</span>. Here's your daily overview.</p>
                </div>
                
                <div class="flex gap-3">
                     <a href="{{ route('admin.users.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                </div>
            </div>

            {{-- Stats Grid (Solid Red & Clean) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card 1: Total Mahasiswa --}}
                <div class="bg-[#ce0024] rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border-l-4 border-red-800">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1">Total Mahasiswa</p>
                            <h3 class="text-5xl font-extrabold">{{ $totalStudents }}</h3>
                        </div>
                        <div class="p-2 bg-white/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex items-center gap-3">
                        @if($studentGrowth > 0)
                            <div class="flex items-center gap-1 bg-white text-[#ce0024] px-3 py-1 rounded-full font-bold shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>+{{ $studentGrowth }}</span>
                            </div>
                            <span class="text-sm font-medium text-red-50">Orang Baru Bulan Ini</span>
                        @else
                             <span class="text-sm font-medium text-red-200">Data Stabil Bulan Ini</span>
                        @endif
                    </div>

                    <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="absolute inset-0 z-10"></a>
                </div>

                {{-- Card 2: Magang Aktif --}}
                <div class="bg-[#ce0024] rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border-l-4 border-red-800">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1">Magang Aktif</p>
                            <h3 class="text-5xl font-extrabold">{{ $activeInternships }}</h3>
                        </div>
                        <div class="p-2 bg-white/10 rounded-lg">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        @if($internshipGrowth > 0)
                            <div class="flex items-center gap-1 bg-white text-[#ce0024] px-3 py-1 rounded-full font-bold shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>+{{ $internshipGrowth }}</span>
                            </div>
                            <span class="text-sm font-medium text-red-50">Posisi Terisi Bulan Ini</span>
                        @else
                            <span class="text-sm font-medium text-red-200">Tidak ada penambahan</span>
                        @endif
                    </div>
                     <a href="#" class="absolute inset-0 z-10"></a>
                </div>

                {{-- Card 3: Mentor --}}
                <div class="bg-[#ce0024] rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border-l-4 border-red-800">
                    <div class="flex justify-between items-start">
                         <div>
                            <p class="text-red-100 text-sm font-bold uppercase tracking-wider mb-1">Total Mentor</p>
                            <h3 class="text-5xl font-extrabold">{{ $totalMentors }}</h3>
                        </div>
                        <div class="p-2 bg-white/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                         @if($mentorGrowth > 0)
                            <div class="flex items-center gap-1 bg-white text-[#ce0024] px-3 py-1 rounded-full font-bold shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>+{{ $mentorGrowth }}</span>
                            </div>
                            <span class="text-sm font-medium text-red-50">Mentor Baru Bulan Ini</span>
                        @else
                            <span class="text-sm font-medium text-red-200">Tim Mentor Stabil</span>
                        @endif
                    </div>
                    <a href="{{ route('admin.mentors.create') }}" class="absolute inset-0 z-10"></a>
                </div>
            </div>


            {{-- Action Items Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Pending Applicants -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Pending Applicants</h3>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">{{ $pendingApplicants }} Waiting</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">Mahasiswa baru menunggu review dan persetujuan.</p>
                    
                    @if($pendingApplicants > 0)
                        <a href="{{ route('admin.internships.index', ['status' => 'pending']) }}" class="block w-full text-center py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                            Review Applications
                        </a>
                    @else
                        <button onclick="Swal.fire('Info', 'Tidak ada aplikasi pending saat ini.', 'info')" class="block w-full text-center py-2.5 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                            Review Applications
                        </button>
                    @endif
                </div>

                <!-- Pending Extensions -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                     <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Extension Requests</h3>
                        </div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">{{ $pendingExtensions->count() }} Requests</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">Pengajuan perpanjangan durasi magang.</p>
                    
                    @if($pendingExtensions->count() > 0)
                        <a href="{{ route('admin.internships.index', ['status' => 'extension']) }}" class="block w-full text-center py-2.5 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition">
                            Review Extensions
                        </a>
                    @else
                        <button onclick="Swal.fire('Info', 'Tidak ada pengajuan perpanjangan saat ini.', 'info')" class="block w-full text-center py-2.5 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                            Review Extensions
                        </button>
                    @endif
                </div>
            </div>

            {{-- Recent Activity Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Internship Activity</h3>
                    <a href="{{ route('admin.internships.index') }}" class="text-sm text-red-600 font-semibold hover:text-red-800">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4">Student</th>
                                <th class="px-6 py-4">Division</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentInternships as $internship)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $internship->student->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $internship->student->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $internship->division->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold
                                        {{ $internship->status == 'active' ? 'bg-green-100 text-green-700' : 
                                          ($internship->status == 'pending' ? 'bg-red-100 text-red-700' : 
                                          ($internship->status == 'finished' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')) }}">
                                        {{ ucfirst($internship->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $internship->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No recent activity found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    
    @include('admin.internships.partials.extension-modal')

</x-app-layout>