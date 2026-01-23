<footer class="bg-white border-t border-gray-200 py-10 px-5 w-full">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16">
        
        <!-- Logo Section -->
        <div class="flex-shrink-0">
            <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom Indonesia" class="h-[85px] w-auto block">
        </div>

        <!-- Vertical Divider (Hidden on Mobile) -->
        <div class="hidden md:block w-px h-[120px] bg-gray-300"></div>

        <!-- Info Section -->
        <div class="flex flex-col items-center md:items-start text-center md:text-left">
            <p class="text-gray-600 text-sm leading-relaxed mb-2">
                <strong>Divisi Telkom Regional IV</strong><br>
                Jl. Pahlawan No.10, Pleburan, Kec. Semarang Selatan,<br>
                Kota Semarang, Jawa Tengah 50249.
            </p>
            
            <div class="text-gray-600 text-sm mb-3">
                Phone: <a class="text-gray-700 font-semibold no-underline transition-colors duration-200 hover:text-red-600 cursor-pointer">(024) 8302006</a>
            </div>

            <div class="flex gap-4 mt-1">
                <!-- Location Icon -->
                <a href="https://www.google.com/maps/place/TELKOM+WITEL+SEMARANG/@-7.014223,110.4328813,17z/data=!3m1!4b1!4m6!3m5!1s0x2e708c879bc849f1:0x6c1566e0b320bd25!8m2!3d-7.014223!4d110.4354562!16s%2Fg%2F11cm0cwy3t?entry=ttu&g_ep=EgoyMDI2MDExMy4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="w-9 h-9 border border-gray-400 rounded-full flex justify-center items-center text-gray-600 transition-all duration-300 hover:border-red-600 hover:bg-red-600 hover:text-white hover:-translate-y-0.5 hover:shadow-lg" title="Location">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </a>
                <!-- Website Icon -->
                <a href="https://www.telkom.co.id" target="_blank" class="w-9 h-9 border border-gray-400 rounded-full flex justify-center items-center text-gray-600 transition-all duration-300 hover:border-red-600 hover:bg-red-600 hover:text-white hover:-translate-y-0.5 hover:shadow-lg" title="Website">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                </a>
                <!-- Mail Icon -->
                <a href="mailto:hc.witelsju@gmail.com" class="w-9 h-9 border border-gray-400 rounded-full flex justify-center items-center text-gray-600 transition-all duration-300 hover:border-red-600 hover:bg-red-600 hover:text-white hover:-translate-y-0.5 hover:shadow-lg" title="Email">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </a>
            </div>

            <div class="text-xs text-gray-400 mt-2 font-normal">
                © {{ date('Y') }} PT Telkom Indonesia (Persero) Tbk. All Rights Reserved.
            </div>
        </div>
    </div>
</footer>
