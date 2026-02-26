<div x-data="{ open: false, internshipId: null, studentName: '', documents: [] }"
     @open-review-modal.window="open = true; 
                                internshipId = $event.detail.id; 
                                studentName = $event.detail.name; 
                                documents = $event.detail.docs;
                                if ($event.detail.photo) {
                                    documents.unshift({ id: 'photo', name: 'Foto Diri Terbaru', file_path: $event.detail.photo });
                                }"
     x-show="open" 
     style="display: none;"
     class="fixed inset-0 z-[1000] overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <!-- Background backdrop -->
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="open = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full font-sans border border-transparent dark:border-slate-800">
            
            <div class="bg-white dark:bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-6 transition-colors duration-300">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-6 transition-colors" id="modal-title">
                                Review Aplikasi: <span class="text-red-600 dark:text-red-400" x-text="studentName"></span>
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3 transition-colors">Dokumen Intern:</p>
                                    <ul class="border border-slate-200 dark:border-slate-800 rounded-xl divide-y divide-slate-100 dark:divide-slate-800 max-h-48 overflow-y-auto bg-slate-50/50 dark:bg-slate-950/30 transition-colors">
                                        <template x-for="doc in documents" :key="doc.id">
                                            <li class="pl-4 pr-5 py-4 flex items-center justify-between text-sm hover:bg-white dark:hover:bg-slate-800 transition-colors">
                                                <div class="w-0 flex-1 flex items-center">
                                                    <div class="h-8 w-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center mr-3 transition-colors">
                                                        <svg class="h-4 w-4 text-slate-500 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <span class="font-bold text-slate-700 dark:text-slate-200 truncate transition-colors" x-text="doc.name"></span>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <a :href="'/storage/' + doc.file_path" 
                                                       target="_blank" 
                                                       rel="noopener noreferrer"
                                                       class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-bold hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-all">
                                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        Lihat
                                                    </a>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                                <div class="border-t border-slate-100 dark:border-slate-800 pt-6 transition-colors">
                                    <!-- Approve Form -->
                                    <form id="approve-form" :action="'{{ route('admin.internships.approve', 'PLACEHOLDER_ID') }}'.replace('PLACEHOLDER_ID', internshipId)" method="POST" class="space-y-6">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <div class="p-4 bg-emerald-50 dark:bg-emerald-500/5 rounded-xl border border-emerald-100 dark:border-emerald-500/20 transition-colors">
                                            <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400">
                                                <svg class="inline-block w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Persetujuan akan otomatis mengirim link <strong>Template Pakta Integritas</strong> kepada mahasiswa.
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            {{-- Division Selection --}}
                                            <div class="space-y-1.5">
                                                <label for="division_id_review" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Pilih Divisi</label>
                                                <select name="division_id" id="division_id_review" required class="block w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 sm:text-sm font-bold transition-all">
                                                    <option value="">-- Pilih Divisi --</option>
                                                    @if(isset($divisions))
                                                        @foreach($divisions as $division)
                                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            {{-- Mentor Selection --}}
                                            <div class="space-y-1.5">
                                                <label for="mentor_id_review" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Pilih Mentor</label>
                                                <select name="mentor_id" id="mentor_id_review" required class="block w-full px-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-red-500 focus:ring-red-500 sm:text-sm font-bold transition-all">
                                                    <option value="">-- Pilih Mentor --</option>
                                                    @if(isset($mentors))
                                                        @foreach($mentors as $mentor)
                                                            @php
                                                                $quota = $mentor->mentorProfile->quota ?? 5;
                                                                $active = $mentor->activeInternships()->count();
                                                                $isFull = $active >= $quota;
                                                            @endphp
                                                            <option value="{{ $mentor->id }}" {{ $isFull ? 'disabled' : '' }} class="{{ $isFull ? 'text-slate-400 dark:text-slate-600 bg-slate-50 dark:bg-slate-900' : '' }}">
                                                                {{ $mentor->name }} ({{ $active }}/{{ $quota }}) {{ $isFull ? '- Penuh' : '' }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <!-- Reject Form (Hidden) -->
                                    <form id="reject-form" :action="'{{ route('admin.internships.reject', 'PLACEHOLDER_ID') }}'.replace('PLACEHOLDER_ID', internshipId)" method="POST" class="hidden">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-950/50 px-6 py-4 sm:px-8 flex flex-col-reverse sm:flex-row justify-between items-center gap-4 transition-colors">
                     <!-- Reject Button (Left) -->
                    <button type="button" @click="confirmReject(internshipId)"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-xs font-bold text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50 hover:bg-red-50 dark:hover:bg-red-900/10 transition-all active:scale-95">
                        Reject Application
                    </button>

                    <!-- Approve & Cancel (Right) -->
                    <div class="flex flex-row-reverse w-full sm:w-auto gap-3">
                         <button type="submit" form="approve-form"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-200 dark:shadow-emerald-900/20 transition-all active:scale-95">
                            Approve
                        </button>
                        <button type="button" @click="open = false" 
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                            Cancel
                        </button>
                    </div>
                </div>
                
                <script>
                    function confirmReject(id) {
                        Swal.fire({
                            title: 'Tolak Pengajuan?',
                            text: "Apakah Anda yakin ingin MENOLAK pengajuan ini? Notifikasi akan dikirim ke mahasiswa.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Tolak!',
                            cancelButtonText: 'Batal',
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
                                document.getElementById('reject-form').submit();
                            }
                        })
                    }
                </script>
        </div>
    </div>
</div>
