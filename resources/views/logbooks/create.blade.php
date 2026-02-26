<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
                {{ __('Isi Logbook Harian') }}
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Ceritakan aktivitas magangmu hari ini</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-8">
                    
                    <form action="{{ route('logbooks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="logbookForm">
                        @csrf
                        
                        {{-- Input Tanggal --}}
                        <div>
                            <x-input-label for="date" :value="__('Tanggal Kegiatan')" class="text-slate-700 dark:text-slate-300 font-semibold mb-2" />
                            <div class="relative">
                                <input id="date" type="text" name="date" value="{{ old('date') }}" required
                                    class="w-full border-slate-300 dark:border-slate-700 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm transition-all bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200"
                                    placeholder="dd/mm/yyyy"
                                    x-data
                                    x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd/m/Y', locale: 'id', disableMobile: true })" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                        
                        {{-- Section Judul & Aktivitas (Grouped) --}}
                        <div class="space-y-4">
                            <div class="flex items-center justify-between px-1">
                                <x-input-label :value="__('Detail Aktivitas Logbook')" class="text-slate-700 dark:text-slate-200 font-bold text-lg" />
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Wajib Diisi</span>
                            </div>
                            
                            <div class="bg-white dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl focus-within:border-red-500/30 focus-within:shadow-red-500/10 transition-all duration-500 group/editor">
                                {{-- Area Input Judul --}}
                                <div class="px-8 pt-8 pb-4 border-b border-slate-50 dark:border-slate-800/50 bg-slate-50/30 dark:bg-slate-950/20">
                                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                                        class="w-full border-0 focus:ring-0 p-0 text-2xl font-black text-slate-800 dark:text-slate-100 placeholder:text-slate-300 dark:placeholder:text-slate-700 bg-transparent transition-all"
                                        placeholder="Tulis Judul Aktivitas..." />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                {{-- Area Trix Editor --}}
                                <div class="p-2 relative">
                                    {{-- Subtle Glow for Dark Mode --}}
                                    <div class="absolute inset-0 bg-red-500/5 dark:bg-red-500/2 rounded-3xl blur-3xl opacity-0 group-focus-within/editor:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                                    
                                    <input id="activity" type="hidden" name="activity" value="{{ old('activity') }}">
                                    <trix-editor input="activity" 
                                        class="trix-content w-full min-h-[400px] border-0 focus:ring-0 px-6 py-4 text-slate-700 dark:text-slate-200 leading-relaxed text-lg relative z-10"
                                        placeholder="Ceritakan detail kegiatanmu, tantangan, atau hasil pekerjaan hari ini..."
                                        style="min-height: 400px;">
                                    </trix-editor>
                                    <div class="px-6 pb-4 relative z-10">
                                        <x-input-error :messages="$errors->get('activity')" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Input Bukti --}}
                        <div>
                            <x-input-label for="evidence" :value="__('Bukti Kegiatan')" class="text-slate-700 dark:text-slate-300 font-semibold mb-3 ml-1" />
                            <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-slate-200 dark:border-slate-800 border-dashed rounded-[2rem] hover:bg-slate-50 dark:hover:bg-slate-800/20 hover:border-red-500/50 dark:hover:border-red-500/30 transition-all group cursor-pointer relative overflow-hidden shadow-inner bg-slate-50/50 dark:bg-slate-900/50" onclick="document.getElementById('evidence').click()">
                                
                                {{-- Default Content --}}
                                <div id="dropzone_content" class="space-y-3 text-center transition-all duration-300 group-hover:scale-105">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-600 group-hover:text-red-500 dark:group-hover:text-red-500 group-hover:bg-red-50 dark:group-hover:bg-red-500/10 transition-all shadow-sm">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col text-sm text-slate-600 dark:text-slate-400">
                                        <p class="font-bold text-slate-800 dark:text-slate-200">Klik atau seret file ke sini</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-widest font-black">PNG, JPG, PDF up to 5MB</p>
                                    </div>
                                    <input id="evidence" name="evidence" type="file" class="sr-only" onchange="previewFile(this)" accept="image/*,.pdf">
                                </div>

                                {{-- Image Preview Container --}}
                                <div id="preview_container" class="hidden absolute inset-0 flex items-center justify-center bg-slate-100 dark:bg-slate-950">
                                    <img id="preview_image" src="" alt="Preview" class="max-h-full max-w-full object-contain p-4 transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute bottom-4 left-4 right-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-800/50 flex items-center justify-between">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <p id="fileName" class="text-xs text-slate-700 dark:text-slate-300 font-bold truncate"></p>
                                        </div>
                                        <button type="button" class="ml-2 bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 p-1.5 rounded-lg hover:bg-red-200 dark:hover:bg-red-500/30 transition-all" 
                                            onclick="event.stopPropagation(); document.getElementById('evidence').value = ''; document.getElementById('preview_container').classList.add('hidden'); document.getElementById('dropzone_content').classList.remove('hidden');">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                             <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl text-slate-600 dark:text-slate-400 font-semibold hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
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
            transition: all 0.3s ease;
        }
        
        /* Dark Mode Trix Editor */
        .dark trix-editor {
            background-color: #020617; /* slate-950 for premium feel */
            border-color: #1e293b; /* slate-800 */
            color: #e2e8f0; /* slate-200 */
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
        }

        trix-editor:focus {
            outline: none;
        }
        
        /* Toolbar Customization */
        trix-toolbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: #f8fafc; /* slate-50 */
            border: 1px solid #e2e8f0;
            border-bottom: none;
            border-radius: 2rem 2rem 0 0;
            padding: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        .dark trix-toolbar {
            background-color: #0f172a; /* slate-900 */
            border-color: #1e293b; /* slate-800 */
            box-shadow: 0 4px 12px -2px rgba(0,0,0,0.5);
        }
        
        trix-toolbar .trix-button-group {
            margin-bottom: 0;
            border: 1px solid #cbd5e1;
            background-color: white;
            border-radius: 0.75rem;
            padding: 0.25rem;
            margin-right: 0.75rem;
        }

        .dark trix-toolbar .trix-button-group {
            border-color: #334155; /* slate-700 */
            background-color: #1e293b; /* slate-800 */
        }

        trix-toolbar .trix-button {
            border-bottom: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
            color: #475569; /* slate-600 */
        }

        trix-toolbar .trix-button:hover {
            background-color: #f1f5f9;
        }

        .dark trix-toolbar .trix-button {
            color: #f8fafc; /* slate-50 */
        }

        .dark trix-toolbar .trix-button:hover {
            background-color: #334155; /* slate-700 */
            color: #ffffff;
        }
        
        /* Ensure Trix SVG icons are visible in dark mode */
        .dark trix-toolbar .trix-button::before {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }
        
        .dark trix-toolbar .trix-button--active::before {
            filter: none; /* Keep original for active red state if needed, or refine */
            opacity: 1;
        }

        trix-toolbar .trix-button--active {
            background-color: #fee2e2; /* red-100 */
            color: #ef4444; /* red-500 */
        }

        .dark trix-toolbar .trix-button--active {
            background-color: #991b1b; /* red-900 */
            color: #fca5a5; /* red-300 */
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
        trix-editor h1 { font-size: 1.5em; font-weight: 800; margin-bottom: 0.5em; line-height: 1.2; color: #0f172a; letter-spacing: -0.025em; }
        .dark trix-editor h1 { color: #f8fafc; }
        
        trix-editor blockquote { border-left: 4px solid #ef4444; padding-left: 1.5rem; color: #475569; font-style: italic; margin: 1.5rem 0; }
        .dark trix-editor blockquote { border-left-color: #dc2626; color: #94a3b8; }
        
        trix-editor code { background-color: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 0.5rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.9em; color: #dc2626; }
        .dark trix-editor code { background-color: #1e293b; color: #fca5a5; }
        
        trix-editor pre { background-color: #0f172a; color: #f8fafc; padding: 1.5rem; border-radius: 1rem; overflow-x: auto; margin: 1.5rem 0; font-family: ui-monospace, monospace; border: 1px solid #1e293b; }
        .dark trix-editor pre { background-color: #020617; border: 1px solid #334155; }
        trix-editor ul, trix-editor ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
        trix-editor li { margin-bottom: 0.5rem; }
    </style>

    <script>
        // Disable file attachment handling explicitly with SweetAlert
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Upload Gambar?',
                text: "Untuk saat ini, silakan gunakan kolom 'Bukti Kegiatan' di bawah untuk mengupload foto atau dokumen.",
                icon: 'info',
                icon: 'info',
                confirmButtonText: 'Baik, saya mengerti',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
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
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    }
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
                    confirmButtonText: 'Ya, Simpan!',
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
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading(),
                            buttonsStyling: false,
                            customClass: {
                                popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                                title: 'text-slate-900 dark:text-slate-100 font-bold',
                                htmlContainer: 'text-slate-600 dark:text-slate-400',
                            }
                        });
                        form.submit();
                    }
                });
            }
        }
    </script>
</x-app-layout>