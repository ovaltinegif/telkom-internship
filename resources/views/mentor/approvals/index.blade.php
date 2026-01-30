<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Menunggu Persetujuan') }}
        </h2>
        <p class="text-slate-500 text-sm">Validasi aktivitas harian mahasiswa bimbingan Anda</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-6 text-gray-900">
                    
                    @if($pendingLogbooks->isEmpty())
                        <div class="text-center py-16 flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-emerald-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Semua Beres!</h3>
                            <p class="text-slate-500">Tidak ada logbook yang perlu disetujui saat ini.</p>
                            <a href="{{ route('mentor.dashboard') }}" class="mt-6 text-red-600 hover:text-red-700 font-semibold hover:underline">
                                &larr; Kembali ke Dashboard
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase font-semibold text-xs tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4">Mahasiswa</th>
                                        <th class="px-6 py-4">Tanggal & Waktu</th>
                                        <th class="px-6 py-4">Aktivitas</th>
                                        <th class="px-6 py-4">Bukti</th>
                                        <th class="px-6 py-4 text-center">Aksi Cepat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($pendingLogbooks as $logbook)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-800">{{ $logbook->internship->student->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $logbook->internship->division->name ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                 <div class="text-slate-700 max-w-md line-clamp-2" title="{{ $logbook->activity }}">
                                                    {{ $logbook->activity }}
                                                 </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($logbook->evidence)
                                                    <a href="{{ Storage::url($logbook->evidence) }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 hover:text-red-700 font-medium hover:underline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd" d="M4.5 2A2.5 2.5 0 002 4.5v2.5h1.056c.88-1.45 2.057-2.73 3.444-3.5h-2zM15.5 2h-2c1.387.77 2.564 2.05 3.444 3.5H18V4.5A2.5 2.5 0 0015.5 2z" clip-rule="evenodd" />
                                                            <path fill-rule="evenodd" d="M2.203 9.488a10.05 10.05 0 012.333-3.076 9.998 9.998 0 001.372 2.766L4.76 10.37a.75.75 0 001.06 1.06L7.96 9.293a10.021 10.021 0 003.54 1.207v1.75h-2a.75.75 0 000 1.5h2v3.75a.75.75 0 001.5 0v-3.75h2a.75.75 0 000-1.5h-2v-1.75a10.021 10.021 0 003.54-1.207l2.14 2.138a.75.75 0 001.06-1.06l-1.147-1.194a9.998 9.998 0 001.372-2.766 10.05 10.05 0 012.332 3.076.75.75 0 101.272-.816A11.547 11.547 0 002.93 8.672a.75.75 0 101.273.816z" clip-rule="evenodd" />
                                                        </svg>
                                                        Lihat
                                                    </a>
                                                @else
                                                    <span class="text-slate-400 text-xs italic">Tidak ada</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    {{-- Approve --}}
                                                    <form action="{{ route('mentor.logbook.update', $logbook->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-sm">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    
                                                    {{-- Reject / Detail --}}
                                                    <a href="{{ route('mentor.students.show', $logbook->internship->student->id) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors">
                                                        Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $pendingLogbooks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
