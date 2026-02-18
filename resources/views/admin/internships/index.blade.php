<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Magang') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: '{{ $status }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Standard Tabs Navigation --}}
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            {{-- Applicants --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'pending']) }}" 
                               class="{{ $status === 'pending' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Pending
                                <span class="{{ $status === 'pending' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-900' }} hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">
                                    {{ $pendingCount }}
                                </span>
                            </a>

                            {{-- Onboarding --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'onboarding']) }}" 
                               class="{{ $status === 'onboarding' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Onboarding
                                <span class="{{ $status === 'onboarding' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-900' }} hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">
                                    {{ $onboardingCount }}
                                </span>
                            </a>

                            {{-- Active --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" 
                               class="{{ $status === 'active' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Active
                                <span class="{{ $status === 'active' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-900' }} hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">
                                    {{ $activeCount }}
                                </span>
                            </a>

                            {{-- Finished --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'finished']) }}" 
                               class="{{ $status === 'finished' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Finished
                            </a>

                            {{-- Extension Requests (Conditional) --}}
                            @if($extensionCount > 0 || $status === 'extension')
                            <a href="{{ route('admin.internships.index', ['status' => 'extension']) }}" 
                               class="{{ $status === 'extension' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Extended
                                @if($extensionCount > 0)
                                <span class="{{ $status === 'extension' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600' }} ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium inline-block">
                                    {{ $extensionCount }}
                                </span>
                                @endif
                            </a>
                            @endif
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Education</th>
                                    
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Division</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentor</th>

                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($internships as $internship)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-0">
                                                    <div class="text-sm font-medium text-gray-900">{{ $internship->student->name }}</div>
                                                    <div class="text-xs text-gray-400">{{ $internship->student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $eduLevel = $internship->student->studentProfile?->education_level ?? '-';
                                                $classes = $eduLevel === 'SMK' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classes }}">
                                                {{ $eduLevel }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $internship->division?->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $internship->mentor?->name ?? '-' }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($status === 'pending')
                                                <button @click="$dispatch('open-review-modal', { 
                                                    id: {{ $internship->id }}, 
                                                    name: '{{ $internship->student->name }}', 
                                                    docs: {{ json_encode($internship->documents) }},
                                                    photo: '{{ $internship->student->studentProfile && $internship->student->studentProfile->photo ? $internship->student->studentProfile->photo : null }}'
                                                })" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                                                    Review Application
                                                </button>
                                            @elseif($status === 'onboarding')
                                                <div class="flex flex-col space-y-2">
                                                    @php
                                                        $signedPact = $internship->documents->where('type', 'pakta_integritas_signed')->first();
                                                    @endphp
                                                    
                                                    @if($signedPact)
                                                        <a href="{{ Storage::url($signedPact->file_path) }}" target="_blank" 
                                                           class="inline-flex items-center justify-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            <svg class="-ml-0.5 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                            Lihat Pakta
                                                        </a>
                                                        <button @click="$dispatch('open-activation-modal', { id: {{ $internship->id }}, name: '{{ $internship->student->name }}' })" 
                                                            class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-colors duration-150">
                                                            Verifikasi & Activate
                                                        </button>
                                                    @else
                                                        <span class="inline-flex items-center justify-center px-2.5 py-1.5 rounded-md text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200 cursor-not-allowed">
                                                            Menunggu Upload Pakta
                                                        </span>
                                                    @endif
                                                </div>
                                            @elseif($status === 'finished')
                                                @php
                                                    $isSmk = optional($internship->student->studentProfile)->education_level === 'SMK';
                                                    $hasCertificate = $internship->documents->where('type', 'sertifikat_kelulusan')->count() > 0;
                                                @endphp
                                                
                                                <button @click="$dispatch('open-completion-modal', { id: {{ $internship->id }}, name: '{{ $internship->student->name }}', isSmk: {{ $isSmk ? 'true' : 'false' }} })" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    {{ $hasCertificate ? 'Update Dokumen' : 'Kirim Sertifikat' }}
                                                </button>
                                            @elseif($status === 'extension')
                                                @php
                                                    $extensionDoc = $internship->documents->where('type', 'perpanjangan_magang')->first();
                                                @endphp
                                                <button @click="$dispatch('open-extension-modal', { 
                                                    id: {{ $internship->id }}, 
                                                    name: '{{ $internship->student->name }}', 
                                                    current_end_date: '{{ $internship->end_date }}',
                                                    doc_url: '{{ $extensionDoc ? Storage::url($extensionDoc->file_path) : '#' }}'
                                                })" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm">
                                                    Review Extension
                                                </button>
                                            @else
                                                <a href="{{ route('admin.internships.edit', $internship->id) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                                                    Edit / Assign
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No data found for this status.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $internships->links() }}
                    </div>
                </div>
            </div>
        </div>
        
        @include('admin.internships.partials.review-modal')
        @include('admin.internships.partials.completion-modal')
        @include('admin.internships.partials.activation-modal')
        @include('admin.internships.partials.extension-modal')

    </div>
</x-app-layout>
