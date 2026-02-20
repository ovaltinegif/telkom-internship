<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Magang') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data>
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
                            @if($extensionCount > 0)
                            <a href="{{ route('admin.internships.index', ['status' => 'extension']) }}" 
                               class="{{ $status === 'extension' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                Extended
                                <span class="{{ $status === 'extension' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600' }} ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium inline-block">
                                    {{ $extensionCount }}
                                </span>
                            </a>
                            @endif
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th scope="col" class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendidikan</th>
                                    
                                    <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Divisi</th>
                                    <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentor</th>

                                    {{-- Unified Date Column (20%) --}}
                                    <th scope="col" class="w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @if($status === 'active')
                                            Sisa Durasi
                                        @elseif($status === 'extension')
                                            Detail Perpanjangan
                                        @else
                                            Durasi
                                        @endif
                                    </th>
                                    
                                    <th scope="col" class="w-auto px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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

                                        {{-- Unified Date Info Cell --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($status === 'active')
                                                @php
                                                    $endDate = \Carbon\Carbon::parse($internship->end_date)->endOfDay();
                                                    $now = \Carbon\Carbon::now()->startOfDay();
                                                    $diff = $now->diff($endDate);
                                                    $isExpired = $now->gt($endDate);
                                                    $remainingDays = $now->diffInDays($endDate, false);
                                                @endphp

                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="p-2 rounded-lg {{ $remainingDays > 10 ? 'bg-blue-50 text-blue-600' : ($remainingDays > 0 ? 'bg-orange-50 text-orange-600' : 'bg-gray-100 text-gray-500') }}">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        @if(!$isExpired)
                                                            <div class="text-sm font-bold {{ $remainingDays > 10 ? 'text-gray-900' : 'text-orange-600' }}">
                                                                @if($diff->y > 0) {{ $diff->y }} Th @endif
                                                                @if($diff->m > 0) {{ $diff->m }} Bln @endif
                                                                @if($diff->d > 0) {{ $diff->d }} Hr @endif
                                                            </div>
                                                            <div class="text-xs text-gray-500 font-medium">
                                                                Selesai {{ $endDate->format('d M Y') }}
                                                            </div>
                                                        @elseif($remainingDays == 0)
                                                            <div class="text-sm font-bold text-orange-600">
                                                                Hari Terakhir
                                                            </div>
                                                            <div class="text-xs text-gray-500 font-medium">
                                                                Selesai Hari Ini
                                                            </div>
                                                        @else
                                                            <div class="text-sm font-bold text-gray-500">
                                                                Selesai
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @elseif($status === 'extension')
                                                @php
                                                    $extension = $internship->extensions->first();
                                                @endphp
                                                <div class="flex flex-col">
                                                    <div class="text-xs text-gray-500">Current: <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</span></div>
                                                    <div class="text-sm font-bold text-green-600">New: {{ \Carbon\Carbon::parse($extension->new_end_date)->format('d M Y') }}</div>
                                                    <div class="text-xs text-gray-400 mt-0.5">
                                                        +{{ \Carbon\Carbon::parse($extension->new_start_date)->diffInDays(\Carbon\Carbon::parse($extension->new_end_date)->addDay()) }} Days
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex flex-col">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        s/d {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                                    </div>
                                                </div>
                                            @endif
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
                                                    Review Pengajuan
                                                </button>
                                            @elseif($status === 'extension')
                                                 <div class="flex items-center gap-2 justify-end">
                                                    @php
                                                        $extension = $internship->extensions->first();
                                                    @endphp
                                                    <a href="{{ Storage::url($extension->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg" title="Lihat Surat">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </a>
                                                    <form id="approve-extension-form-{{ $extension->id }}" action="{{ route('admin.internships.approveExtension', $extension->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" onclick="confirmApproveExtension('{{ $extension->id }}')" class="text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg" title="Setujui">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form id="reject-extension-form-{{ $extension->id }}" action="{{ route('admin.internships.rejectExtension', $extension->id) }}" method="POST" class="flex items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" onclick="confirmRejectExtension('{{ $extension->id }}')" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg" title="Tolak">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
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
                                                    doc_url: '{{ $extensionDoc ? Storage::url($extensionDoc->file_path) : '#' }}',
                                                    university: '{{ optional($internship->student->studentProfile)->university ?? '-' }}',
                                                    major: '{{ optional($internship->student->studentProfile)->major ?? '-' }}'
                                                })" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm">
                                                    Review Extension
                                                </button>
                                            @else
                                                <a href="{{ route('admin.internships.show', $internship->id) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                                                    Detail Magang
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No data found for this status.</td>
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
    @push('scripts')
    <script>
        function confirmApproveExtension(id) {
            Swal.fire({
                title: 'Setujui Perpanjangan?',
                text: "Durasi magang akan diperbarui sesuai tanggal yang diajukan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-extension-form-' + id).submit();
                }
            })
        }

        function confirmRejectExtension(id) {
            Swal.fire({
                title: 'Tolak Perpanjangan?',
                text: "Pengajuan perpanjangan akan ditolak dan status kembali menjadi aktif.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reject-extension-form-' + id).submit();
                }
            })
        }

        function submitExtensionModalApprove() {
            const dateInput = document.getElementById('new_end_date');
            if (!dateInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Mohon isi tanggal selesai baru.',
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: "Apakah Anda yakin ingin menyetujui perpanjangan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('extension-modal-approve-form').submit();
                }
            })
        }

        function submitExtensionModalReject() {
            Swal.fire({
                title: 'Konfirmasi Penolakan',
                text: "Apakah Anda yakin ingin menolak perpanjangan ini? Dokumen akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('extension-modal-reject-form').submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
    @endpush
</x-app-layout>
