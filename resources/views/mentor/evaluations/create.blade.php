<x-app-layout>
    {{-- 1. LOAD LIBRARY SWEETALERT --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight transition-colors">
                    {{ __('Input Nilai Magang') }}
                </h2>
                <p class="text-slate-500 dark:text-slate-500 text-[10px] font-black uppercase tracking-widest mt-1 transition-colors">Berikan penilaian akhir untuk mahasiswa</p>
            </div>
             <a href="{{ route('mentor.students.show', $internship->id) }}" class="inline-flex items-center px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition-all duration-200">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none rounded-[2.5rem] border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-10">
                    <div class="mb-10 text-center md:text-left">
                        <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight transition-colors">Form Penilaian Intern</h3>
                        <p class="text-slate-500 dark:text-slate-500 text-xs font-black uppercase tracking-widest mt-1 transition-colors">Berikan skor objektif berdasarkan kinerja selama magang</p>
                        
                        <div class="mt-8 p-8 bg-slate-50/50 dark:bg-slate-950/50 rounded-3xl border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center gap-6 transition-colors group">
                            <div class="h-20 w-20 rounded-[1.5rem] bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center text-4xl font-black text-white shadow-xl shadow-red-500/20 group-hover:scale-110 transition-transform">
                                {{ substr($internship->student->name, 0, 1) }}
                            </div>
                            <div class="text-center md:text-left">
                                <h4 class="font-black text-xl text-slate-800 dark:text-slate-100 tracking-tight transition-colors">{{ $internship->student->name }}</h4>
                                <div class="flex items-center justify-center md:justify-start gap-2 mt-1">
                                    <span class="px-3 py-1 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-red-100 dark:border-red-500/20">{{ $internship->division->name }}</span>
                                    <span class="text-slate-400 dark:text-slate-600 font-black text-[10px] tracking-widest">• {{ $internship->student->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="evaluation-form" action="{{ route('mentor.evaluations.store', $internship->id) }}" method="POST" class="space-y-10">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <!-- Discipline Score -->
                            <div class="space-y-4">
                                <label for="discipline_score" class="flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest transition-colors">
                                    <span class="w-1.5 h-1.5 bg-red-600 dark:bg-red-500 rounded-full"></span>
                                    Kedisiplinan & Etika
                                </label>
                                <input type="number" name="discipline_score" id="discipline_score" min="0" max="100" 
                                       class="w-full px-6 py-4 rounded-2xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 focus:border-red-500 focus:ring-red-500 font-black text-2xl transition-all shadow-inner" 
                                       placeholder="0-100" required>
                                <p class="text-[9px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-wider pl-1">Kehadiran, attitude, dan etika kerja</p>
                            </div>

                            <!-- Technical Score -->
                            <div class="space-y-4">
                                <label for="technical_score" class="flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest transition-colors">
                                     <span class="w-1.5 h-1.5 bg-red-600 dark:bg-red-500 rounded-full"></span>
                                    Kemampuan Teknis
                                </label>
                                <input type="number" name="technical_score" id="technical_score" min="0" max="100" 
                                       class="w-full px-6 py-4 rounded-2xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 focus:border-red-500 focus:ring-red-500 font-black text-2xl transition-all shadow-inner" 
                                       placeholder="0-100" required>
                                <p class="text-[9px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-wider pl-1">Hard skills dan kualitas hasil kerja</p>
                            </div>

                            <!-- Soft Skill Score -->
                            <div class="space-y-4">
                                <label for="soft_skill_score" class="flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest transition-colors">
                                     <span class="w-1.5 h-1.5 bg-red-600 dark:bg-red-500 rounded-full"></span>
                                    Kerjasama & Soft Skill
                                </label>
                                <input type="number" name="soft_skill_score" id="soft_skill_score" min="0" max="100" 
                                       class="w-full px-6 py-4 rounded-2xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 focus:border-red-500 focus:ring-red-500 font-black text-2xl transition-all shadow-inner" 
                                       placeholder="0-100" required>
                                <p class="text-[9px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-wider pl-1">Komunikasi dan kolaborasi tim</p>
                            </div>
                        </div>

                        <!-- Feedback -->
                        <div class="space-y-4">
                            <label for="feedback" class="flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest transition-colors">
                                 <span class="w-1.5 h-1.5 bg-red-600 dark:bg-red-500 rounded-full"></span>
                                Catatan / Feedback Mentor
                            </label>
                            <textarea name="feedback" id="feedback" rows="4" 
                                      class="w-full px-6 py-5 rounded-3xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 focus:border-red-500 focus:ring-red-500 font-bold leading-relaxed transition-all shadow-inner trix-content prose prose-slate dark:prose-invert max-w-none"
                                      placeholder="Berikan masukan konstruktif untuk pengembangan mahasiswa..."></textarea>
                        </div>

                        <div class="flex flex-col md:flex-row items-center gap-4 pt-6">
                            <button type="button" id="btn-save" class="w-full md:w-auto px-12 py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black rounded-2xl shadow-xl shadow-slate-900/20 dark:shadow-none hover:bg-red-600 dark:hover:bg-red-50 hover:text-white dark:hover:text-red-600 text-sm uppercase tracking-widest transition-all hover:scale-105 active:scale-95">
                                Simpan Penilaian
                            </button>
                            <a href="{{ route('mentor.students.show', $internship->id) }}" id="btn-cancel" class="w-full md:w-auto px-12 py-4 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-black rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-sm uppercase tracking-widest transition-all active:scale-95 text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Tombol Simpan
            const btnSave = document.getElementById('btn-save');
            const form = document.getElementById('evaluation-form');

            btnSave.addEventListener('click', function() {
                // Manual Validation Check
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                Swal.fire({
                    title: 'Simpan Penilaian?',
                    text: "Pastikan nilai yang dimasukkan sudah benar. Data tidak bisa diubah setelah disimpan.",
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Cek Lagi',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                        cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // 2. Tombol Batal
            const btnCancel = document.getElementById('btn-cancel');

            btnCancel.addEventListener('click', function(e) {
                e.preventDefault(); // Stop default link behavior
                const redirectUrl = this.href;

                Swal.fire({
                    title: 'Batalkan Penilaian?',
                    text: "Perubahan yang belum disimpan akan hilang.",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Lanjut Mengisi',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                        cancelButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = redirectUrl;
                    }
                });
            });
        });
    </script>
</x-app-layout>
