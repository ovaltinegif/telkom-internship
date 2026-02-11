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
                            <div class="relative">
                                <input id="date" type="text" name="date" value="{{ old('date') }}" required
                                    class="w-full border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm transition-all bg-white"
                                    placeholder="dd/mm/yyyy"
                                    x-data
                                    x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd/m/Y', locale: 'id', disableMobile: true })" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        {{-- Input Aktivitas (Whiteboard / Trix Editor) --}}
                        <div class="space-y-2">
                            <x-input-label for="activity" :value="__('Whiteboard Aktivitas')" class="text-slate-700 font-semibold text-lg" />
                            <p class="text-sm text-slate-500 mb-2">Tuliskan detail kegiatanmu, ide, atau catatan penting hari ini.</p>
                            
                            <input id="activity" type="hidden" name="activity" value="{{ old('activity') }}">
                            <trix-editor input="activity" 
                                class="trix-content w-full min-h-[400px] bg-white border-2 border-slate-200 focus:border-red-500 focus:ring-red-500 rounded-2xl shadow-sm transition-all p-6 text-lg text-slate-700 leading-relaxed"
                                placeholder="Mulai menulis di sini..."
                                style="min-height: 400px;">
                            </trix-editor>
                            
                            <x-input-error :messages="$errors->get('activity')" class="mt-2" />
                        </div>

                        {{-- Input Bukti --}}
                        <div>
                            <x-input-label for="evidence" :value="__('Bukti Kegiatan')" class="text-slate-700 font-semibold mb-2" />
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition-all group cursor-pointer relative overflow-hidden" onclick="document.getElementById('evidence').click()">
                                
                                {{-- Default Content --}}
                                <div id="dropzone_content" class="space-y-1 text-center transition-opacity duration-300">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-red-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="evidence" class="relative cursor-pointer bg-transparent rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="evidence" name="evidence" type="file" class="sr-only" onchange="previewFile(this)" accept="image/*,.pdf">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG, PDF up to 5MB</p>
                                </div>

                                {{-- Image Preview Container --}}
                                <div id="preview_container" class="hidden absolute inset-0 flex items-center justify-center bg-slate-50">
                                    <img id="preview_image" src="" alt="Preview" class="max-h-full max-w-full object-contain p-2">
                                    <div class="absolute bottom-2 right-2 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-md shadow-sm">
                                        <p id="fileName" class="text-xs text-slate-700 font-medium truncate max-w-[150px]"></p>
                                    </div>
                                    <button type="button" class="absolute top-2 right-2 bg-red-100 text-red-600 p-1 rounded-full hover:bg-red-200 transition" 
                                        onclick="event.stopPropagation(); document.getElementById('evidence').value = ''; document.getElementById('preview_container').classList.add('hidden'); document.getElementById('dropzone_content').classList.remove('hidden');">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                        </svg>
                                    </button>
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
    
    <style>
        /* Custom Styling for Trix "Whiteboard" Feel */
        trix-editor {
            border-color: #e2e8f0; /* slate-200 */
            border-width: 1px;
            border-radius: 0 0 1rem 1rem; /* rounded-b-2xl */
            padding: 2rem;
            min-height: 500px; /* Increased height */
            background-color: #ffffff;
            font-size: 1.125rem; /* text-lg */
            line-height: 1.8;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        trix-editor:focus {
            border-color: #cbd5e1; /* slate-300 */
            outline: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }
        
        /* Toolbar Customization */
        trix-toolbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8fafc; /* slate-50 */
            border: 1px solid #e2e8f0;
            border-bottom: none;
            border-radius: 1rem 1rem 0 0; /* rounded-t-2xl */
            padding: 0.75rem;
        }
        
        trix-toolbar .trix-button-group {
            margin-bottom: 0;
            border: 1px solid #cbd5e1;
            background-color: white;
            border-radius: 0.5rem;
        }

        trix-toolbar .trix-button {
            border-bottom: none;
        }

        trix-toolbar .trix-button:hover {
            background-color: #f1f5f9;
        }

        trix-toolbar .trix-button--active {
            background-color: #e2e8f0;
            color: #ef4444; /* red-500 */
        }
        
        /* Hide file upload button completely */
        .trix-button-group--file-tools {
            display: none !important;
        }
        
        /* Placeholder styling */
        trix-editor:empty:before {
            color: #94a3b8; /* slate-400 */
        }

        /* Typography inside editor */
        trix-editor h1 { font-size: 1.5em; font-weight: 700; margin-bottom: 0.5em; line-height: 1.2; color: #1e293b; }
        trix-editor blockquote { border-left: 4px solid #cbd5e1; padding-left: 1rem; color: #64748b; font-style: italic; }
        trix-editor code { background-color: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-family: monospace; font-size: 0.9em; color: #ef4444; }
        trix-editor pre { background-color: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; }
        trix-editor ul, trix-editor ol { padding-left: 1.5rem; margin-bottom: 1rem; }
        trix-editor li { margin-bottom: 0.25rem; }
    </style>

    <script>
        // Disable file attachment handling explicitly with SweetAlert
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Upload Gambar?',
                text: "Untuk saat ini, silakan gunakan kolom 'Bukti Kegiatan' di bawah untuk mengupload foto atau dokumen.",
                icon: 'info',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Baik, saya mengerti'
            });
        });

        function previewFile(input) {
            const file = input.files[0];
            const fileName = document.getElementById('fileName');
            const previewImage = document.getElementById('preview_image');
            const previewContainer = document.getElementById('preview_container');
            const dropzoneContent = document.getElementById('dropzone_content');

            if (file) {
                fileName.textContent = file.name;
                fileName.classList.remove('hidden');

                // Image Preview Logic
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                         previewImage.src = e.target.result;
                         previewContainer.classList.remove('hidden');
                         dropzoneContent.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    // For PDF/Docs, just show name
                    previewContainer.classList.add('hidden'); 
                    dropzoneContent.classList.remove('hidden');
                }
            } else {
                fileName.classList.add('hidden');
                previewContainer.classList.add('hidden');
                dropzoneContent.classList.remove('hidden');
            }
        }

        function confirmSaveLogbook() {
            const form = document.getElementById('logbookForm');
            // Manual check for Trix content
            const activityInput = document.getElementById('activity');
            // Trix stores HTML in value, but we check if it's empty or just whitespace/tags
            const rawContent = activityInput.value;
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = rawContent;
            const textContent = tempDiv.textContent || tempDiv.innerText || "";
            
            if (textContent.trim().length === 0 && !rawContent.includes('<img')) {
                // If text is empty and no images (though image upload disabled), block it
                // Allow if there's some content
                 Swal.fire({
                    title: 'Whiteboard Kosong!',
                    text: 'Ceritakan aktivitasmu hari ini di whiteboard. Jangan biarkan kosong ya!',
                    icon: 'warning',
                    confirmButtonColor: '#ef4444'
                });
                return;
            }

            if (form.reportValidity()) {
                Swal.fire({
                    title: 'Simpan Logbook?',
                    text: "Pastikan data sudah benar sebelum disimpan.",
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
                            text: 'Mohon tunggu sebentar',
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