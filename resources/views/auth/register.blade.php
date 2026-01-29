<x-guest-layout>
    <div x-data="{
        step: 1,
        selectedDivision: null,
        divisions: {{ $divisions->map(fn($d) => [
            'id' => $d->id, 
            'name' => $d->name, 
            'description' => $d->description ?? 'Bertanggung jawab dalam pengelolaan administrasi, teknis, atau operasional sesuai dengan fungsi divisi. Memberikan pengalaman kerja nyata di lingkungan profesional.', 
            'quota' => 5, 
            'duration' => '3 Bulan', 
            'location' => 'Semarang • Onsite',
            'education' => 'Sarjana, Diploma',
            'majors' => 'Sesuai Jurusan Terkait' 
        ]) }},
        
        nextStep() {
             // Validate Step 1 selection
             if (this.step === 1) {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const confirm = document.getElementById('password_confirmation').value;
                const term = document.getElementById('term').checked;

                if (!name || !email || !password || !confirm || !term) {
                    alert('Harap lengkapi semua data dan setujui ketentuan.');
                    return;
                }
                if (password !== confirm) {
                    alert('Password tidak sama.');
                    return;
                }
            }

            // Validate Step 2 selection
            if (this.step === 2 && !this.selectedDivision) {
                alert('Silakan pilih posisi magang terlebih dahulu.');
                return;
            }

            if (this.step < 4) this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
        },
        selectDivision(id) {
            this.selectedDivision = this.divisions.find(d => d.id === id);
            document.getElementById('division_id').value = id;
        }
    }" class="w-full max-w-6xl mx-auto my-10 bg-white shadow-2xl rounded-2xl overflow-hidden font-sans">

        <!-- Header / Progress -->
        <div class="bg-gray-50 border-b border-gray-100 p-8">
            <div class="relative">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-200">
                    <div :style="'width: ' + ((step / 4) * 100) + '%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-600 transition-all duration-500 ease-out"></div>
                </div>
                <div class="flex justify-between text-[10px] sm:text-sm font-semibold text-gray-500 tracking-wide uppercase">
                    <span :class="{'text-red-600': step >= 1}">1. Akun & Ketentuan</span>
                    <span :class="{'text-red-600': step >= 2}">2. Pilih Posisi</span>
                    <span :class="{'text-red-600': step >= 3}">3. Data diri</span>
                    <span :class="{'text-red-600': step >= 4}">4. Konfirmasi</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-8 md:p-12 h-[750px] flex flex-col relative">
            @csrf
            <input type="hidden" name="division_id" id="division_id" required>

            <!-- Step 1: Ketentuan & Akun -->
            <div x-show="step === 1" class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
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

                        <label class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-red-300 transition cursor-pointer">
                            <input type="checkbox" name="term" id="term" class="mt-1 w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500" required>
                            <span class="text-sm text-gray-700 select-none">
                                Saya telah membaca, memahami, dan menyetujui seluruh ketentuan dan persyaratan yang berlaku untuk program magang ini.
                            </span>
                        </label>
                   </div>

                   <!-- Form Akun -->
                   <div class="space-y-5">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Buat Akun</h3>
                        
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="text" name="name" :value="old('name')" required placeholder="John Doe" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Alamat Email')" />
                            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="email" name="email" :value="old('email')" required placeholder="email@university.ac.id" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Pw')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="password" name="password_confirmation" required />
                            </div>
                        </div>
                   </div>
                </div>
            </div>

            <!-- Step 2: Pilih Lowongan -->
            <div x-show="step === 2" style="display: none;" class="flex-1 flex flex-col h-full overflow-hidden">
                <div class="mb-6 flex-shrink-0">
                    <h2 class="text-2xl font-bold text-gray-900">Pilih Posisi Magang</h2>
                    <p class="text-gray-500">Pilih divisi yang sesuai dengan minat dan jurusanmu.</p>
                </div>

                <div class="flex flex-col lg:flex-row gap-8 flex-1 overflow-hidden">
                    <!-- List -->
                    <div class="w-full lg:w-5/12 overflow-y-auto pr-2 custom-scrollbar space-y-3 h-full">
                        <template x-for="divisi in divisions" :key="divisi.id">
                            <div @click="selectDivision(divisi.id)" 
                                 :class="selectedDivision?.id === divisi.id ? 'border-red-600 bg-red-50 ring-2 ring-red-500 ring-offset-2' : 'border-gray-200 hover:border-red-300 hover:bg-red-50/30'"
                                 class="p-5 border rounded-xl cursor-pointer transition-all duration-200 relative group bg-white shadow-sm hover:shadow-md">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-gray-800 group-hover:text-red-700 transition" x-text="divisi.name"></h3>
                                    <span class="bg-gradient-to-r from-green-500 to-green-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm uppercase tracking-wide">Dibuka</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500 gap-3">
                                    <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span x-text="divisi.duration"></span></span>
                                    <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>Onsite</span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Detail -->
                    <div class="w-full lg:w-7/12 bg-gray-50 rounded-2xl border border-gray-200 p-8 flex flex-col relative overflow-hidden h-full">
                         <div x-show="!selectedDivision" class="flex flex-col items-center justify-center h-full text-gray-400 absolute inset-0 z-10 bg-gray-50">
                            <svg class="w-20 h-20 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span class="font-medium">Pilih posisi untuk melihat detail</span>
                        </div>
                        
                        <div x-show="selectedDivision" x-transition.opacity class="relative z-20 h-full overflow-y-auto custom-scrollbar">
                            <h2 class="text-3xl font-bold text-gray-900 mb-1" x-text="selectedDivision?.name"></h2>
                            <span class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full mb-6">Full Time Internship</span>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="font-bold text-gray-900 flex items-center mb-2">
                                        <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>
                                        Deskripsi Pekerjaan
                                    </h4>
                                    <p class="text-gray-600 text-sm leading-relaxed pl-11" x-text="selectedDivision?.description"></p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 flex items-center mb-2">
                                         <span class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg></span>
                                        Kualifikasi Jurusan
                                    </h4>
                                    <p class="text-gray-600 text-sm pl-11" x-text="selectedDivision?.majors"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Lengkapi Data -->
            <div x-show="step === 3" style="display: none;" class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Lengkapi Administrasi</h2>
                    <p class="text-gray-500">Isi data diri dan upload dokumen yang diperlukan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                     <!-- Kiri: Data Magang -->
                    <div class="space-y-5">
                       <h3 class="font-bold text-gray-800 border-b pb-2">Detail Magang</h3>
                       <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="start_date" class="!text-xs text-gray-500" :value="__('Usulan Mulai Magang (Hari Senin Awal Bulan)')" />
                                <x-text-input type="date" name="start_date" class="w-full mt-1" required />
                            </div>
                            <div>
                                <x-input-label for="end_date" class="!text-xs text-gray-500" :value="__('Usulan Selesai Magang (Hari Jumat Akhir Bulan)')" />
                                <x-text-input type="date" name="end_date" class="w-full mt-1" required />
                            </div>
                       </div>
                       <div>
                            <x-input-label for="semester" :value="__('Semester Saat Ini')" />
                             <select name="semester" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" required>
                                <option value="">Pilih...</option>
                                <option value="5">Semester 5</option>
                                <option value="6">Semester 6</option>
                                <option value="7">Semester 7</option>
                             </select>
                       </div>
                       <div>
                             <x-input-label for="reason" :value="__('Motivasi / Alasan')" />
                             <textarea name="reason" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Jelaskan mengapa Anda ingin magang di sini..." required></textarea>
                       </div>
                    </div>

                    <!-- Kanan: Data Mahasiswa -->
                    <div class="space-y-5">
                        <h3 class="font-bold text-gray-800 border-b pb-2">Data Mahasiswa</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <x-input-label for="university" :value="__('Universitas')" />
                                <x-text-input type="text" name="university" class="w-full mt-1" placeholder="Nama Universitas" required />
                            </div>
                            <div>
                                <x-input-label for="major" :value="__('Jurusan')" />
                                <x-text-input type="text" name="major" class="w-full mt-1" required />
                            </div>
                            <div>
                                <x-input-label for="nim" :value="__('NIM')" />
                                <x-text-input type="text" name="nim" class="w-full mt-1" required />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="phone" :value="__('No. WhatsApp')" />
                                <x-text-input type="text" name="phone" class="w-full mt-1" placeholder="08..." required />
                            </div>
                        </div>
                    </div>

                    <!-- Bawah: File Uploads -->
                    <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300">
                        <h3 class="font-bold text-gray-800 mb-4">Upload Dokumen</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Curriculum Vitae (PDF)</label>
                                <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Surat Permohonan (PDF)</label>
                                <input type="file" name="surat_permohonan" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Konfirmasi -->
            <div x-show="step === 4" style="display: none;" class="flex-1 flex flex-col items-center justify-center text-center py-12">
                
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua Siap!</h2>
                <div class="max-w-md mx-auto text-gray-600 mb-10">
                    <p class="mb-2">Anda akan mendaftar sebagai <strong>Intern</strong> pada posisi <strong class="text-gray-900" x-text="selectedDivision?.name"></strong>.</p>
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

            <!-- Navigation Buttons (Global for Step 1-3) -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex-shrink-0 flex justify-between" x-show="step < 4">
                <button type="button" 
                        @click="prevStep()" 
                        x-show="step > 1"
                        class="flex items-center text-gray-600 hover:text-gray-900 font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    Kembali
                </button>
                <div x-show="step === 1"></div> <!-- Spacer if no prev button -->
                
                <button type="button" 
                        @click="nextStep()" 
                        class="flex items-center bg-red-600 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:bg-red-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Selanjutnya
                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>

        </form>
    </div>
</x-guest-layout>
