<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="{{ isset($internship) && $internship->status == 'rejected' ? 'bg-red-50 border-red-400' : 'bg-yellow-50 border-yellow-400' }} border-l-4 p-4 shadow-sm rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @if(isset($internship) && $internship->status == 'rejected')
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        @endif
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
                        @elseif($internship->status == 'onboarding')
                            <h3 class="text-sm font-medium text-yellow-800">Proses Onboarding</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Selamat! Anda telah diterima. Saat ini status Anda sedang dalam proses onboarding.</p>
                                <p>Silakan tunggu instruksi selanjutnya dari Admin/Mentor.</p>
                            </div>
                        @elseif($internship->status == 'rejected')
                            <h3 class="text-sm font-medium text-red-800">Pengajuan Ditolak</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Mohon maaf, pengajuan magang Anda belum dapat diterima saat ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                 <p class="text-gray-500 text-sm">Sambil menunggu, Anda dapat melengkapi profil Anda.</p>
                 <a href="{{ route('profile.edit') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-900 underline">
                     Lengkapi Profil
                 </a>
            </div>
        </div>
    </div>
</x-app-layout>