<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-Government</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhai+2:wght@400..800&family=Baloo+Bhaijaan+2:wght@400..800&family=Manrope:wght@400;800&display=swap" rel="stylesheet">

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background-image: url("{{ asset('image/dashboard.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .admin-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Subtle dark overlay */
            z-index: -1;
        }
    </style>
</head>
<body class="font-sans antialiased text-white overflow-x-hidden">
    <div class="admin-overlay"></div>
    
    <!-- Topbar -->
    <!-- Custom Admin Topbar (Static Dark Glass) -->
    <nav class="fixed top-0 inset-x-0 z-50 flex items-center justify-between px-4 md:px-10 py-4 w-full bg-black/40 backdrop-blur-md shadow-lg border-b border-white/10">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-0.5 group">
            <img src="{{ asset('image/logo.png') }}" alt="Parta Logo" class="h-10 w-auto transition-transform group-hover:scale-105">
            <span class="text-white text-2xl font-manrope font-extrabold tracking-wide">PARTA</span>
        </a>
        
        <!-- Right Side -->
        <div class="flex items-center gap-6">
            @auth
                <!-- Dashboard Link -->
                <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white hover:bg-blue-700 hidden md:inline-block px-5 py-2 rounded-full font-manrope font-bold text-sm shadow-md transition-all hover:scale-105">
                    Dashboard
                </a>

                <!-- Profile Dropdown -->
                <div class="relative ml-2" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ auth()->user()->profile_photo_path }}" alt="Profile" class="w-9 h-9 rounded-full object-cover border-2 border-white/20">
                        @else
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm border-2 border-white/20">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-neutral-800 border border-white/10 rounded-xl shadow-xl py-1 z-50 origin-top-right text-slate-200"
                         style="display: none;">
                        <div class="px-4 py-3 border-b border-white/10">
                             <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                             <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white transition-colors">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/5 hover:text-red-300 transition-colors">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>


    <!-- Main Content -->
    <main class="min-h-screen pt-[80px]"> <!-- pt-20 to account for fixed topbar -->
        @yield('content')
    </main>

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Dropdown Logic (Vanilla JS Fallback)
            const dropdownData = document.querySelector('[x-data]');
            if(dropdownData) {
                const button = dropdownData.querySelector('button');
                const menu = dropdownData.querySelector('[x-show]');
                
                if(button && menu) {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
                        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                    });
                    
                    document.addEventListener('click', (e) => {
                        if (!button.contains(e.target) && !menu.contains(e.target)) {
                            menu.style.display = 'none';
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>
