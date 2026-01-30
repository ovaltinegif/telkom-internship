<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dokumen') }}
        </h2>
        <p class="text-slate-500 text-sm">Arsip dokumen dan laporan magang</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 text-center py-16">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Belum Ada Dokumen</h3>
                        <p class="text-slate-500 max-w-sm mx-auto">Fitur dokumen akan segera tersedia. Kamu akan bisa mengunduh laporan dan sertifikat di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
