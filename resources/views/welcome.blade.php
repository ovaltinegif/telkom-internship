<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .hero-bg {
            background-color: #f3f4f6; /* Fallback */
        }
        .red-primary { color: #8F1919; }
        .bg-red-primary { background-color: #8F1919; }
        .text-shadow { text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav x-data="{ open: false }" class="sticky top-0 inset-x-0 z-[999] bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-28 transition-all duration-300">
                
                <!-- Left: Logo -->
                <div class="shrink-0 flex items-center gap-4">
                    <a href="#" class="flex items-center gap-3 group">
                       <img src="{{ asset('images/logo-telkom.png') }}" class="h-24 w-auto" alt="Telkom Indonesia">
                    </a>
                </div>

                <!-- Center: Navigation Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="#internship" class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 text-gray-500 hover:text-red-600 hover:bg-gray-50">Internship</a>
                    <a href="#berita" class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 text-gray-500 hover:text-red-600 hover:bg-gray-50">Berita</a>
                    <a href="#benefit" class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 text-gray-500 hover:text-red-600 hover:bg-gray-50">Benefit</a>
                    <a href="#aboutUs" class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 text-gray-500 hover:text-red-600 hover:bg-gray-50">About Us</a>
                </div>

                <!-- Right: Login Button -->
                <div class="hidden sm:flex items-center gap-4">
                     @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-full text-sm font-bold bg-red-600 text-white hover:bg-red-700 transition shadow-lg shadow-red-600/20">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-600 hover:bg-white transition-all text-xs font-bold uppercase tracking-wider">
                                Login 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                            </a>
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero / Internship Section -->
    <section id="internship" class="scroll-mt-32 relative bg-gray-900 h-screen sm:min-h-[600px] flex items-center justify-center">
        <!-- Background Image -->
        <div class="absolute inset-0 overflow-hidden">
             <!-- Placeholder for Hero Image - using a nice office/tech background -->
            <img src="{{ asset('images/gallery-12.jpg') }}" alt="Hero Background" class="w-full h-full object-cover opacity-60">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6">
                Kickstart Your Career with an Internship <br class="hidden md:block"> at Witel Semarang Jateng Utara!
            </h1>
            <p class="mt-4 text-xl text-gray-100 max-w-3xl mx-auto mb-10">
                Ikuti program internship kami untuk mendapatkan pengalaman langsung, mengasah kemampuanmu, dan terlibat dalam proyek nyata yang membawa perubahan.
            </p>
            <div class="flex justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-[#e60000] text-white px-8 py-3 rounded-md font-semibold hover:bg-red-700 transition">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="bg-[#e60000] text-white px-8 py-3 rounded-md font-semibold hover:bg-red-700 transition">Apply Now</a>
                @endauth
                <a href="#" class="bg-white text-gray-900 px-8 py-3 rounded-md font-semibold hover:bg-gray-100 transition">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section id="berita" class="scroll-mt-32 py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-3xl font-bold text-gray-900 mb-12" data-aos="fade-up">Berita Terbaru</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- News Item 1 -->
                <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                    <div class="rounded-2xl overflow-hidden shadow-lg h-full bg-white transition hover:-translate-y-1 hover:shadow-xl">
                        <img src="{{ asset('images/gallery-01.jpg') }}" alt="Briskwalk" class="w-full h-64 object-cover">
                        <div class="p-6">
                             <!-- Example Date/Title overlay style from screenshot not exactly replicated but adapted -->
                            <h3 class="text-xl font-bold text-orange-500 mb-2">Audit Eksternal IMS</h3>
                            <p class="text-gray-600 font-medium">Witel Semarang Jateng Utara sukses melaksanakan Audit Eksternal IMS 2025 di STO Gombel dan neuCentrIX Candi. Kegiatan ini bertujuan memastikan sistem keamanan dan tata kelola operasional telah memenuhi standar internasional guna menjaga kualitas layanan yang unggul dan berkelanjutan.</p>
                        </div>
                    </div>
                </div>

                 <!-- News Item 2 -->
                 <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="200">
                    <div class="rounded-2xl overflow-hidden shadow-lg h-full bg-white transition hover:-translate-y-1 hover:shadow-xl">
                        <img src="{{ asset('images/gallery-14.jpg') }}" alt="Innovation" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-blue-500 mb-2">AGENDA PERESMIAN BEDAH RUMAH BERSAMA P2TEL</h3>
                            <p class="text-gray-600 font-medium">Sebagai bentuk kepedulian sosial, P2TEL bersama Telkom melaksanakan agenda peresmian program Bedah Rumah. Kegiatan ini bertujuan untuk memberikan hunian yang lebih layak bagi penerima manfaat, sekaligus mempererat silaturahmi dan solidaritas di lingkungan keluarga besar pensiunan Telkom.</p>
                        </div>
                    </div>
                </div>

                 <!-- News Item 3 -->
                 <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="300">
                    <div class="rounded-2xl overflow-hidden shadow-lg h-full bg-white transition hover:-translate-y-1 hover:shadow-xl">
                        <img src="{{ asset('images/gallery-10.jpg') }}" alt="Pengajian" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">SEREMONI PENYERAHAN BANTUAN SARANA AIR BERSIH</h3>
                            <p class="text-gray-600 font-medium">Wujud nyata kepedulian sosial diwujudkan melalui penyerahan bantuan sarana air bersih bagi warga Desa Sidokumpul, Kendal. Program ini diharapkan dapat mempermudah akses air bersih bagi masyarakat sekitar sekaligus mendukung peningkatan standar kesehatan dan kesejahteraan lingkungan secara berkelanjutan.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Button Removed -->
        </div>
    </section>

    <!-- Benefit Section -->
    <section id="benefit" class="scroll-mt-32 py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Image Side with Carousel -->
                <div class="w-full lg:w-1/2 mb-10 lg:mb-0" x-data="{
                    activeSlide: 0,
                    slides: [
                        '{{ asset("images/gallery-02.jpg") }}',
                        '{{ asset("images/gallery-11.jpg") }}',
                        '{{ asset("images/gallery-13.jpg") }}',
                        '{{ asset("images/gallery-08.jpg") }}'
                    ],
                    next() {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    },
                    prev() {
                        this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1;
                    },
                    init() {
                        setInterval(() => {
                            this.next();
                        }, 3000);
                    }
                }">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/3] group" data-aos="fade-right">
                        <!-- Sliding Container -->
                         <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out"
                              :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                             <template x-for="(slide, index) in slides" :key="index">
                                <div class="min-w-full h-full">
                                    <img :src="slide" alt="Internship Slideshow" class="w-full h-full object-cover">
                                </div>
                            </template>
                         </div>
                        
                        <!-- Prev Button -->
                        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 focus:opacity-100">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>

                        <!-- Next Button -->
                        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 focus:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                        
                        <!-- Navigation Dots -->
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 z-10">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="activeSlide = index" 
                                        class="w-2 h-2 rounded-full transition-colors duration-300 shadow-sm"
                                        :class="activeSlide === index ? 'bg-white scale-125' : 'bg-white/50 hover:bg-white/80'"></button>
                            </template>
                        </div>
                    </div>
                </div>
                
                <!-- Content Side -->
                <div class="w-full lg:w-1/2 text-left" data-aos="fade-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#e60000] mb-6">Manfaat Internship di Witel Semarang Jateng Utara</h2>
                    <p class="text-gray-700 text-lg leading-relaxed mb-8">
                        Program Internship dan Kerja Praktik Witel Semarang Jateng Utara mengundang para mahasiswa untuk terlibat langsung dalam proyek-proyek industri, mengembangkan keterampilan digital, serta merasakan secara langsung budaya kerja yang kolaboratif.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                         <!-- Benefit 1 -->
                        <div class="bg-white p-6 rounded-xl shadow-sm text-center">
                            <div class="h-12 w-12 mx-auto mb-4 text-[#e60000]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-red-600 text-sm mb-2">Eksplorasi pengetahuan secara langsung</h3>
                            <p class="text-xs text-gray-500">Bangun relasi dan jaringan yang luas tidak hanya dengan teman satu program.</p>
                        </div>
                        
                         <!-- Benefit 2 -->
                         <div class="bg-white p-6 rounded-xl shadow-sm text-center">
                            <div class="h-12 w-12 mx-auto mb-4 text-[#e60000]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-red-600 text-sm mb-2">Perluas koneksi profesional</h3>
                            <p class="text-xs text-gray-500">Dapatkan pengalaman praktis dengan terlibat langsung dalam berbagai tantangan.</p>
                        </div>

                         <!-- Benefit 3 -->
                         <div class="bg-white p-6 rounded-xl shadow-sm text-center">
                            <div class="h-12 w-12 mx-auto mb-4 text-[#e60000]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-red-600 text-sm mb-2">Belajar langsung dari para ahli</h3>
                            <p class="text-xs text-gray-500">Dapatkan bimbingan dan wawasan eksklusif dari mentor yang berpengalaman.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us / Stats Section -->
    <section id="aboutUs" class="scroll-mt-32 py-20 bg-[#D42020] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in">
            <h2 class="text-3xl font-bold mb-4">Langkah Awal Menuju Karier Impian ✨ Dimulai di Sini</h2>
            <p class="text-white/80 mb-16 max-w-2xl mx-auto">Program internship kami telah mendukung ribuan peserta di seluruh Indonesia.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <!-- Stat 1 -->
                <div x-data="{ current: 0, target: 1245 }" x-intersect.once="let interval = setInterval(() => { if(current < target) { current += Math.ceil(target / 50); if(current > target) current = target; } else { clearInterval(interval) } }, 20)">
                    <div class="text-5xl font-bold mb-2"><span x-text="current">0</span>+</div>
                    <div class="text-white/80 font-medium">Peserta Terdaftar</div>
                </div>
                 <!-- Stat 2 -->
                 <div x-data="{ current: 0, target: 1000 }" x-intersect.once="let interval = setInterval(() => { if(current < target) { current += Math.ceil(target / 50); if(current > target) current = target; } else { clearInterval(interval) } }, 20)">
                    <div class="text-5xl font-bold mb-2"><span x-text="current">0</span>+</div>
                    <div class="text-white/80 font-medium">Peserta Aktif Melamar</div>
                </div>
                 <!-- Stat 3 -->
                 <div x-data="{ current: 0, target: 6 }" x-intersect.once="let interval = setInterval(() => { if(current < target) { current += 1; } else { clearInterval(interval) } }, 200)">
                    <div class="text-5xl font-bold mb-2" x-text="current">0</div>
                    <div class="text-white/80 font-medium">Divisi Tersedia</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stories/Testimonials (Optional based on screenshot) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-12" data-aos="fade-up">Their Stories, Their Experience</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Person 1 -->
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100" data-aos="flip-left" data-aos-delay="100">
                     <div class="w-16 h-16 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-400">
                          <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                     </div>
                     <h3 class="font-bold text-red-600">Lorem Ipsum</h3>
                     <p class="text-xs text-gray-500 mt-2">"Enak dan seru magang di Witel Semarang Jateng Utara mendapatkan banyak pengalaman berharga."</p>
                </div>
                <!-- Person 2 -->
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100" data-aos="flip-left" data-aos-delay="200">
                    <div class="w-16 h-16 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-400">
                          <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                     </div>
                    <h3 class="font-bold text-red-600">Lorem Ipsum</h3>
                    <p class="text-xs text-gray-500 mt-2">"Program magang di Witel Semarang Jateng Utara memberikan pengalaman yang sangat bermanfaat."</p>
               </div>
               <!-- Person 3 -->
               <div class="bg-gray-50 p-6 rounded-xl border border-gray-100" data-aos="flip-left" data-aos-delay="300">
                    <div class="w-16 h-16 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-400">
                          <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                     </div>
                    <h3 class="font-bold text-red-600">Lorem Ipsum</h3>
                    <p class="text-xs text-gray-500 mt-2">"Sangat bangga menjadi keluarga besar Telkom khususnya Witel Semarang Jateng Utara."</p>
               </div>
               <!-- Person 4 -->
               <div class="bg-gray-50 p-6 rounded-xl border border-gray-100" data-aos="flip-left" data-aos-delay="400">
                    <div class="w-16 h-16 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-400">
                          <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                     </div>
                    <h3 class="font-bold text-red-600">Lorem Ipsum</h3>
                    <p class="text-xs text-gray-500 mt-2">"Magang di Witel Semarang Jateng Utara memberikan saya wawasan baru tentang dunia telekomunikasi."</p>
               </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')


</body>
</html>
