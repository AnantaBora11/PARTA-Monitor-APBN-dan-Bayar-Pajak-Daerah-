<!-- About Us Section -->
<section id="about" class="relative w-full pb-20 pt-20">
    <div class="relative z-20 w-[95%] max-w-[1800px] mx-auto px-4 md:px-0">
        <div class="relative w-full rounded-[3rem] overflow-hidden shadow-2xl" 
             style="border: 3px solid transparent; 
                    background: linear-gradient(346deg, rgba(0, 0, 0, 0) 0%, rgba(50,50,50,0.5) 75%) padding-box, 
                                linear-gradient(346deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.5) 78%) border-box;">
            
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-blue-900 via-blue-950 to-slate-900"></div>

            <div class="relative z-20 p-8 md:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-white">
                        <h2 class="text-4xl md:text-5xl font-baloo-bhai font-bold drop-shadow-lg mb-6">
                            Tentang Kami
                        </h2>
                        <p class="text-slate-300 text-lg leading-relaxed font-light mb-6">
                            {{ $about->value ?? 'Pajak Daerahku adalah platform digital yang dirancang untuk mempermudah masyarakat dalam mengelola kewajiban pajak daerah secara transparan dan efisien.' }}
                        </p>
                        <p class="text-slate-300 text-lg leading-relaxed font-light mb-6">
                            Melalui sistem kami, pengguna dapat melakukan pelacakan alokasi dan penggunaan dana APBN secara real-time serta membayar berbagai jenis pajak daerah secara online dengan aman dan praktis.
                        </p>
                        <p class="text-slate-300 text-lg leading-relaxed font-light">
                            Kami berkomitmen menghadirkan layanan publik yang modern, akuntabel, dan mudah diakses, demi mendukung pembangunan daerah yang berkelanjutan dan kesejahteraan bersama.
                        </p>
                    </div>

                    <!-- Image  -->
                    <div class="grid grid-cols-3 grid-rows-3 gap-3 h-[400px] md:h-[500px]">
                        <div class="col-span-1 row-span-1 rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset('image/yogyakarta_tugu.png') }}" alt="Tugu Yogyakarta" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="col-span-2 row-span-1 rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset('image/yogyakarta_prambanan.png') }}" alt="Prambanan Temple" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <div class="col-span-2 row-span-1 rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset('image/yogyakarta_malioboro.png') }}" alt="Malioboro Street" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="col-span-1 row-span-1 rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset('image/yogyakarta_tugu.png') }}" alt="Yogyakarta Landmark" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <div class="col-span-1 row-span-1 rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset('image/yogyakarta_prambanan.png') }}" alt="Temple" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="col-span-1 row-span-1 rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset('image/yogyakarta_malioboro.png') }}" alt="Street" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="col-span-1 row-span-1 rounded-2xl overflow-hidden shadow-lg relative">
                            <img src="{{ asset('image/yogyakarta_prambanan.png') }}" alt="Prambanan" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                            <div class="absolute bottom-2 right-2 bg-black/50 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-lg font-bold">PRAMBANAN</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
