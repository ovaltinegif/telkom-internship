<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Activity Log') }}
        </h2>
        <p class="text-slate-500 text-sm">Riwayat lengkap aktivitas magang kamu</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Semua Aktivitas</h3>
                        <a href="{{ route('logbooks.create') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-red-500/30 transition-all">
                            + Isi Logbook
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th class="px-6 py-4 font-semibold">Aktivitas</th>
                                    <th class="px-6 py-4 font-semibold">Bukti</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold">Catatan Mentor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($logbooks as $logbook)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-slate-900">
                                            {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 max-w-lg" title="{{ $logbook->activity }}">
                                            {{ Str::limit($logbook->activity, 100) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($logbook->evidence)
                                                <a href="{{ Storage::url($logbook->evidence) }}" target="_blank" class="text-red-600 hover:underline">Lihat</a>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($logbook->status == 'approved')
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">Disetujui</span>
                                            @elseif($logbook->status == 'rejected')
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">Ditolak</span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 italic text-xs">
                                            {{ $logbook->mentor_note ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                            Belum ada aktivitas yang tercatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logbooks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
