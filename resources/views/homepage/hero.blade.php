<!-- Hero Section -->
<section id="home" class="relative w-full min-h-screen bg-secondary-dark">
    <div class="absolute inset-0 z-[5] opacity-15 flex items-end justify-center pointer-events-none overflow-hidden">
         <img src="{{ asset('image/silueteIndonesia.png') }}" alt="Indonesia Silhouette" width="2100" height="2100" class="min-w-[135vw] md:min-w-[115vw] h-auto object-cover object-bottom translate-y-[35%]">
    </div>

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-6 pt-32 pb-0 text-center flex flex-col items-center">
        <h1 class="text-white font-baloo-bhai font-extrabold text-[60px] md:text-[100px] leading-none mb-2 drop-shadow-md tracking-wide">
            BAYAR PAJAK MUDAH
        </h1>
        <h2 class="text-white font-baloo-bhaijaan font-extrabold text-[40px] md:text-[60px] mb-12 drop-shadow-md tracking-wide">
            YOGYAKARTA
        </h2>

        <!-- Mascot & Actions -->
        <div class="relative w-full max-w-7xl flex flex-col md:flex-row items-center justify-center gap-10 md:gap-0 mt-8">
            
            <!--  Pembayaran Pajak -->
            <div class="hidden md:flex flex-col items-center md:absolute md:left-20 md:top-20 z-[30]">
                 <div class="bg-white rounded-full p-6 w-28 h-28 flex items-center justify-center shadow-xl mb-4 border-4 border-white transform hover:scale-110 transition-transform duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-yellow-500 group-hover:text-secondary-dark transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                 </div>
                 <h3 class="text-white font-bold text-xl text-center mb-1 drop-shadow-sm">Pembayaran<br>Pajak Online</h3>
                 <a href="#services" class="mt-2 bg-primary-dark text-white px-6 py-2.5 rounded-full font-bold shadow-lg hover:bg-primary-darker text-sm tracking-wider uppercase transition-all transform hover:scale-105 border-2 border-white/20">
                    MULAI BAYAR
                 </a>
            </div>

            <!--  Mascot -->
            <div class="relative z-[15] w-[400px] md:w-[1200px] lg:w-[1500px] -mt-16 md:-mt-10 mb-[-150px] md:mb-[-200px] mx-auto -translate-x-10 md:-translate-x-12">
                <img src="{{ asset('image/mascot.png') }}" alt="Mascot Eagle" width="1200" height="900" class="w-full drop-shadow-2xl -scale-x-100" style="clip-path: inset(16% 0 0 0); margin-top: -12%;">
            </div>

            <!-- Informasi APBD -->
            <div class="hidden md:flex flex-col items-center md:absolute md:right-20 md:top-20 z-[30]">
                 <div class="bg-white rounded-full p-6 w-28 h-28 flex items-center justify-center shadow-xl mb-4 border-4 border-white transform hover:scale-110 transition-transform duration-300 group">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-yellow-500 group-hover:text-secondary-dark transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                     </svg>
                 </div>
                 <h3 class="text-white font-bold text-xl text-center mb-1 drop-shadow-sm">Informasi<br>Penggunaan APBD</h3>
                 <a href="#map-section" class="mt-2 bg-primary-dark text-white px-6 py-2.5 rounded-full font-bold shadow-lg hover:bg-primary-darker text-sm tracking-wider uppercase transition-all transform hover:scale-105 border-2 border-white/20">
                    LIHAT PAJAKMU
                 </a>
            </div>

        </div>
    </div>
</section>
