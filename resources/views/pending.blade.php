<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Status Card --}}
            @if(isset($internship) && $internship->status == 'onboarding')
                @php
                    $suratJawaban = $internship->documents->where('type', 'surat_jawaban')->first();
                    $paktaTemplate = $internship->documents->where('type', 'pakta_integritas')->first();
                    $signedPact = $internship->documents->where('type', 'pakta_integritas_signed')->first();
                @endphp

                <div class="bg-gradient-to-br from-emerald-50 to-white border border-emerald-200 rounded-2xl p-8 shadow-sm text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-100/50 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-emerald-900 mb-2">Selamat Datang di Telkom Internship!</h3>
                        <p class="text-emerald-700 max-w-lg mx-auto mb-6">
                            Pengajuan magang Anda telah diterima (Onboarding). Silakan ikuti langkah-langkah berikut untuk aktivasi akun sepenuhnya.
                        </p>

                        @if($signedPact)
                            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-6 py-4 rounded-xl mb-6 max-w-lg w-full">
                                <div class="font-bold flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Menunggu Verifikasi Admin
                                </div>
                                <p class="text-sm mt-2">Anda telah mengunggah Pakta Integritas. Admin sedang memverifikasi dokumen Anda. Mohon tunggu notifikasi selanjutnya.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl text-left">
                                {{-- Step 1: Download Documents --}}
                                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                        <span class="bg-emerald-100 text-emerald-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">1</span>
                                        Unduh Dokumen
                                    </h4>
                                    <div class="space-y-3">
                                        @if($suratJawaban)
                                            <a href="{{ Storage::url($suratJawaban->file_path) }}" target="_blank" class="flex items-center p-3 bg-gray-50 hover:bg-emerald-50 rounded-lg border border-gray-200 hover:border-emerald-300 transition-all group">
                                                <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                                <div>
                                                    <p class="font-semibold text-gray-700 group-hover:text-emerald-700">Surat Jawaban</p>
                                                    <p class="text-xs text-gray-500">Penerimaan Magang</p>
                                                </div>
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-500 italic">Surat Jawaban belum tersedia.</p>
                                        @endif

                                        @if($paktaTemplate)
                                            @php
                                                $isUrl = Str::startsWith($paktaTemplate->file_path, ['http://', 'https://']);
                                                $paktaLink = $isUrl ? $paktaTemplate->file_path : Storage::url($paktaTemplate->file_path);
                                            @endphp
                                            <a href="{{ $paktaLink }}" target="_blank" class="flex items-center p-3 bg-gray-50 hover:bg-emerald-50 rounded-lg border border-gray-200 hover:border-emerald-300 transition-all group">
                                                <svg class="w-8 h-8 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                                <div>
                                                    <p class="font-semibold text-gray-700 group-hover:text-emerald-700">Template Pakta Integritas</p>
                                                    <p class="text-xs text-gray-500">{{ $isUrl ? 'Buka Link Google Docs' : 'Unduh & Tandangani' }}</p>
                                                </div>
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-500 italic">Template Pakta Integritas belum tersedia.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Step 2: Upload Signed Pact --}}
                                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                        <span class="bg-emerald-100 text-emerald-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">2</span>
                                        Upload Pakta Integritas
                                    </h4>
                                    
                                    <form action="{{ route('documents.storePaktaIntegritas') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm text-gray-600 mb-1">Unggah file yang sudah ditandatangani:</label>
                                            <input type="file" name="file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                            <p class="text-xs text-gray-400 mt-1">Format PDF, Max 5MB</p>
                                        </div>
                                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                                            Kirim Dokumen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif(isset($internship) && $internship->status == 'rejected')
                 <div class="bg-red-50 border-l-4 border-red-400 p-6 shadow-sm rounded-r-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800">Pengajuan Ditolak</h3>
                            <div class="mt-2 text-sm text-red-700 space-y-2">
                                <p class="text-justify">Terima kasih atas ketertarikan saudara pada program magang PT Telkom Indonesia. Kami sampaikan bahwa dengan mempertimbangkan ketersediaan kuota, dapat kami sampaikan bahwa kami belum dapat memproses permohonan magang Saudara dikarenakan kuota magang pada lokasi yang diminati saat ini telah terpenuhi.</p>
                                @if($internship->response_letter)
                                    <a href="{{ Storage::url($internship->response_letter) }}" target="_blank" class="text-red-900 font-semibold underline hover:text-red-950">
                                        Lihat Surat Penolakan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- Default Pending/No Data --}}
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 shadow-sm rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            @if(!isset($internship))
                                <h3 class="text-sm font-medium text-yellow-800">Data Magang Belum Tersedia</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Akun Anda belum terdaftar dalam program magang aktif. Silakan hubungi Administrator.</p>
                                </div>
                            @elseif($internship->status == 'pending')
                                <h3 class="text-sm font-medium text-yellow-800">Menunggu Verifikasi</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Pengajuan magang Anda telah diterima dan sedang dalam proses verifikasi oleh Admin.</p>
                                    <p class="mt-1">Mohon cek email Anda secara berkala untuk info selanjutnya.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="mt-6 text-center">
                 <p class="text-gray-500 text-sm">Butuh bantuan?</p>
                 <a href="{{ route('help.index') }}" class="mt-1 inline-block text-indigo-600 hover:text-indigo-900 underline text-sm">
                     Hubungi Pusat Bantuan
                 </a>
            </div>
        </div>
    </div>
</x-app-layout>