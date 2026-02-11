<x-guest-layout>
    <div x-data="registrationForm" class="w-full max-w-6xl mx-auto my-10 bg-white shadow-2xl rounded-2xl font-sans">

        <!-- Header / Progress -->
        <div class="bg-gray-50 border-b border-gray-100 p-8">
            <div class="relative">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-200">
                    <div :style="'width: ' + ((step / 3) * 100) + '%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-600 transition-all duration-300 ease-out"></div>
                </div>
                <div class="flex justify-between text-[10px] sm:text-sm font-semibold text-gray-500 tracking-wide uppercase">
                    <span :class="{'text-red-600': step >= 1}">1. Akun & Ketentuan</span>
                    <span :class="{'text-red-600': step >= 2}">2. Data Diri</span>
                    <span :class="{'text-red-600': step >= 3}">3. Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Custom Notification Toast -->
        <div x-show="showNotification" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white border-l-4 border-red-500 shadow-xl rounded-lg overflow-hidden pointer-events-auto"
             style="display: none;">
            <div class="p-4 flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">Perhatian!</p>
                    <p class="mt-1 text-sm text-gray-500" x-text="notificationMessage"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="showNotification = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-8 md:p-12 relative pb-20">
            @csrf
            <input type="hidden" name="student_type" :value="isStudent ? 'siswa' : 'mahasiswa'">

            <!-- Step 1: Ketentuan & Akun -->
            <div x-show="step === 1">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Mulai Perjalanan Karirmu</h2>
                    <p class="text-gray-500 mt-2">Daftar sekarang untuk bergabung dengan tim hebat kami.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-12">
                   <!-- Ketentuan -->
                   <div class="space-y-6">
                        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-lg">
                            <h3 class="flex items-center text-lg font-bold text-red-700 mb-3">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Ketentuan Pendaftaran
                            </h3>
                            <div class="prose prose-sm text-gray-700">
                                <p class="mb-2">Selamat datang di Telkom Witel Jateng Semarang Utara. Mohon perhatikan:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Wajib memiliki akun <strong>Telegram</strong> aktif dengan nomor Telkomsel.</li>
                                    <li>Komitmen penuh terhadap periode magang yang disepakati.</li>
                                </ul>
                                <p class="text-xs mt-3 text-red-600 bg-red-100 p-2 rounded inline-block font-semibold">
                                    Catatan: Pengurangan periode dapat membatalkan sertifikat.
                                </p>
                            </div>
                        </div>

                        <label class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-red-300 transition cursor-pointer" x-bind:class="{'border-red-500 bg-red-50': errors.term}">
                            <input type="checkbox" name="term" id="term" class="mt-1 w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500" required @change="errors.term = false">
                            <span class="text-sm text-gray-700 select-none" x-bind:class="{'text-red-700': errors.term}">
                                Saya telah membaca, memahami, dan menyetujui seluruh ketentuan dan persyaratan yang berlaku untuk program magang ini.
                            </span>
                        </label>
                   </div>

                   <!-- Form Akun -->
                    <div class="space-y-5">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Buat Akun</h3>
                        
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.name}" type="text" name="name" :value="old('name')" required placeholder="" @input="errors.name = false" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Alamat Email')" />
                            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.email}" type="email" name="email" :value="old('email')" required placeholder="" @input="errors.email = false" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.password}" type="password" name="password" required @input="errors.password = false" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.password_confirmation}" type="password" name="password_confirmation" required @input="errors.password_confirmation = false" />
                            </div>
                        </div>

                        <!-- Inline Next Button for Step 1 safety -->
                        <div class="pt-4 flex justify-end">
                            <button type="button" 
                                    @click="nextStep()" 
                                    class="flex items-center bg-red-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md hover:bg-red-700 hover:shadow-lg transition">
                                Selanjutnya
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </button>
                        </div>
                   </div>
                </div>
            </div>

            <!-- Step 2: Lengkapi Data -->
            <div x-show="step === 2" style="display: none;">
                
                <!-- Category Selection (Always Visible if not selected, or can change) -->
                <div x-show="!studentType" class="flex flex-col items-center justify-center h-full space-y-8">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900">Pilih Kategori Peserta</h2>
                        <p class="text-gray-500">Silakan pilih kategori yang sesuai dengan Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl px-4">
                        <!-- Mahasiswa Card -->
                        <div @click="studentType = 'mahasiswa'" class="group relative bg-white border-2 border-gray-200 rounded-2xl p-8 cursor-pointer hover:border-red-500 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-red-50 group-hover:text-red-600 transition-colors">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mahasiswa</h3>
                            <p class="text-sm text-gray-500">Untuk mahasiswa aktif jenjang D3, D4, dan S1 dari berbagai universitas.</p>
                        </div>

                        <!-- Siswa SMK Card -->
                        <div @click="studentType = 'siswa'" class="group relative bg-white border-2 border-gray-200 rounded-2xl p-8 cursor-pointer hover:border-red-500 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                             <div class="w-20 h-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-red-50 group-hover:text-red-600 transition-colors">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Siswa SMK</h3>
                            <p class="text-sm text-gray-500">Untuk siswa SMK yang akan melaksanakan Praktik Kerja Industri (Prakerin).</p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-start w-full max-w-4xl px-4">
                         <button type="button" 
                                @click="prevStep()" 
                                class="flex items-center text-gray-600 hover:text-gray-900 font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                            Kembali
                        </button>
                    </div>
                </div>

                <!-- Form Content (Visible after selection) -->
                <div x-show="studentType" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Lengkapi Data Diri <span x-text="studentType === 'mahasiswa' ? '(Mahasiswa)' : '(Siswa SMK)'" class="text-red-600"></span></h2>
                            <p class="text-gray-500">Isi data diri dan upload dokumen yang diperlukan.</p>
                        </div>
                        <button type="button" @click="studentType = null" class="text-sm text-red-600 font-semibold hover:underline bg-red-50 px-3 py-1 rounded-lg">Ganti Kategori</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Kiri: Data Magang -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3 border-b-2 border-red-500 pb-2 mb-4">
                                <div class="bg-red-100 p-2 rounded-lg text-red-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Detail Magang</h3>
                            </div>
                        
                        <!-- Educational Level Selection (Only for Mahasiswa) -->
                        <div x-show="studentType === 'mahasiswa'">
                                <x-input-label for="education_level" :value="__('Jenjang Pendidikan')" />
                                <select name="education_level" id="education_level" x-model="educationLevel" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 transition" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.education_level}" @change="errors.education_level = false">
                                    <option value="" disabled selected hidden>Pilih Jenjang...</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                </select>
                        </div>

                       <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="start_date" class="!text-xs text-gray-500" :value="__('Mulai Magang')" />
                                <div class="relative">
                                     <x-text-input 
                                        type="text" 
                                        name="start_date" 
                                        x-model="startDate" 
                                        x-init="flatpickr($el, { 
                                            dateFormat: 'Y-m-d', 
                                            altInput: true, 
                                            altFormat: 'd/m/Y', 
                                            locale: 'id', 
                                            disableMobile: true,
                                            onChange: function(selectedDates, dateStr, instance) {
                                                startDate = dateStr;
                                                errors.start_date = false;
                                            }
                                        })"
                                        class="w-full mt-1 bg-white" 
                                        x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.start_date}" 
                                        required 
                                        placeholder="dd/mm/yyyy"
                                    />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="end_date" class="!text-xs text-gray-500" :value="__('Selesai Magang')" />
                                <div class="relative">
                                    <x-text-input 
                                        type="text" 
                                        name="end_date" 
                                        x-model="endDate" 
                                        x-init="flatpickr($el, { 
                                            dateFormat: 'Y-m-d', 
                                            altInput: true, 
                                            altFormat: 'd/m/Y', 
                                            locale: 'id', 
                                            disableMobile: true,
                                            onChange: function(selectedDates, dateStr, instance) {
                                                endDate = dateStr;
                                                errors.end_date = false;
                                            }
                                        })"
                                        class="w-full mt-1 bg-white" 
                                        x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.end_date}" 
                                        required 
                                        placeholder="dd/mm/yyyy"
                                    />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                </div>
                            </div>
                       </div>
                       <div>
                            <!-- Hidden Input for Duration submission -->
                            <input type="hidden" name="duration" x-bind:value="durationText">
                            
                            <!-- Display Text for Duration -->
                            <div class="mt-3 flex items-center bg-blue-50/50 px-4 py-3 rounded-xl border border-blue-100 transition-all duration-300" x-show="durationText && durationText !== 'Tanggal selesai tidak valid' && durationText !== 'Kurang dari 1 hari'" x-transition>
                                <div class="bg-blue-100 p-1.5 rounded-full text-blue-600 mr-3">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-500 font-medium uppercase tracking-wide">Estimasi Durasi</p>
                                    <p class="text-sm font-bold text-blue-800" x-text="durationText"></p>
                                </div>
                            </div>
                            <div class="mt-2 text-red-500 text-xs font-semibold flex items-center animate-pulse" x-show="durationText === 'Tanggal selesai tidak valid'">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Tanggal selesai harus setelah tanggal mulai
                            </div>
                       </div>
                       <div>
                            <label class="block font-medium text-sm text-gray-700">
                                <span x-text="isStudent ? 'Kelas Saat Ini' : 'Semester Saat Ini'"></span>
                            </label>
                             <select name="semester" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 transition" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.semester}" required @change="errors.semester = false">
                                <option value="" disabled selected hidden>Pilih...</option>
                                <template x-if="isUniversity">

                                    <optgroup label="Mahasiswa">
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                        <option value="7">Semester 7</option>
                                        <option value="8">Semester 8</option>
                                    </optgroup>
                                </template>
                                <template x-if="isStudent">
                                    <optgroup label="Siswa SMK">
                                        <option value="10">Kelas 10</option>
                                        <option value="11">Kelas 11</option>
                                        <option value="12">Kelas 12</option>
                                    </optgroup>
                                </template>
                             </select>
                       </div>
                       <div>
                             <x-input-label for="reason" :value="__('Alasan Magang')" />
                             <textarea name="reason" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 transition" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.reason}" placeholder="Jelaskan mengapa Anda ingin magang di sini..." required @input="errors.reason = false"></textarea>
                       </div>
                    </div>

                    <!-- Kanan: Data Mahasiswa/Siswa -->
                    <!-- Kanan: Data Mahasiswa/Siswa -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 border-b-2 border-blue-500 pb-2 mb-4">
                                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    <span x-text="isStudent ? 'Data Siswa' : 'Data Mahasiswa'"></span>
                                </h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block font-medium text-sm text-gray-700">
                                    <span x-text="isStudent ? 'Nama Sekolah' : 'Universitas'"></span>
                                </label>
                                <x-text-input type="text" name="university" class="w-full mt-1" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.university}" x-bind:placeholder="isStudent ? '' : 'Nama Universitas'" required @input="errors.university = false" />
                            </div>
                            <div>
                                <x-input-label for="major" :value="__('Jurusan')" />
                                <x-text-input type="text" name="major" class="w-full mt-1" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.major}" required @input="errors.major = false" />
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">
                                    <span x-text="isStudent ? 'NIS/NISN' : 'NIM'"></span>
                                </label>
                                <x-text-input type="text" name="nim" class="w-full mt-1" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.nim}" required @input="errors.nim = false" />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="phone" :value="__('No. WhatsApp')" />
                                <x-text-input type="text" name="phone" class="w-full mt-1" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.phone}" placeholder="08..." required @input="errors.phone = false" />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="telegram" :value="__('Username Telegram')" />
                                <x-text-input type="text" name="telegram" class="w-full mt-1" x-bind:class="{'border-red-500 ring-red-500 focus:border-red-500 focus:ring-red-500': errors.telegram}" placeholder="@username" required @input="errors.telegram = false" />
                                <p class="text-xs text-gray-500 mt-1">Pastikan username aktif dan bisa dihubungi.</p>
                            </div>
                        </div>
                    </div>

                    </div>

                    <!-- Bawah: File Uploads -->
                    <div class="mt-8">
                        <div class="flex items-center space-x-3 border-b-2 border-green-500 pb-2 mb-6">
                                <div class="bg-green-100 p-2 rounded-lg text-green-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Upload Dokumen</h3>
                        </div>

                        <div class="bg-gray-50 p-8 rounded-2xl border-2 border-dashed border-gray-300 hover:border-red-300 transition-colors">
                            <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Curriculum Vitae (PDF)</label>
                                <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer rounded-lg border transition" x-bind:class="{'border-red-500 bg-red-50': errors.cv, 'border-gray-300': !errors.cv}" required @change="errors.cv = false">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span x-text="isStudent ? 'Surat Pengantar Sekolah (PDF)' : 'Surat Rekomendasi Kampus (PDF)'"></span>
                                </label>
                                <input type="file" name="surat_rekomendasi" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer rounded-lg border transition" x-bind:class="{'border-red-500 bg-red-50': errors.surat_rekomendasi, 'border-gray-300': !errors.surat_rekomendasi}" required @change="errors.surat_rekomendasi = false">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span x-text="isStudent ? 'Kartu Pelajar (Image/PDF)' : 'Kartu Tanda Mahasiswa (Image/PDF)'"></span>
                                </label>
                                <input type="file" name="ktm" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer rounded-lg border transition" x-bind:class="{'border-red-500 bg-red-50': errors.ktm, 'border-gray-300': !errors.ktm}" required @change="errors.ktm = false">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Diri Terbaru (Image)</label>
                                <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer rounded-lg border transition" x-bind:class="{'border-red-500 bg-red-50': errors.photo, 'border-gray-300': !errors.photo}" required @change="errors.photo = false">
                            </div>
                        </div>
                    </div>

                    <!-- Inline Navigation Buttons for Step 2 -->
                    <div class="mt-8 flex justify-end">
                        <button type="button" 
                                @click="nextStep()" 
                                class="flex items-center bg-red-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md hover:bg-red-700 hover:shadow-lg transition">
                            Selanjutnya
                            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>
                </div>
            </div>
            </div>

            <!-- Step 3: Konfirmasi -->
            <div x-show="step === 3" style="display: none;" class="flex flex-col items-center justify-center text-center py-12 min-h-[300px]">
                
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua Siap!</h2>
                <div class="max-w-md mx-auto text-gray-600 mb-10">
                    <p class="mb-2">Anda akan mendaftar sebagai <strong>Intern</strong> di Telkom Witel Semarang.</p>
                    <p>Pastikan seluruh data sudah benar. Klik tombol di bawah untuk mengirim permohonan Anda.</p>
                </div>

                <div class="flex gap-4">
                     <button type="button" @click="prevStep()" class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 transition">
                        Cek Lagi
                    </button>
                    <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-lg shadow-lg hover:bg-red-700 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                        Kirim Permohonan
                    </button>
                </div>
            </div>



        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registrationForm', () => ({
                step: 1,
                studentType: null, // 'mahasiswa' or 'siswa'
                educationLevel: '',
                startDate: '',
                endDate: '',
                showNotification: false,
                notificationMessage: '',
                errors: {},
                
                get durationText() {
                    if (!this.startDate || !this.endDate) return '';
                    
                    const start = new Date(this.startDate);
                    const end = new Date(this.endDate);
                    
                    if (end < start) return 'Tanggal selesai tidak valid';
                    
                    // Calculate difference in milliseconds
                    const diffTime = Math.abs(end - start);
                    
                    // Approximate months calculation
                    let months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth());
                    let days = end.getDate() - start.getDate();
                    
                    if (days < 0) {
                        months--;
                        // Get days in previous month
                        const prevMonth = new Date(end.getFullYear(), end.getMonth(), 0);
                        days += prevMonth.getDate();
                    }

                    // Refined output text
                    let result = '';
                    if (months > 0) result += `${months} Bulan `;
                    if (days > 0) result += `${days} Hari`;
                    
                    if (!result) return 'Kurang dari 1 hari';
                    
                    return result.trim();
                },

                init() {
                    this.$watch('studentType', value => {
                        if (value === 'siswa') {
                            this.educationLevel = 'SMK';
                        } else {
                            this.educationLevel = '';
                        }
                    });
                },

                showError(message) {
                    this.notificationMessage = message;
                    this.showNotification = true;
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 5000);
                },

                nextStep() {
                     // Reset errors
                     this.errors = {};

                     // Validate Step 1 selection
                     if (this.step === 1) {
                        const name = document.getElementById('name').value;
                        const email = document.getElementById('email').value;
                        const password = document.getElementById('password').value;
                        const confirm = document.getElementById('password_confirmation').value;
                        const term = document.getElementById('term').checked;

                        if (!name) this.errors.name = true;
                        if (!email) this.errors.email = true;
                        if (!password) this.errors.password = true;
                        if (!confirm) this.errors.password_confirmation = true;
                        if (!term) this.errors.term = true;

                        if (Object.keys(this.errors).length > 0) {
                            this.showError('Harap lengkapi semua data dan setujui ketentuan.');
                            return;
                        }
                        
                        if (password !== confirm) {
                            this.errors.password = true;
                            this.errors.password_confirmation = true;
                            this.showError('Password tidak sama.');
                            return;
                        }
                    }

                    // Validate Step 2 selection
                    if (this.step === 2) {
                         if (!this.studentType) {
                            this.showError('Harap pilih kategori peserta (Mahasiswa / Siswa SMK).');
                            return;
                         }
                         
                         // If Mahasiswa, validate education level
                         if (this.studentType === 'mahasiswa' && !this.educationLevel) {
                             this.errors.education_level = true;
                             this.showError('Harap pilih jenjang pendidikan.');
                             return;
                         }

                         // Validate Dates and Reason
                         if (!this.startDate) this.errors.start_date = true;
                         if (!this.endDate) this.errors.end_date = true;
                         // We need to check if duration is valid
                         if (this.durationText === 'Tanggal selesai tidak valid') {
                             this.errors.end_date = true;
                         }
                         
                         const reason = document.querySelector('textarea[name="reason"]').value;
                         if (!reason) this.errors.reason = true;
                         
                         const university = document.querySelector('input[name="university"]').value;
                         if (!university) this.errors.university = true;
                         
                         const major = document.querySelector('input[name="major"]').value;
                         if (!major) this.errors.major = true;

                         const nim = document.querySelector('input[name="nim"]').value;
                         if (!nim) this.errors.nim = true;
                         
                         const phone = document.querySelector('input[name="phone"]').value;
                         if (!phone) this.errors.phone = true;
                         
                         const telegram = document.querySelector('input[name="telegram"]').value;
                         if (!telegram) this.errors.telegram = true;

                         const semester = document.querySelector('select[name="semester"]').value;
                         if (!semester) this.errors.semester = true;

                         // Validate File Uploads
                         const cv = document.querySelector('input[name="cv"]').value;
                         if (!cv) this.errors.cv = true;
                         
                         const surat = document.querySelector('input[name="surat_rekomendasi"]').value;
                         if (!surat) this.errors.surat_rekomendasi = true;
                         
                         const ktm = document.querySelector('input[name="ktm"]').value;
                         if (!ktm) this.errors.ktm = true;
                         
                         const photo = document.querySelector('input[name="photo"]').value;
                         if (!photo) this.errors.photo = true;

                         if (Object.keys(this.errors).length > 0) {
                             // Check if duration invalid specifically to give better error
                             if (this.durationText === 'Tanggal selesai tidak valid') {
                                 this.showError('Tanggal selesai harus setelah tanggal mulai.');
                             } else {
                                 this.showError('Harap lengkapi semua data dan upload dokumen yang diperlukan.');
                             }
                             return;
                         }
                    }

                    if (this.step < 3) this.step++;
                },
                prevStep() {
                    if (this.step > 1) this.step--;
                },
                get isStudent() {
                    return this.studentType === 'siswa';
                },
                get isUniversity() {
                     return this.studentType === 'mahasiswa';
                }
            }));
        });
    </script>
</x-guest-layout>