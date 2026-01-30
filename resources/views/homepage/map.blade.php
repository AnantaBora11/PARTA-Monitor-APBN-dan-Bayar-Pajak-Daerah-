@php
    // Data Calculation
    $totalBudget = $projects->sum('budget');
    $totalProjects = $projects->count();
    $completedProjects = $projects->where('progress', 100)->count();
    $activeProjects = $projects->where('progress', '<', 100)->count();
    
    // Group projects
    $projectsByType = $projects->groupBy('type');
@endphp

<!-- Map Dashboard Section -->
<section id="map-section" class="relative w-full pb-20 pt-0">
    <div class="relative z-20 w-[95%] max-w-[1800px] mx-auto px-4 md:px-0">
        <div class="relative w-full rounded-[3rem] overflow-hidden shadow-2xl" 
             style="border: 3px solid transparent; 
                    background: linear-gradient(346deg, rgba(0, 0, 0, 0) 0%, rgba(50,50,50,0.5) 75%) padding-box, 
                                linear-gradient(346deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.5) 78%) border-box;">
            
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('image/pajakmu.png') }}" alt="Background Pattern" class="w-full h-full object-cover">
                <div class="absolute inset-0 backdrop-blur-sm"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-secondary-dark via-transparent to-secondary-dark opacity-10"></div>
            </div>

            <!-- Content Container -->
            <div class="relative z-20 p-8 md:p-12">
                <div class="text-center mb-10">
                    <h2 class="text-4xl md:text-5xl font-baloo-bhai font-bold text-white drop-shadow-lg mb-2">
                        LIHAT PAJAKMU KEMANA
                    </h2>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-5 flex flex-col gap-6 h-full">
                        <div class="glass-card p-4 shadow-2xl h-full flex flex-col relative overflow-hidden">
                            <div id="map" class="w-full flex-grow rounded-2xl z-[1] border border-white/10 shadow-inner min-h-[500px]"></div>
                            
                            <div class="absolute bottom-6 left-6 z-[400] flex gap-3 pointer-events-none">
                                <div class="px-4 py-2 bg-black/20 rounded-full text-white backdrop-blur-md border border-white/10 flex items-center gap-2 pointer-events-auto">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600 ring-1 ring-white/50 shadow-sm"></span>
                                    <span class="text-xs font-semibold tracking-wide">Proyek Berjalan</span>
                                </div>
                                <div class="px-4 py-2 bg-black/20 rounded-full text-white backdrop-blur-md border border-white/10 flex items-center gap-2 pointer-events-auto">
                                    <span class="w-2.5 h-2.5 rounded-full bg-green-500 ring-1 ring-white/50 shadow-sm"></span>
                                    <span class="text-xs font-semibold tracking-wide">Proyek Selesai</span>
                                </div>
                            </div>
                        </div>

                        <!-- Filter -->
                        <div class="flex overflow-x-auto gap-3 pb-3 mt-2" style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.5) rgba(0,0,0,0.3);">
                            @foreach($projectsByType->keys() as $type)
                            <button onclick="toggleFilter(this, '{{ $type }}')" class="filter-btn bg-black/50 text-white font-semibold py-3 px-6 rounded-xl backdrop-blur-md border border-white/10 transition-colors whitespace-nowrap cursor-pointer flex items-center justify-center" data-type="{{ $type }}">
                                {{ $type }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!--  STATISTICS & CATEGORIES -->
                    <div class="lg:col-span-7 flex flex-col gap-6">
                        
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Total Anggaran Card -->
                            <div class="md:w-1/3 glass-card relative overflow-hidden group">
                                <h3 class="glass-title font-manrope mb-1">Total Anggaran</h3>
                                <p class="text-3xl md:text-4xl font-baloo-bhai glass-value mb-2 leading-tight">
                                    Rp {{ number_format($totalBudget / 1000000000, 0, ',', '.') }} Milyar
                                </p>
                                <p class="glass-label text-sm mt-2">Tahun Anggaran {{ date('Y') }}</p>
                            </div>

                            <!-- Total Proyek Card -->
                            <div class="md:w-2/3 glass-card relative overflow-hidden">
                                <div class="flex items-start justify-between">
                                    <!-- Total Proyek -->
                                    <div class="flex-1">
                                        <h3 class="glass-title font-manrope mb-1">Total Proyek</h3>
                                        <p class="text-3xl md:text-4xl font-baloo-bhai glass-value leading-tight">
                                            {{ $totalProjects }}
                                        </p>
                                        <p class="glass-label text-sm mt-2">Target {{ date('Y') + 4 }}</p>
                                    </div>
                                    
                                    <!-- Berjalan -->
                                    <div class="flex-1 text-center px-4">
                                        <h3 class="glass-title font-manrope mb-1" style="font-style: normal;">Berjalan</h3>
                                        <p class="text-3xl md:text-4xl font-baloo-bhai glass-value leading-tight">
                                            {{ $activeProjects }}
                                        </p>
                                        <p class="glass-label text-sm mt-2">Quartal 3</p>
                                    </div>
                                    
                                    <!-- Selesai -->
                                    <div class="flex-1 text-center px-4">
                                        <h3 class="glass-title font-manrope mb-1" style="font-style: normal;">Selesai</h3>
                                        <p class="text-3xl md:text-4xl font-baloo-bhai glass-value leading-tight">
                                            {{ $completedProjects }}
                                        </p>
                                        <p class="glass-label text-sm mt-2">{{ date('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categories  -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-auto max-h-[400px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.4) rgba(0,0,0,0.1);">
                            @foreach($projectsByType as $type => $groupProjects)
                            @php
                                $groupBudget = $groupProjects->sum('budget');
                                $groupCount = $groupProjects->count();
                                $targetYear = date('Y') + 2; 
                            @endphp
                            <div class="glass-card flex flex-col justify-between overflow-hidden shadow-[4px_4px_10px_rgba(0,0,0,0.3)] hover:shadow-[6px_6px_15px_rgba(0,0,0,0.4)] min-h-[160px] p-5 transition-all hover:-translate-y-1">
                                <div class="flex flex-col h-full justify-between">
                                    <div class="grid grid-cols-2 text-center gap-x-4">
                                        <h4 class="glass-title text-base font-manrope leading-tight">Proyek {{ $type }}</h4>
                                        <h4 class="glass-title text-base font-manrope leading-tight" style="font-style: normal;">Total Anggaran</h4>
                                        
                                        <div class="mt-1">
                                            <span class="text-4xl font-baloo-bhai glass-value leading-none">{{ $groupCount }}</span>
                                        </div>
                                        <div class="mt-1">
                                            <span class="text-2xl font-baloo-bhai glass-value leading-none">
                                                {{ number_format($groupBudget / 1000000000, 0, ',', '.') }} M
                                            </span>
                                        </div>

                                        <span class="glass-label text-xs mt-2">Target {{ $targetYear }}</span>
                                        <span class="glass-label text-xs mt-2">Tahun {{ date('Y') }}</span>
                                    </div>
                                </div>
                                <div class="w-full bg-white/20 rounded-full h-1.5 mt-3">
                                    <div class="bg-white h-1.5 rounded-full" style="width: {{ rand(30, 90) }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([-7.797068, 110.370529], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);


        var greenIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var blueIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var projects = @json($projects);
        var markers = [];

        function addMarker(project) {
            if(project.latitude && project.longitude) {
                // Determine icon based on progress
                var icon = project.progress >= 100 ? greenIcon : blueIcon;
                var marker = L.marker([project.latitude, project.longitude], {icon: icon}).addTo(map);
                
                var imageHtml = '';
                if(project.image) {
                    imageHtml = `<img src="${project.image}" alt="${project.title}" style="width: 100%; height: 150px; object-fit: cover; display: block;">`;
                }

                // Status badge logic
                var statusColor = project.progress >= 100 ? '#22c55e' : '#3b82f6';
                var statusText = project.progress >= 100 ? 'Selesai' : 'Berjalan';
                var statusIcon = project.progress >= 100 ? '✓' : '⏳';

                // Handle text truncation
                var desc = project.description || 'Tidak ada deskripsi.';
                if(desc.length > 100) desc = desc.substring(0, 100) + '...';

                var popupContent = `
                    <div style="font-family: 'Manrope', sans-serif; width: 300px;">
                        ${imageHtml}
                        
                        <!-- Content Area with Padding -->
                        <div style="padding: 16px;">
                            <!-- Header -->
                            <div style="margin-bottom: 12px;">
                                <span style="background: ${statusColor}; color: white; padding: 4px 10px; border-radius: 99px; font-size: 0.7rem; font-weight: 700; display: inline-block; margin-bottom: 8px;">
                                    ${statusIcon} ${project.type} • ${statusText}
                                </span>
                                <h3 style="margin: 0; color: #0f172a; font-weight: 800; font-size: 1.15rem; line-height: 1.4;">${project.title}</h3>
                            </div>
                            
                            <!-- Description -->
                            <p style="margin: 0 0 16px 0; font-size: 0.85rem; color: #64748b; line-height: 1.6;">${desc}</p>
                            
                            <!-- Stats Grid -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div style="background: #f1f5f9; padding: 10px; border-radius: 8px; text-align: center;">
                                    <div style="font-size: 0.7rem; color: #64748b; margin-bottom: 2px;">Anggaran</div>
                                    <div style="font-size: 0.9rem; font-weight: 700; color: #0f172a;">Rp ${new Intl.NumberFormat('id-ID').format(project.budget / 1000000)} Jt</div>
                                </div>
                                <div style="background: #f1f5f9; padding: 10px; border-radius: 8px; text-align: center;">
                                    <div style="font-size: 0.7rem; color: #64748b; margin-bottom: 2px;">Progress</div>
                                    <div style="font-size: 0.9rem; font-weight: 700; color: ${statusColor};">${project.progress}%</div>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 99px; overflow: hidden;">
                                <div style="width: ${project.progress}%; height: 100%; background: linear-gradient(90deg, ${statusColor}, ${statusColor}dd); border-radius: 99px;"></div>
                            </div>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent, {
                    className: 'custom-popup'
                });
                
                marker.projectType = project.type;
                markers.push(marker);
            }
        }

        projects.forEach(addMarker);

        var activeFilters = new Set();

        window.toggleFilter = function(btn, type) {
            if (activeFilters.has(type)) {
                activeFilters.delete(type);
                btn.classList.remove('active-filter');
                btn.style.backgroundColor = '';
            } else {
                activeFilters.add(type);
                btn.classList.add('active-filter');
                btn.style.backgroundColor = '#FF9E16';
            }

            updateMapMarkers();
        };

        function updateMapMarkers() {
            markers.forEach(marker => {
                if (activeFilters.size === 0) {
                    if (!map.hasLayer(marker)) {
                        map.addLayer(marker);
                    }
                    marker.setOpacity(1);
                } else {
                    if (!map.hasLayer(marker)) {
                        map.addLayer(marker);
                    }
                    if (activeFilters.has(marker.projectType)) {
                        marker.setOpacity(1);
                    } else {
                        marker.setOpacity(0.3);
                    }
                }
            });
        }
        
        updateMapMarkers();
    });
</script>

<style>
    .leaflet-popup-content-wrapper {
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 0;
    }
    .leaflet-popup-content {
        margin: 16px;
    }
    .leaflet-container a.leaflet-popup-close-button {
        padding: 8px;
        color: #64748b;
    }
</style>
@endpush
