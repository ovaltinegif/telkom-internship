<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Internship') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    @php
                        $profile = \App\Models\StudentProfile::where('user_id', $internship->student_id)->first();
                    @endphp

                    <!-- Header Section: Student Identity -->
                    <div class="flex items-center space-x-6 border-b pb-8 mb-8">
                        <div class="flex-shrink-0">
                            @if($profile && $profile->photo)
                                <img class="h-24 w-24 rounded-full object-cover shadow-md border-4 border-white" src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $internship->student->name }}">
                            @else
                                <div class="h-24 w-24 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white text-3xl font-bold shadow-md border-4 border-white">
                                    {{ substr($internship->student->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $internship->student->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $internship->student->email }}</p>
                            <div class="mt-2">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $internship->status === 'active' ? 'bg-green-100 text-green-800' : 
                                      ($internship->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                      ($internship->status === 'finished' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ strtoupper($internship->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        
                        <!-- Col 1: Student Information -->
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 p-2 rounded-lg text-blue-600 mr-3">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-800">Student Profile</h4>
                            </div>
                            
                            <dl class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ optional($profile)->student_type === 'siswa' ? 'School' : 'University' }}</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $profile->university ?? '-' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Major</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $profile->major ?? '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ optional($profile)->student_type === 'siswa' ? 'NIS/NISN' : 'NIM' }}</dt>
                                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $profile->nim ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Education Level</dt>
                                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $profile->education_level ?? '-' }}</dd>
                                    </div>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone / WhatsApp</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $profile->phone_number ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Col 2: Internship Details -->
                        <div>
                             <div class="flex items-center mb-4">
                                <div class="bg-red-100 p-2 rounded-lg text-red-600 mr-3">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-800">Internship Data</h4>
                            </div>

                            <dl class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Division</dt>
                                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $internship->division?->name ?? 'Unassigned' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</dt>
                                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $internship->location ?? 'Witel Semarang' }}</dd>
                                    </div>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Mentor</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $internship->mentor?->name ?? 'Not Assigned' }}</dd>
                                </div>

                                <div class="border-t border-gray-200 pt-4 mt-2">
                                    <h5 class="text-xs font-bold text-gray-400 uppercase mb-3">Duration</h5>
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">Start Date</dt>
                                            <dd class="mt-1 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}</dd>
                                        </div>
                                        <div class="text-gray-300">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">End Date</dt>
                                            <dd class="mt-1 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</dd>
                                        </div>
                                    </div>
                                </div>
                            </dl>
                        </div>

                        <!-- Full Width: Documents -->
                        <div class="lg:col-span-2">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 p-2 rounded-lg text-green-600 mr-3">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-800">Uploaded Documents</h4>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                <ul class="divide-y divide-gray-100">
                                    @if($internship->pact_integrity)
                                         <li class="p-4 hover:bg-gray-50 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span class="text-sm font-medium text-gray-700">Pakta Integritas (Signed)</span>
                                            </div>
                                            <a href="{{ Storage::url($internship->pact_integrity) }}" target="_blank" class="text-sm text-blue-600 font-semibold hover:text-blue-800 hover:underline">
                                                View Document
                                            </a>
                                        </li>
                                    @endif

                                    @forelse($internship->documents as $doc)
                                        <li class="p-4 hover:bg-gray-50 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $doc->name }}</p>
                                                    <p class="text-xs text-gray-500 uppercase">{{ str_replace('_', ' ', $doc->type) }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="px-3 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-bold hover:bg-blue-100 transition">
                                                Open
                                            </a>
                                        </li>
                                    @empty
                                        @if(!$internship->pact_integrity)
                                            <li class="p-8 text-center text-gray-500 italic">
                                                No documents uploaded yet.
                                            </li>
                                        @endif
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="mt-10 flex items-center justify-end border-t pt-6">
                        <a href="{{ route('admin.internships.index', ['status' => $internship->status]) }}" class="flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg font-bold shadow-sm hover:bg-gray-50 hover:text-gray-900 transition mb-10">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
