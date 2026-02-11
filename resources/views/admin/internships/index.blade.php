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
                                Applicants
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
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    
                                    @if($status === 'active')
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Division</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentor</th>
                                    @endif

                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                                        
                                        @if($status === 'active')
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $internship->division?->name ?? 'Unassigned' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $internship->mentor?->name ?? 'Unassigned' }}</div>
                                            </td>
                                        @endif

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $internship->status == 'active' ? 'bg-green-100 text-green-800' : 
                                                  ($internship->status == 'finished' ? 'bg-blue-100 text-blue-800' : 
                                                  ($internship->status == 'onboarding' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ ucfirst($internship->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($status === 'pending')
                                                <button @click="$dispatch('open-review-modal', { id: {{ $internship->id }}, name: '{{ $internship->student->name }}', docs: {{ json_encode($internship->documents) }} })" 
                                                    class="text-indigo-600 hover:text-indigo-900 font-bold">
                                                    Review
                                                </button>
                                            @elseif($status === 'onboarding')
                                                <form action="{{ route('admin.internships.activate', $internship->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Verifikasi Pakta Integritas & Aktifkan Magang?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 font-bold">
                                                        Verifikasi & Activate
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('admin.internships.edit', $internship->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Assign</a>
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

    </div>
</x-app-layout>
