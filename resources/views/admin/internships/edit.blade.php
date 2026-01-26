<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Internship') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.internships.update', $internship->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student Name (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Student Name</label>
                                <input type="text" value="{{ $internship->student->name }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" disabled>
                            </div>

                            <!-- Division (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Division</label>
                                <input type="text" value="{{ $internship->division->name }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" disabled>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                    <option value="active" {{ $internship->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="finished" {{ $internship->status == 'finished' ? 'selected' : '' }}>Finished</option>
                                    <option value="onboarding" {{ $internship->status == 'onboarding' ? 'selected' : '' }}>Onboarding</option>
                                </select>
                            </div>

                             <!-- Start Date -->
                             <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ \Carbon\Carbon::parse($internship->start_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ \Carbon\Carbon::parse($internship->end_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold shadow hover:bg-red-700 transition">
                                Update Internship
                            </button>
                            <a href="{{ route('admin.internships.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
