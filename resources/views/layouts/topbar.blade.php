@php
    $isHome = request()->routeIs('home');
    // Base nav class - always fixed, full width
    $navClass = 'fixed top-0 inset-x-0 z-50 flex items-center justify-between px-4 md:px-10 transition-all duration-300 w-full';
    
    // Initial state classes (transparent on home at top)
    $initialClass = $isHome ? 'py-6 bg-transparent' : 'py-4 bg-white/90 backdrop-blur-md shadow-sm border-b border-slate-200';
    
    // Scrolled state classes (dark glassmorphism)
    // bg-slate-900/80 = dark background with opacity
    // backdrop-blur-md = glass effect
    $scrolledClass = 'py-4 bg-slate-900/80 backdrop-blur-md shadow-lg';
@endphp

<nav id="topbar" class="{{ $navClass }} {{ $initialClass }}" data-ishome="{{ $isHome ? 'true' : 'false' }}">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="flex items-center gap-0.5 group">
        <img src="{{ asset('image/logo.png') }}" alt="Parta Logo" class="h-12 w-auto transition-transform group-hover:scale-105">
        <span id="logo-text" class="{{ $isHome ? 'text-white' : 'text-blue-600' }} text-3xl font-manrope font-extrabold tracking-wide transition-colors duration-300">PARTA</span>
    </a>
    
    <!-- Right Side: Navbar Links + Auth Buttons -->
    <div class="flex items-center gap-6">
        <!-- Navbar Links -->
        <div id="nav-links" class="hidden md:flex items-center gap-6 font-manrope font-normal text-xl {{ $isHome ? 'text-white' : 'text-slate-900' }} transition-colors duration-300">
            <a href="{{ $isHome ? '#home' : url('/') }}" class="hover:text-blue-400 transition-colors">Home</a>
            <a href="{{ url('/#map-section') }}" class="hover:text-blue-400 transition-colors">Peta</a>
            <a href="{{ url('/#news') }}" class="hover:text-blue-400 transition-colors">Berita</a>
            <a href="{{ url('/#services') }}" class="hover:text-blue-400 transition-colors">Layanan</a>
            <a href="{{ url('/#about') }}" class="hover:text-blue-400 transition-colors">Tentang</a>
            <a href="{{ url('/#contact') }}" class="hover:text-blue-400 transition-colors">Kontak</a>
        </div>

        <!-- Auth Buttons -->
        @guest
            <a href="{{ route('login') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-6 py-2.5 rounded-full font-manrope font-extrabold shadow-md transition-all transform hover:scale-105">
                Login
            </a>
        @endguest

        @auth
            <!-- Dashboard/Pajak Link -->
            <a href="{{ auth()->user()->role === 'admin' ? url('/dashboard') : url('/pajak') }}" class="bg-blue-600 text-white hover:bg-blue-700 hidden md:inline-block px-6 py-2.5 rounded-full font-manrope font-extrabold shadow-md transition-all transform hover:scale-105">
                {{ auth()->user()->role === 'admin' ? 'Dashboard' : 'Pajak' }}
            </a>

            <!-- Profile Dropdown Trigger -->
            <div class="relative ml-2" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ auth()->user()->profile_photo_path }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-white">
                    @else
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg border-2 border-white">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50 origin-top-right"
                     style="display: none;">
                    <div class="px-4 py-2 border-b border-gray-100">
                         <p class="text-sm text-gray-700 truncate font-semibold">{{ auth()->user()->name }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const topbar = document.getElementById('topbar');
        const logoText = document.getElementById('logo-text');
        const navLinks = document.getElementById('nav-links');
        const isHome = topbar.getAttribute('data-ishome') === 'true';

        // Classes for states
        const initialClasses = 'py-6 bg-transparent'.split(' ');
        const scrolledClasses = 'py-4 bg-slate-900/80 backdrop-blur-md shadow-lg'.split(' ');
        
        // Text color classes
        const textWhite = 'text-white';
        const textDark = 'text-slate-900';
        const textBlue = 'text-blue-600';

        // Handle Scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                // Remove initial padding/bg, add scrolled padding/bg
                if (isHome) {
                     topbar.classList.remove(...initialClasses);
                     topbar.classList.add(...scrolledClasses);
                } else {
                     // For non-home pages, we can keep the white bg or switch to dark too. 
                     // User asked for "glassmorphism gelap", assuming globally or just home?
                     // Let's apply dark glass everywhere on scroll for consistency with request
                     topbar.classList.remove('bg-white/90', 'shadow-sm', 'border-slate-200');
                     topbar.classList.add(...scrolledClasses);
                     
                     // Switch text to white on scroll for non-home pages if they started dark
                     if(logoText.classList.contains(textBlue)) {
                         logoText.classList.remove(textBlue);
                         logoText.classList.add(textWhite);
                     }
                     if(navLinks.classList.contains(textDark)) {
                         navLinks.classList.remove(textDark);
                         navLinks.classList.add(textWhite);
                     }
                }
            } else {
                // Revert to top state
                if (isHome) {
                     topbar.classList.remove(...scrolledClasses);
                     topbar.classList.add(...initialClasses);
                } else {
                     topbar.classList.remove(...scrolledClasses);
                     topbar.classList.add('bg-white/90', 'shadow-sm', 'border-slate-200'); // Restore initial non-home style

                     // Restore original colors for non-home
                     if(logoText.classList.contains(textWhite)) {
                         logoText.classList.remove(textWhite);
                         logoText.classList.add(textBlue);
                     }
                     if(navLinks.classList.contains(textWhite)) {
                         navLinks.classList.remove(textWhite);
                         navLinks.classList.add(textDark);
                     }
                }
            }
        });

        // Simple dropdown toggle logic (fallback for no Alpine)
        const dropdownBtn = document.querySelector('[x-data] button');
        const dropdownMenu = document.querySelector('[x-show]');
        
        if(dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                // If Alpine is active, it handles display. If not, this simple toggle works.
                // We check computed style or inline style.
                const isHidden = getComputedStyle(dropdownMenu).display === 'none';
                dropdownMenu.style.display = isHidden ? 'block' : 'none';
            });

            document.addEventListener('click', (e) => {
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.style.display = 'none';
                }
            });
        }
    });
</script>
