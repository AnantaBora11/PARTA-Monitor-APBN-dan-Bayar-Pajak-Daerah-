<footer class="bg-blue-950 pt-16 pb-8">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <!-- Brand -->
            <div>
                 <div class="flex items-center gap-2 mb-4">
                     <img src="{{ asset('image/logo.png') }}" alt="Parta Logo" class="h-8 w-auto">
                     <span class="text-xl font-bold text-white">PARTA</span>
                 </div>
                 <p class="text-slate-300 leading-relaxed">
                     Digitalizing government services for a better future. Making tax payment and information accessible to everyone in Yogyakarta.
                 </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-bold text-white text-lg mb-4">Quick Links</h4>
                <ul class="space-y-2 text-slate-300">
                    <li><a href="{{ url('/#about') }}" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ url('/#news') }}" class="hover:text-blue-400 transition-colors">Info Pajak</a></li>
                    <li><a href="{{ url('/#contact') }}" class="hover:text-blue-400 transition-colors">Kontak</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors">Login / Register</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-bold text-white text-lg mb-4">Hubungi Kami</h4>
                <ul class="space-y-3 text-slate-300">
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <span>support@PARTA.com</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        <span>+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span>Yogyakarta, Indonesia</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-8 text-center text-slate-400 text-sm">
            &copy; {{ date('Y') }} PARTA. All rights reserved.
        </div>
    </div>
</footer>
