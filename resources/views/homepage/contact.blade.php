<!-- Contact Section -->
<section id="contact" class="relative w-full pb-20 pt-20">
    <div class="relative z-20 w-[95%] max-w-[1800px] mx-auto px-4 md:px-0">
        <div class="relative w-full rounded-[3rem] overflow-hidden shadow-2xl" 
             style="border: 3px solid transparent; 
                    background: linear-gradient(346deg, rgba(0, 0, 0, 0) 0%, rgba(50,50,50,0.5) 75%) padding-box, 
                                linear-gradient(346deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.5) 78%) border-box;">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('image/dashboard.jpg') }}" alt="Contact Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-neutral-900/40 backdrop-blur-md border border-white/10 rounded-[3rem]"></div>
            </div>
            <div class="relative z-20 p-8 md:p-12">
                <div class="text-center mb-10">
                    <h2 class="text-4xl md:text-5xl font-baloo-bhai font-bold text-white drop-shadow-lg mb-2">
                        Hubungi Kami
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                    <div class="text-white">
                        <h3 class="text-3xl font-bold mb-6 font-manrope">Tetap Terhubung</h3>
                        <p class="text-slate-300 mb-8 leading-relaxed text-lg font-light">
                            Punya pertanyaan atau saran? Kami ingin mendengar darimu. Hubungi tim kami menggunakan formulir atau detail kontak di bawah ini.
                        </p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0 border border-blue-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1 font-manrope">Alamat</h4>
                                    <p class="text-slate-300 font-light">Yogyakarta Tax Office, Jl. Panembahan Senopati No.20, Prawirodirjan, Kec. Gondomanan, Kota Yogyakarta</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center flex-shrink-0 border border-purple-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1 font-manrope">Email</h4>
                                    <p class="text-slate-300 font-light">PARTA@gmail.com</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0 border border-emerald-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1 font-manrope">Telepon</h4>
                                    <p class="text-slate-300 font-light">+62 21 1234 5678</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <form action="{{ route('contact.store') }}" method="POST" class="bg-white/5 backdrop-blur-xl p-8 rounded-[2rem] border border-white/10 shadow-2xl">
                        @csrf
                        @if(session('success'))
                            <div class="bg-green-500/20 border border-green-500/50 text-green-300 p-4 rounded-xl mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <div class="p-8 text-center text-slate-400 bg-white/5 rounded-xl border border-white/5 border-dashed">
                                <p>Administrator tidak dapat mengirim pesan kontak.</p>
                            </div>
                        @else
                            <div class="bg-white/5 p-1 rounded-2xl border border-white/10 mb-6">
                                <div class="grid grid-cols-2 gap-1 p-1 bg-black/20 rounded-xl">
                                     <button type="button" class="py-2.5 text-center text-sm font-bold text-white bg-white/10 rounded-lg shadow-sm">Pesan Biasa</button>
                                     <button type="button" class="py-2.5 text-center text-sm font-medium text-slate-400 hover:text-white transition-colors">Laporan Masalah</button>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Nama Lengkap</label>
                                <input type="text" name="name" placeholder="cth. Budi Santoso" value="{{ auth()->user()->name ?? '' }}" class="w-full p-4 bg-black/20 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all font-light" required>
                            </div>
                            <div class="mb-5">
                                <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Alamat Email</label>
                                <input type="email" name="email" placeholder="nama@email.com" value="{{ auth()->user()->email ?? '' }}" class="w-full p-4 bg-black/20 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all font-light" required>
                            </div>
                            <div class="mb-8">
                                <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Isi Pesan</label>
                                <textarea name="message" rows="4" placeholder="Tulis pesanmu disini..." class="w-full p-4 bg-black/20 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all font-light resize-none" required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1">Kirim Pesan</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
