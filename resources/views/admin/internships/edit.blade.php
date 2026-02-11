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
                    <form id="updateInternshipForm" method="POST" action="{{ route('admin.internships.update', $internship->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student Name (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Student Name</label>
                                <input type="text" value="{{ $internship->student?->name ?? 'Unknown' }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" disabled>
                            </div>

                            <!-- Division (Admin can assign) -->
                            <div>
                                <label for="division_id" class="block text-sm font-medium text-gray-700">Division</label>
                                <select name="division_id" id="division_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                    <option value="">-- Unassigned --</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ $internship->division_id == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Location & Education (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" value="{{ $internship->location ?? 'Witel Semarang' }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" disabled>
                            </div>
                            
                            @php
                                $profile = \App\Models\StudentProfile::where('user_id', $internship->student_id)->first();
                            @endphp
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Education Level</label>
                                <input type="text" value="{{ $profile->education_level ?? '-' }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" disabled>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                    <option value="pending" {{ $internship->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="onboarding" {{ $internship->status == 'onboarding' ? 'selected' : '' }}>Onboarding (Accepted)</option>
                                    <option value="active" {{ $internship->status == 'active' ? 'selected' : '' }}>Active (Start Internship)</option>
                                    <option value="finished" {{ $internship->status == 'finished' ? 'selected' : '' }}>Finished</option>
                                    <option value="rejected" {{ $internship->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <!-- Mentor Selection -->
                            <div>
                                <label for="mentor_id" class="block text-sm font-medium text-gray-700">Assign Mentor</label>
                                <select name="mentor_id" id="mentor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                    <option value="">-- Select Mentor --</option>
                                    @foreach($mentors as $mentor)
                                        <option value="{{ $mentor->id }}" {{ $internship->mentor_id == $mentor->id ? 'selected' : '' }}>
                                            {{ $mentor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <!-- Document Verification -->
                            <div class="md:col-span-2 mt-4 bg-gray-50 p-4 rounded-lg border">
                                <h3 class="font-bold text-gray-800 mb-2">Verifikasi Berkas</h3>
                                <ul class="list-disc pl-5 space-y-1">
                                    @if($internship->pact_integrity)
                                        <li>
                                            <span class="uppercase font-semibold text-xs text-gray-500">PAKTA INTEGRITAS</span>: 
                                            <a href="{{ Storage::url($internship->pact_integrity) }}" target="_blank" class="text-blue-600 hover:underline">
                                                Lihat Foto
                                            </a>
                                        </li>
                                    @endif

                                    @if($internship->documents && $internship->documents->count() > 0)
                                        @foreach($internship->documents as $doc)
                                            <li>
                                                <span class="uppercase font-semibold text-xs text-gray-500">{{ str_replace('_', ' ', $doc->type) }}</span>: 
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                                    Lihat Berkas ({{ $doc->name }})
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                    
                                    @if(!$internship->pact_integrity && (!$internship->documents || $internship->documents->count() == 0))
                                        <p class="text-sm text-gray-500 italic">Belum ada berkas yang diupload.</p>
                                    @endif
                                </ul>
                            </div>

                             <!-- Start Date -->
                             <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input 
                                    type="text" 
                                    name="start_date" 
                                    id="start_date" 
                                    value="{{ \Carbon\Carbon::parse($internship->start_date)->format('Y-m-d') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm bg-white" 
                                    required
                                    placeholder="dd/mm/yyyy"
                                    x-data
                                    x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd/m/Y', locale: 'id', disableMobile: true })"
                                >
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input 
                                    type="text" 
                                    name="end_date" 
                                    id="end_date" 
                                    value="{{ \Carbon\Carbon::parse($internship->end_date)->format('Y-m-d') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm bg-white" 
                                    required
                                    placeholder="dd/mm/yyyy"
                                    x-data
                                    x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd/m/Y', locale: 'id', disableMobile: true })"
                                >
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-4">
                            <button type="button" onclick="confirmUpdate()" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold shadow hover:bg-red-700 transition">
                                Update Internship
                            </button>
                            <a href="{{ route('admin.internships.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            const form = document.getElementById('updateInternshipForm');
            
            if (form.reportValidity()) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan memperbarui status magang ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, perbarui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        }
    </script>
</x-app-layout>
