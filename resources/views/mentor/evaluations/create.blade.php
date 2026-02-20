<x-app-layout>
    {{-- 1. LOAD LIBRARY SWEETALERT --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Nilai Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Form Penilaian Mahasiswa</h3>
                        <p class="text-slate-500">Silakan berikan penilaian objektif untuk mahasiswa berikut:</p>
                        
                        <div class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-full bg-slate-200 flex items-center justify-center text-xl font-bold text-slate-500">
                                    {{ substr($internship->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $internship->student->name }}</h4>
                                    <p class="text-sm text-slate-500">{{ $internship->division->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="evaluation-form" action="{{ route('mentor.evaluations.store', $internship->id) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Discipline Score -->
                            <div>
                                <label for="discipline_score" class="block text-sm font-medium text-slate-700 mb-1">Nilai Kedisiplinan (0-100)</label>
                                <input type="number" name="discipline_score" id="discipline_score" min="0" max="100" 
                                       class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" required>
                            </div>

                            <!-- Technical Score -->
                            <div>
                                <label for="technical_score" class="block text-sm font-medium text-slate-700 mb-1">Nilai Teknis (0-100)</label>
                                <input type="number" name="technical_score" id="technical_score" min="0" max="100" 
                                       class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" required>
                            </div>

                            <!-- Soft Skill Score -->
                            <div>
                                <label for="soft_skill_score" class="block text-sm font-medium text-slate-700 mb-1">Nilai Soft Skill (0-100)</label>
                                <input type="number" name="soft_skill_score" id="soft_skill_score" min="0" max="100" 
                                       class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" required>
                            </div>
                        </div>

                        <!-- Feedback -->
                        <div>
                            <label for="feedback" class="block text-sm font-medium text-slate-700 mb-1">Catatan / Feedback Mentor</label>
                            <textarea name="feedback" id="feedback" rows="4" 
                                      class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                                      placeholder="Berikan masukan untuk pengembangan mahasiswa..."></textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="button" id="btn-save" class="px-6 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition shadow-lg shadow-red-200">
                                Simpan Penilaian
                            </button>
                            <a href="{{ route('mentor.students.show', $internship->id) }}" id="btn-cancel" class="px-6 py-2 bg-white text-slate-600 font-semibold rounded-lg border border-slate-200 hover:bg-slate-50 transition">
                                Batal
                            </a>
                        </div>
                    </form>
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
                    confirmButtonColor: '#e11d48', // Red 600
                    cancelButtonColor: '#64748b',  // Slate 500
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Cek Lagi'
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
                    confirmButtonColor: '#64748b', // Slate 500 (Primary action is to leave)
                    cancelButtonColor: '#e11d48',  // Red 600 (Cancel the leaving)
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Lanjut Mengisi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = redirectUrl;
                    }
                });
            });
        });
    </script>
</x-app-layout>
