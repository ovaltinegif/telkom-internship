<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Isi Logbook Harian') }}
            </h2>
            <p class="text-slate-500 text-sm">Ceritakan aktivitas magangmu hari ini</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-8">
                    
                    <form action="{{ route('logbooks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="logbookForm">
                        @csrf
                        
                        {{-- Input Tanggal --}}
                        <div>
                            <x-input-label for="date" :value="__('Tanggal Kegiatan')" class="text-slate-700 font-semibold mb-2" />
                            <input id="date" type="date" name="date" value="{{ old('date') }}" required
                                class="w-full border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm transition-all" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        {{-- Input Aktivitas --}}
                        <div>
                            <x-input-label for="activity" :value="__('Deskripsi Kegiatan')" class="text-slate-700 font-semibold mb-2" />
                            <textarea id="activity" name="activity" rows="5" required
                                class="w-full border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm transition-all placeholder:text-slate-400"
                                placeholder="Jelaskan secara detail apa yang kamu pelajari atau kerjakan...">{{ old('activity') }}</textarea>
                            <x-input-error :messages="$errors->get('activity')" class="mt-2" />
                        </div>

                        {{-- Input Bukti --}}
                        <div>
                            <x-input-label for="evidence" :value="__('Bukti Kegiatan')" class="text-slate-700 font-semibold mb-2" />
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition-colors group cursor-pointer" onclick="document.getElementById('evidence').click()">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-red-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="evidence" class="relative cursor-pointer bg-transparent rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="evidence" name="evidence" type="file" class="sr-only" onchange="previewFile(this)">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG, PDF up to 5MB</p>
                                    <p id="fileName" class="text-sm text-emerald-600 font-semibold mt-2 hidden"></p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                             <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl text-slate-600 font-semibold hover:bg-slate-100 transition-colors">
                                Batal
                            </a>
                            <button type="button" onclick="confirmSaveLogbook()" 
                                class="bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-red-500/30 hover:shadow-red-500/40 hover:scale-[1.02] transition-all duration-300">
                                Simpan Logbook
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
    <script>
        function previewFile(input) {
            const file = input.files[0];
            const fileName = document.getElementById('fileName');
            if (file) {
                fileName.textContent = 'Selected: ' + file.name;
                fileName.classList.remove('hidden');
            } else {
                fileName.classList.add('hidden');
            }
        }

        function confirmSaveLogbook() {
            const form = document.getElementById('logbookForm');
            if (form.reportValidity()) {
                Swal.fire({
                    title: 'Simpan Logbook?',
                    text: "Pastikan data sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#ef4444', // Red 500
                    cancelButtonColor: '#64748b', // Slate 500
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                        form.submit();
                    }
                });
            }
        }
    </script>
</x-app-layout>