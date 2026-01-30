<!-- Card Grid Section -->
<section id="news" class="py-20 relative overflow-hidden bg-secondary-dark">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl md:text-5xl font-bold text-center text-white mb-12 font-baloo-bhai drop-shadow-lg">Berita Terbaru</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($cards as $card)
                <div class="card-item w-full bg-neutral-900/90 backdrop-blur-md border border-white/10 rounded-2xl overflow-hidden shadow-[4px_4px_10px_rgba(0,0,0,0.3)] hover:-translate-y-2 transition-all duration-300 cursor-pointer group hover:shadow-[8px_8px_20px_rgba(0,0,0,0.5)] flex flex-col h-full" onclick="openModal('{{ $card->title }}', '{{ $card->description }}', '{{ $card->image }}')">
                    @if($card->image)
                        <div class="overflow-hidden h-[180px]">
                            <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-full object-cover bg-slate-800 opacity-90 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500">
                        </div>
                    @else
                        <div class="h-[180px] w-full bg-slate-800 flex items-center justify-center text-slate-400">Tidak Ada Gambar</div>
                    @endif
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold text-white mb-3 font-manrope group-hover:text-blue-400 transition-colors line-clamp-2">{{ $card->title }}</h3>
                        <p class="text-slate-300 leading-relaxed line-clamp-3 text-sm flex-grow">{{ Str::limit($card->description, 100) }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between">
                            <span class="text-[10px] text-slate-400 font-mono">BACA SELENGKAPNYA</span>
                            <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-4 text-center py-20">
                    <div class="inline-block p-6 rounded-2xl bg-neutral-900/50 backdrop-blur-sm border border-white/10">
                        <h3 class="text-xl font-semibold text-white mb-2">Belum Ada Berita</h3>
                        <p class="text-slate-400">Nantikan update terbaru dari kami segera.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@push('scripts')
<script>
    function openModal(title, description, image) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalDesc').textContent = description;
        
        const imgElement = document.getElementById('modalImage');
        if (image) {
            imgElement.src = image;
            imgElement.style.display = 'block';
        } else {
            imgElement.style.display = 'none';
        }

        const modal = document.getElementById('cardModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeModal(event) {
        if (event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal-close') || event.target.closest('.modal-close')) {
            const modal = document.getElementById('cardModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); 
            document.body.style.overflow = '';
        }
    }
</script>
@endpush

<!-- Modal Structure -->
<div id="cardModal" class="modal-overlay fixed inset-0 bg-black/30 backdrop-blur-sm z-[2000] hidden flex justify-center items-center opacity-0 transition-all duration-300" onclick="closeModal(event)">
    <div class="modal-content bg-neutral-900/95 backdrop-blur-xl text-white p-10 rounded-3xl max-w-5xl w-[95%] border border-white/10 relative transform scale-95 opacity-0 transition-all duration-300 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
        <button class="modal-close absolute top-6 right-6 text-white/50 text-3xl hover:text-white transition-colors" onclick="closeModal(event)">&times;</button>
        <div class="flex flex-col lg:flex-row gap-8">
             <div class="w-full lg:w-1/2">
                <img id="modalImage" src="" alt="Modal Image" class="w-full h-[300px] lg:h-[400px] object-cover rounded-2xl bg-slate-800 shadow-2xl" style="display: none;">
             </div>
             <div class="w-full lg:w-1/2 flex flex-col">
                <h3 id="modalTitle" class="text-3xl md:text-4xl font-bold mb-6 font-manrope text-white leading-tight"></h3>
                <div class="overflow-y-auto max-h-[300px] lg:max-h-[400px] pr-2 custom-scrollbar">
                    <p id="modalDesc" class="text-slate-300 leading-relaxed font-light text-lg"></p>
                </div>
             </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #cardModal.active { opacity: 1; }
    #cardModal.active .modal-content { transform: scale(100%); opacity: 1; }
</style>
@endpush
