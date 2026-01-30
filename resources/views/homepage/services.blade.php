<!-- Layanan Pajak Section -->
<section id="services" class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('image/pajakmu.png') }}" alt="Background" class="w-full h-full object-cover">
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <h2 class="text-4xl md:text-5xl font-bold text-center text-white mb-12 font-baloo-bhai">Layanan Pajak</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <!-- Card 1: Kendaraan -->
            <div class="relative group cursor-pointer" onclick="handleServiceClick('Pajak Kendaraan')">
                <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-[0_8px_16px_rgba(59,130,246,0.3)] z-20 group-hover:scale-110 transition-transform duration-300 border-4 border-secondary-dark">
                    <img src="{{ asset('image/motorcycle.png') }}" alt="Motorcycle" class="w-12 h-12 object-contain filter drop-shadow-md">
                </div>
                <div class="pt-16 pb-8 px-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.2)] hover:bg-white/10 transition-all duration-300 h-full flex flex-col items-center text-center group-hover:border-white/40">
                    <h3 class="text-white text-2xl font-bold mb-4 font-manrope">Pajak Kendaraan</h3>
                    <p class="text-slate-300 leading-relaxed font-light">Kelola dan bayar pajak motor dan mobilmu dengan mudah. Cek tanggal jatuh tempo dan hindari denda.</p>
                </div>
            </div>

            <!-- Card 2: Bangunan -->
            <div class="relative group cursor-pointer" onclick="handleServiceClick('Pajak Bangunan')">
                 <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-[0_8px_16px_rgba(147,51,234,0.3)] z-20 group-hover:scale-110 transition-transform duration-300 border-4 border-secondary-dark">
                    <img src="{{ asset('image/home.png') }}" alt="Building" class="w-12 h-12 object-contain filter drop-shadow-md">
                </div>
                 <div class="pt-16 pb-8 px-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.2)] hover:bg-white/10 transition-all duration-300 h-full flex flex-col items-center text-center group-hover:border-white/40">
                    <h3 class="text-white text-2xl font-bold mb-4 font-manrope">Pajak Bangunan</h3>
                    <p class="text-slate-300 leading-relaxed font-light">Penuhi kewajiban pajak bangunanmu. Pastikan dokumen propertimu mutakhir dan patuh.</p>
                </div>
            </div>

            <!-- Card 3: Bumi -->
            <div class="relative group cursor-pointer" onclick="handleServiceClick('Pajak Bumi')">
                 <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center shadow-[0_8px_16px_rgba(16,185,129,0.3)] z-20 group-hover:scale-110 transition-transform duration-300 border-4 border-secondary-dark">
                    <img src="{{ asset('image/land.png') }}" alt="Land" class="w-12 h-12 object-contain filter drop-shadow-md">
                </div>
                 <div class="pt-16 pb-8 px-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.2)] hover:bg-white/10 transition-all duration-300 h-full flex flex-col items-center text-center group-hover:border-white/40">
                    <h3 class="text-white text-2xl font-bold mb-4 font-manrope">Pajak Bumi</h3>
                    <p class="text-slate-300 leading-relaxed font-light">Kelola urusan pajak tanah dengan lancar. Kontribusi dari penggunaan lahan mendukung pembangunan daerah.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function handleServiceClick(serviceName) {
        @if(auth()->check() && auth()->user()->role === 'admin')
            alert('Administrator tidak dapat mengakses fitur pengguna ini.');
        @else
            window.location.href = "{{ route('pajak') }}";
        @endif
    }
</script>
@endpush
