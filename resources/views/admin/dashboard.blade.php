@extends('layouts.admin')

@push('styles')
<style>
    /* Fixed Sidebar Styles */
    .admin-sidebar {
        position: fixed;
        top: 80px; /* Below Topbar */
        left: 0;
        bottom: 0;
        width: 280px;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(12px);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        padding: 2rem 1.5rem;
        z-index: 40;
        overflow-y: auto;
    }

    .sidebar-menu { list-style: none; padding: 0; }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 1rem 1.5rem;
        color: rgba(255, 255, 255, 0.7);
        border-radius: 12px;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        font-family: 'Manrope', sans-serif;
        text-decoration: none;
        border: 1px solid transparent;
    }

    .sidebar-link:hover, .sidebar-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transform: translateX(5px);
    }
    
    .sidebar-link.active {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0) 100%);
        border-left: 3px solid #3b82f6;
    }

    /* Main Content Styles */
    .admin-content {
        margin-left: 280px; /* Width of sidebar */
        padding: 2rem;
        min-height: calc(100vh - 80px);
    }

    .section-content { display: none; animation: fadeIn 0.4s ease-out; }
    .section-content.active { display: block; }

    /* Dark Glass Card */
    .glass-panel {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    /* Form Elements */
    .glass-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(0, 0, 0, 0.4); /* Darker base for "Gelap" request */
        backdrop-filter: blur(19px);
        -webkit-backdrop-filter: blur(19px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px; /* User spec */
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(255, 255, 255, 0.1),
            inset 0 0 8px 4px rgba(255, 255, 255, 0.05);
        color: white;
        transition: all 0.3s;
    }
    .glass-input:focus {
        background: rgba(0, 0, 0, 0.6);
        border-color: rgba(59, 130, 246, 0.5);
        outline: none;
        box-shadow: 
            0 0 0 3px rgba(59, 130, 246, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* Custom Scrollbar for Sidebar */
    .admin-sidebar::-webkit-scrollbar { width: 6px; }
    .admin-sidebar::-webkit-scrollbar-track { background: transparent; }
    .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 3px; }
    .admin-sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }

    /* Hide Search Icon on Type & Shift Padding */
    .glass-input:not(:placeholder-shown) ~ span {
        display: none;
    }
    
    .search-input {
        padding-left: 3rem; /* Space for icon */
        transition: padding-left 0.2s ease;
    }
    
    .search-input:not(:placeholder-shown) {
        padding-left: 1rem; /* Reset padding when typing */
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<!-- Fixed Sidebar -->
<aside class="admin-sidebar">
    <div class="mb-8 px-4">
        <h2 class="text-2xl font-bold text-white font-baloo-bhai">Admin Panel</h2>
        <p class="text-xs text-slate-400 mt-1">Kelola Konten & Data</p>
    </div>
    <ul class="sidebar-menu">
        <li onclick="showSection('apbd')" id="link-apbd" class="sidebar-link active">
             <span class="mr-3">📊</span> Data APBD
        </li>
        <li onclick="showSection('kendaraan')" id="link-kendaraan" class="sidebar-link">
             <span class="mr-3">🚗</span> Data Kendaraan
        </li>
        <li onclick="showSection('users')" id="link-users" class="sidebar-link">
             <span class="mr-3">👤</span> Data User
        </li>
        <li onclick="showSection('content')" id="link-content" class="sidebar-link">
            <span class="mr-3">📝</span> Manajemen Konten
        </li>
        <li onclick="showSection('projects')" id="link-projects" class="sidebar-link">
            <span class="mr-3">🏗️</span> Proyek Pemerintah
        </li>
        <li onclick="showSection('comments')" id="link-comments" class="sidebar-link">
            <span class="mr-3">💬</span> Saran & Masukan
        </li>
    </ul>
</aside>

<!-- Main Content Area -->
<div class="admin-content">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-400 flex items-center gap-3 backdrop-blur-sm shadow-lg animate-fade-in-down">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-400 backdrop-blur-sm shadow-lg animate-fade-in-down">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- APBD Section (New Default) -->
    <div id="section-apbd" class="section-content active">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
            <h2 class="text-3xl font-bold text-white font-manrope">Visualisasi Data APBD</h2>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Total Anggaran -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full bg-gradient-to-br from-blue-600/20 to-transparent">
                <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Total Anggaran (APBD)</p>
                    <h3 class="text-3xl font-bold text-white font-mono">Rp {{ number_format($totalAPBD, 0, ',', '.') }}</h3>
                </div>
                 <div class="text-xs text-blue-300 bg-blue-500/10 py-1 px-2 rounded-lg self-start">
                     Terakumulasi dari proyek
                 </div>
            </div>
            
            <!-- Total Proyek -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full">
                 <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Total Proyek</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $projects->count() }}</h3>
                </div>
                <div class="text-xs text-white bg-white/10 py-1 px-2 rounded-lg self-start">
                     Semua Status
                 </div>
            </div>

            <!-- Proyek Berjalan -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full">
                 <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Proyek Berjalan</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $activeProjectsCount }}</h3>
                </div>
                <div class="text-xs text-blue-300 bg-blue-500/10 py-1 px-2 rounded-lg self-start">
                     On Progress
                 </div>
            </div>

            <!-- Proyek Selesai -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full">
                 <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Proyek Selesai</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $completedProjectsCount }}</h3>
                </div>
                <div class="text-xs text-emerald-300 bg-emerald-500/10 py-1 px-2 rounded-lg self-start">
                     Completed
                 </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <div class="glass-panel p-8">
                <h4 class="text-lg font-bold text-white mb-6">Progress Proyek per Bulan</h4>
                <div class="relative h-64 w-full">
                     <canvas id="progressChart"></canvas>
                </div>
            </div>
             <div class="glass-panel p-8">
                <h4 class="text-lg font-bold text-white mb-6">Distribusi Proyek</h4>
                 <div class="relative h-64 w-full flex items-center justify-center">
                     <canvas id="distributionChart"></canvas> <!-- Placeholder for potential second chart or keep as is -->
                </div>
            </div>
        </div>

        <!-- Detailed Table Section -->
        <div class="glass-panel p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <h4 class="text-xl font-bold text-white">Rincian Data Proyek & Anggaran</h4>
                
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Category Filter -->
                    <select id="apbdFilterCategory" class="glass-input w-full md:w-48 appearance-none cursor-pointer" onchange="filterApbdTable()">
                        <option value="all" class="text-slate-800">Semua Kategori</option>
                        @foreach($budgetByType->keys() as $type)
                            <option value="{{ $type }}" class="text-slate-800">{{ $type }}</option>
                        @endforeach
                    </select>

                    <!-- Search Input -->
                    <div class="relative w-full md:w-64">
                         <input type="text" id="apbdSearch" placeholder="Cari nama proyek..." class="glass-input search-input" onkeyup="filterApbdTable()">
                         <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">🔍</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto overflow-y-auto max-h-[500px] rounded-xl border border-white/10">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-neutral-900 text-white uppercase font-bold text-xs sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4">Nama Proyek</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Anggaran (IDR)</th>
                            <th class="px-6 py-4 text-center">Progres</th>
                            <th class="px-6 py-4 text-center">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody id="apbdTableBody" class="divide-y divide-white/5">
                        @forelse($projects as $project)
                            <tr class="apbd-row hover:bg-white/5 transition-colors" data-category="{{ $project->type }}">
                                <td class="px-6 py-4 font-medium text-white">{{ $project->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-md text-xs font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                        {{ $project->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono text-emerald-400">
                                    Rp {{ number_format($project->budget, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                     <div class="flex items-center gap-2">
                                        <div class="w-full bg-white/10 rounded-full h-1.5 flex-1">
                                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold">{{ $project->progress }}%</span>
                                     </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $project->latitude }},{{ $project->longitude }}" target="_blank" class="text-slate-400 hover:text-white transition-colors" title="Lihat di Google Maps">
                                        📍
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic">Belum ada data proyek.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kendaraan Section -->
    <div id="section-kendaraan" class="section-content">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
            <h2 class="text-3xl font-bold text-white font-manrope">Visualisasi Data Kendaraan</h2>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <!-- Total Kendaraan -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full bg-gradient-to-br from-blue-600/20 to-transparent">
                <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Total Kendaraan Terdaftar</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $totalVehicles }}</h3>
                </div>
                <div class="text-xs text-blue-300 bg-blue-500/10 py-1 px-2 rounded-lg self-start">
                    Database Samsat
                </div>
            </div>
            
            <!-- Pajak Belum Lunas -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full bg-gradient-to-br from-red-600/20 to-transparent">
                <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Pajak Belum Lunas</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $unpaidTaxesCount }}</h3>
                </div>
                <div class="text-xs text-red-300 bg-red-500/10 py-1 px-2 rounded-lg self-start">
                    Perlu Tindak Lanjut
                </div>
            </div>

            <!-- Total Denda -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full bg-gradient-to-br from-yellow-600/20 to-transparent">
                <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Akumulasi Denda</p>
                    <h3 class="text-3xl font-bold text-white font-mono text-xl">Rp {{ number_format($totalFines, 0, ',', '.') }}</h3>
                </div>
                <div class="text-xs text-yellow-300 bg-yellow-500/10 py-1 px-2 rounded-lg self-start">
                    Potensi Pendapatan
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="glass-panel p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <h4 class="text-xl font-bold text-white">Daftar Pajak Kendaraan</h4>
                <div class="relative w-full md:w-64">
                    <input type="text" id="vehicleSearch" placeholder="Cari nopol atau pemilik..." class="glass-input search-input" onkeyup="filterVehicleTable()">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">🔍</span>
                </div>
            </div>

            <div class="overflow-x-auto overflow-y-auto max-h-[500px] rounded-xl border border-white/10">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-neutral-900 text-white uppercase font-bold text-xs sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4">Nomor Polisi</th>
                            <th class="px-6 py-4">Pemilik</th>
                            <th class="px-6 py-4">Kendaraan</th>
                            <th class="px-6 py-4 text-center">Jenis</th>
                            <th class="px-6 py-4 text-center">Tahun</th>
                            <th class="px-6 py-4 text-center">Jatuh Tempo</th>
                            <th class="px-6 py-4 text-right">Denda</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="vehicleTableBody" class="divide-y divide-white/5">
                        @foreach($vehicles as $v)
                            @php $pajakLatest = $v->pajak->sortByDesc('tahun_pajak')->first(); @endphp
                            <tr class="vehicle-row hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-white uppercase">{{ $v->nomor_polisi }}</td>
                                <td class="px-6 py-4">{{ $v->nama_pemilik }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-white font-medium">{{ $v->merk }}</div>
                                    <div class="text-xs text-slate-400">{{ $v->tipe_model }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold {{ $v->jenis_kendaraan === 'Mobil' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 'bg-purple-500/20 text-purple-400 border border-purple-500/30' }}">
                                        {{ $v->jenis_kendaraan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">{{ $v->tahun_pembuatan }}</td>
                                <td class="px-6 py-4 text-center text-xs">
                                    @if($pajakLatest && $pajakLatest->tanggal_jatuh_tempo)
                                        @php 
                                            $dueDate = \Carbon\Carbon::parse($pajakLatest->tanggal_jatuh_tempo);
                                            $isOverdue = $dueDate->isPast() && ($pajakLatest->status_pembayaran ?? '') !== 'Lunas';
                                        @endphp
                                        <span class="{{ $isOverdue ? 'text-red-400' : 'text-slate-300' }}">
                                            {{ $dueDate->format('d/m/Y') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-mono {{ ($pajakLatest->status_pembayaran ?? '') === 'Lunas' ? 'text-slate-500' : 'text-yellow-400' }}">
                                    @if(($pajakLatest->status_pembayaran ?? '') === 'Lunas')
                                        Rp 0
                                    @else
                                        Rp {{ number_format($pajakLatest->denda ?? 0, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if(($pajakLatest->status_pembayaran ?? '') === 'Lunas')
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">LUNAS</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-red-500/20 text-red-400 border border-red-500/30">BELUM LUNAS</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- User Management Section -->
    <div id="section-users" class="section-content">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
            <h2 class="text-3xl font-bold text-white font-manrope">Manajemen User</h2>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <!-- Total User -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full bg-gradient-to-br from-indigo-600/20 to-transparent">
                <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Total User Terdaftar</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $totalUsers }}</h3>
                </div>
                <div class="text-xs text-indigo-300 bg-indigo-500/10 py-1 px-2 rounded-lg self-start">
                    Akun Aktif
                </div>
            </div>
            
            <!-- Admin Count -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full bg-gradient-to-br from-amber-600/20 to-transparent">
                <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">Administrator</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $adminCount }}</h3>
                </div>
                <div class="text-xs text-amber-300 bg-amber-500/10 py-1 px-2 rounded-lg self-start">
                    Hak Akses Penuh
                </div>
            </div>

            <!-- Regular User Count -->
            <div class="glass-panel p-6 flex flex-col justify-between h-full bg-gradient-to-br from-emerald-600/20 to-transparent">
                <div class="mb-4">
                    <p class="text-slate-300 text-sm font-medium mb-1">User Reguler</p>
                    <h3 class="text-3xl font-bold text-white font-manrope">{{ $regularUserCount }}</h3>
                </div>
                <div class="text-xs text-emerald-300 bg-emerald-500/10 py-1 px-2 rounded-lg self-start">
                    Pengguna Publik
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="glass-panel p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <h4 class="text-xl font-bold text-white">Daftar User</h4>
                <div class="relative w-full md:w-64">
                    <input type="text" id="userSearch" placeholder="Cari nama atau email..." class="glass-input search-input" onkeyup="filterUserTable()">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">🔍</span>
                </div>
            </div>

            <div class="overflow-x-auto overflow-y-auto max-h-[500px] rounded-xl border border-white/10">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-neutral-900 text-white uppercase font-bold text-xs sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4">Foto</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">NIK</th>
                            <th class="px-6 py-4">Email / Telepon</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="divide-y divide-white/5">
                        @foreach($users as $user)
                            <tr class="user-row hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30 overflow-hidden">
                                        @if($user->profile_photo_path)
                                            <img src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-indigo-300 font-bold">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-white font-medium">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">UID: #{{ $user->id }}</div>
                                </td>
                                <td class="px-6 py-4 font-mono">{{ $user->nik ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-slate-300">{{ $user->email }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->phone ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 capitalize">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold {{ $user->role === 'admin' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-blue-500/20 text-blue-400 border border-blue-500/30' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                        <span class="text-emerald-400 text-xs font-medium">Aktif</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-xs">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Content Management Section -->
    <div id="section-content" class="section-content">
         <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
             <h2 class="text-3xl font-bold text-white font-manrope">Manajemen Konten</h2>
         </div>
         
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- About Us Management -->
            <div class="glass-panel p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span>🏢</span> Edit Tentang Kami
                </h3>
                <form action="{{ route('dashboard.updateAbout') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block mb-2 text-sm text-slate-300 font-medium">Konten Deskripsi</label>
                        <textarea name="about_us" rows="6" class="glass-input" required>{{ $about->value }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold shadow-lg transition-all hover:shadow-blue-500/30">Simpan Perubahan</button>
                </form>
            </div>

            <!-- Add New Card -->
            <div class="glass-panel p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span>📰</span> Tambah Berita Baru
                </h3>
                <form action="{{ route('dashboard.storeCard') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm text-slate-300 font-medium">Judul Berita</label>
                        <input type="text" name="title" class="glass-input" required placeholder="Masukkan judul berita...">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm text-slate-300 font-medium">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" class="glass-input" required placeholder="Tuliskan ringkasan berita..."></textarea>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm text-slate-300 font-medium">Gambar Cover (Max 2MB)</label>
                        <input type="file" name="image" accept="image/*" class="glass-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-bold shadow-lg transition-all hover:shadow-emerald-500/30">Tambah Berita</button>
                </form>
            </div>
        </div>

        <!-- Existing Cards List -->
        <div class="glass-panel p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b border-white/10 pb-4">
                <h3 class="text-xl font-bold text-white">Daftar Berita Aktif</h3>
                <div class="relative w-full md:w-64">
                    <input type="text" id="newsSearch" placeholder="Cari berita..." class="glass-input search-input" onkeyup="filterNews()">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">🔍</span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cards as $card)
                    <div class="bg-black/40 rounded-2xl overflow-hidden border border-white/10 group hover:border-white/30 transition-all hover:-translate-y-1 news-card">
                        @if($card->image)
                            <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-40 object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        @else
                            <div class="w-full h-40 bg-white/5 flex items-center justify-center text-slate-500">No Image</div>
                        @endif
                        <div class="p-5">
                            <h4 class="text-white font-bold mb-2 line-clamp-1 news-title">{{ $card->title }}</h4>
                            <p class="text-slate-400 text-sm mb-4 line-clamp-2 h-10">{{ $card->description }}</p>
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('dashboard.editCard', $card->id) }}" class="px-3 py-1.5 rounded-lg border border-blue-500/50 text-blue-400 hover:bg-blue-500/20 text-xs transition-colors">Edit</a>
                                <form action="{{ route('dashboard.deleteCard', $card->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg border border-red-500/50 text-red-400 hover:bg-red-500/20 text-xs transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Projects Section -->
    <div id="section-projects" class="section-content">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-4 border-b border-white/10">
            <h2 class="text-3xl font-bold text-white font-manrope">Proyek Pemerintah</h2>
            
            <div class="flex flex-wrap gap-3 items-center">
                <!-- Category Filter -->
                <div class="w-full sm:w-44">
                    <select id="projectFilterCategory" class="glass-input w-full appearance-none cursor-pointer py-2" onchange="filterProjects()">
                        <option value="all" class="text-slate-800">Semua Kategori</option>
                        @foreach($budgetByType->keys() as $type)
                            <option value="{{ $type }}" class="text-slate-800">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Project Search -->
                <div class="relative w-full sm:w-64">
                    <input type="text" id="projectSearch" placeholder="Cari proyek..." class="glass-input search-input pl-10 py-2" onkeyup="filterProjects()">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">🔍</span>
                </div>

                <button onclick="openProjectModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-full font-bold shadow-lg transition-all hover:scale-105 flex items-center gap-2 whitespace-nowrap">
                    <span>+</span> Proyek Baru
                </button>
            </div>
        </div>
        
        <!-- Existing Projects List -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="projectsGrid">
            @foreach($projects as $project)
                <div class="glass-panel overflow-hidden group hover:border-white/30 transition-all project-card">
                    @if($project->image)
                        <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-48 object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                    @else
                        <div class="w-full h-48 bg-white/5 flex items-center justify-center text-slate-500">Tidak Ada Gambar</div>
                    @endif
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="text-lg font-bold text-white leading-tight project-title">{{ $project->title }}</h4>
                            <span class="bg-blue-500/20 text-blue-300 text-xs px-2.5 py-1 rounded-full border border-blue-500/30">{{ $project->type }}</span>
                        </div>
                        <p class="text-slate-300 text-sm mb-6 line-clamp-2">{{ Str::limit($project->description, 80) }}</p>
                        
                        <div class="bg-black/30 rounded-xl p-4 mb-4 border border-white/5">
                            <div class="flex justify-between mb-2 text-sm">
                                <span class="text-slate-400">Anggaran</span>
                                <span class="text-emerald-400 font-mono">Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mb-2 text-sm">
                                <span class="text-slate-400">Progres</span>
                                <span class="text-blue-400 font-bold">{{ $project->progress }}%</span>
                            </div>
                            <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                                <div style="width: {{ $project->progress }}%;" class="h-full bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                            </div>
                        </div>

                        <div class="flex gap-2 justify-end pt-2 border-t border-white/5">
                             <button onclick='openProjectModal(@json($project))' class="px-4 py-2 rounded-lg bg-white/5 hover:bg-blue-600/20 text-blue-300 hover:text-blue-200 text-sm transition-all border border-transparent hover:border-blue-500/30">Edit Data</button>
                            <form action="{{ route('dashboard.deleteProject', $project->id) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 rounded-lg bg-white/5 hover:bg-red-600/20 text-red-300 hover:text-red-200 text-sm transition-all border border-transparent hover:border-red-500/30">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Project Modal (Redesigned) -->
    <div id="projectModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[2000] hidden items-center justify-center p-4 transition-all" onclick="closeProjectModal(event)">
        <div class="glass-panel w-full max-w-4xl max-h-[90vh] overflow-y-auto relative animate-fade-in-up border-white/20 shadow-2xl bg-neutral-900/95">
            <div class="p-8">
                <button onclick="closeProjectModal(event)" class="absolute top-6 right-6 text-slate-400 hover:text-white text-2xl transition-colors">&times;</button>
                <h3 id="modalTitle" class="text-2xl font-bold text-white mb-8 pb-4 border-b border-white/10 font-manrope">Tambah Proyek Baru</h3>
                
                <form id="projectForm" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">
                    
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm text-slate-300">Judul Proyek</label>
                        <input type="text" name="title" id="pTitle" class="glass-input" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm text-slate-300">Deskripsi Detail</label>
                        <textarea name="description" id="pDescription" rows="3" class="glass-input" required></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-slate-300">Estimasi Biaya (IDR)</label>
                        <!-- Hidden input for actual numeric value -->
                        <input type="hidden" name="budget" id="pBudgetHidden">
                        <!-- Text input for display with formatting -->
                        <input type="text" id="pBudgetDisplay" class="glass-input" required placeholder="0">
                    </div>
                     <div>
                        <label class="block mb-2 text-sm text-slate-300">Progres Saat Ini (%)</label>
                        <input type="number" min="0" max="100" name="progress" id="pProgress" class="glass-input" required>
                    </div>
                     <div>
                        <label class="block mb-2 text-sm text-slate-300">Kategori / Tipe</label>
                        <input type="text" name="type" id="pType" placeholder="e.g. Infrastruktur" class="glass-input" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-slate-300">Update Gambar</label>
                        <input type="file" name="image" accept="image/*" class="glass-input file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-white/10 file:text-white hover:file:bg-white/20">
                        <small id="imageHint" class="text-slate-500 text-xs mt-1 block hidden">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-slate-300">Latitude</label>
                         <input type="text" name="latitude" id="input-lat" placeholder="-7.7956" class="glass-input" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-slate-300">Longitude</label>
                         <input type="text" name="longitude" id="input-lng" placeholder="110.3695" class="glass-input" required>
                    </div>
                    
                    <!-- Map Picker -->
                    <div class="md:col-span-2 bg-black/20 p-4 rounded-xl border border-white/5">
                        <label class="block mb-3 text-sm font-bold text-blue-400">📍 Pilih Lokasi Proyek</label>
                        <div id="admin-map" class="w-full h-[300px] rounded-lg border border-white/10 z-10"></div>
                        <p class="text-xs text-slate-400 mt-2 text-center">Klik pada peta untuk menentukan titik lokasi otomatis.</p>
                    </div>

                     <div class="md:col-span-2 mt-4">
                        <button type="submit" id="submitBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold shadow-lg transition-all">Simpan Data Proyek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Comments Section -->
    <div id="section-comments" class="section-content">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
            <h2 class="text-3xl font-bold text-white font-manrope">Kritik & Saran Masuk</h2>
        </div>
        
        <div class="glass-panel p-6">
        <div class="glass-panel p-6">
            <div class="mb-6 relative w-full md:w-96 mx-auto">
                <input type="text" id="commentSearch" placeholder="🔍 Cari pengirim atau isi pesan..." class="glass-input search-input pl-4 w-full" onkeyup="filterComments()">
            </div>

            <div class="overflow-x-auto rounded-xl border border-white/10">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-white/5 text-white uppercase font-bold text-xs">
                        <tr>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Pengirim</th>
                            <th class="px-6 py-4">Isi Pesan</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="commentsTableBody" class="divide-y divide-white/5">
                        @forelse($messages as $message)
                            <tr class="comment-row hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $message->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white">{{ $message->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $message->email }}</div>
                                </td>
                                <td class="px-6 py-4 max-w-md truncate">{{ Str::limit($message->message, 80) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('dashboard.deleteMessage', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini selamanya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 hover:underline text-xs bg-red-500/10 px-3 py-1.5 rounded-full border border-red-500/20 transition-all">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500 italic">Belum ada pesan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    // Initialize Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctxProgress = document.getElementById('progressChart');
        if(ctxProgress) {
            new Chart(ctxProgress, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlyProgressLabels) !!},
                    datasets: [{
                        label: 'Rata-rata Progress (%)',
                        data: {!! json_encode($monthlyProgressValues) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                         y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            ticks: { color: 'white' }
                        },
                        x: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: 'white' }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: 'white',
                                font: {
                                    family: 'Manrope'
                                }
                            }
                        }
                    }
                }
            });
        }

        const ctxDist = document.getElementById('distributionChart');
        if(ctxDist) {
            new Chart(ctxDist, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($projectsCntByType->keys()) !!},
                    datasets: [{
                        label: 'Jumlah Proyek',
                        data: {!! json_encode($projectsCntByType->values()) !!},
                        backgroundColor: 'rgba(56, 189, 248, 0.6)',
                        borderColor: 'rgba(56, 189, 248, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            ticks: { color: 'white', stepSize: 1 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: 'white' }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });

    function filterApbdTable() {
        const searchText = document.getElementById('apbdSearch').value.toLowerCase();
        const categoryFilter = document.getElementById('apbdFilterCategory').value;
        const rows = document.querySelectorAll('.apbd-row');

        rows.forEach(row => {
            // Get data
            const projectName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const projectCategory = row.getAttribute('data-category');
            
            // Check matches
            const matchesSearch = projectName.includes(searchText);
            const matchesCategory = categoryFilter === 'all' || projectCategory === categoryFilter;

            // Toggle visibility
            if (matchesSearch && matchesCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    function filterProjects() {
        const input = document.getElementById('projectSearch');
        const categorySelect = document.getElementById('projectFilterCategory');
        const filter = input.value.toLowerCase();
        const selectedCategory = categorySelect.value;
        const cards = document.getElementsByClassName('project-card');

        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            const title = card.querySelector('.project-title').textContent.toLowerCase();
            const categoryBadge = card.querySelector('.bg-blue-500\\/20');
            const cardCategory = categoryBadge ? categoryBadge.textContent.trim() : '';

            const matchesSearch = title.includes(filter);
            const matchesCategory = selectedCategory === 'all' || cardCategory === selectedCategory;

            if (matchesSearch && matchesCategory) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        }
    }

    function filterComments() {
        const input = document.getElementById('commentSearch');
        const filter = input.value.toLowerCase();
        const rows = document.getElementsByClassName('comment-row');

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const name = row.getElementsByTagName('td')[1].textContent.toLowerCase();
            const message = row.getElementsByTagName('td')[2].textContent.toLowerCase();

            if (name.includes(filter) || message.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }

    function filterVehicleTable() {
        const input = document.getElementById('vehicleSearch');
        const filter = input.value.toLowerCase();
        const rows = document.getElementsByClassName('vehicle-row');

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const nopol = row.getElementsByTagName('td')[0].textContent.toLowerCase();
            const owner = row.getElementsByTagName('td')[1].textContent.toLowerCase();
            const car = row.getElementsByTagName('td')[2].textContent.toLowerCase();

            if (nopol.includes(filter) || owner.includes(filter) || car.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }

    function filterUserTable() {
        const input = document.getElementById('userSearch');
        const filter = input.value.toLowerCase();
        const rows = document.getElementsByClassName('user-row');

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const name = row.getElementsByTagName('td')[1].textContent.toLowerCase();
            const email = row.getElementsByTagName('td')[3].textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }

    function filterNews() {
        const input = document.getElementById('newsSearch');
        const filter = input.value.toLowerCase();
        const cards = document.getElementsByClassName('news-card');

        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            const title = card.querySelector('.news-title').textContent.toLowerCase();

            if (title.includes(filter)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        }
    }

    // Money Formatter
    const budgetDisplay = document.getElementById('pBudgetDisplay');
    const budgetHidden = document.getElementById('pBudgetHidden');

    if(budgetDisplay) {
        budgetDisplay.addEventListener('keyup', function(e) {
            // Format display
            let val = this.value.replace(/[^0-9]/g, '');
            let formatted = new Intl.NumberFormat('id-ID').format(val);
            this.value = formatted === '0' ? '' : formatted;
            
            // Set hidden true value
            budgetHidden.value = val;
        });
    }

    // Map Variables
    let map;
    let marker;

    function initMap() {
        // Yogyakarta Center
        map = L.map('admin-map').setView([-7.7956, 110.3695], 13);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Click Event
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            updateMarker(lat, lng);
        });
        
        // Global reference for resizing if needed
        window.adminMap = map; 
    }

    function updateMarker(lat, lng) {
        document.getElementById('input-lat').value = lat;
        document.getElementById('input-lng').value = lng;

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
    }

    function openProjectModal(project = null) {
        const modal = document.getElementById('projectModal');
        const form = document.getElementById('projectForm');
        const title = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        const submitBtn = document.getElementById('submitBtn');
        const imageHint = document.getElementById('imageHint');
        const pBudgetDisplay = document.getElementById('pBudgetDisplay');
        const pBudgetHidden = document.getElementById('pBudgetHidden');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        if (project) {
            // Edit Mode
            title.textContent = 'Edit Data Proyek';
            form.action = `/dashboard/project/${project.id}`;
            methodField.value = 'PUT';
            submitBtn.textContent = 'Simpan Perubahan';
            imageHint.classList.remove('hidden');

            document.getElementById('pTitle').value = project.title;
            document.getElementById('pDescription').value = project.description;
            
            // Set Money Values
            pBudgetHidden.value = project.budget;
            pBudgetDisplay.value = new Intl.NumberFormat('id-ID').format(project.budget);
            
            document.getElementById('pProgress').value = project.progress;
            document.getElementById('pType').value = project.type;
            
            // Map handling
            setTimeout(() => {
                map.invalidateSize();
                if(project.latitude && project.longitude) {
                    updateMarker(project.latitude, project.longitude);
                    map.setView([project.latitude, project.longitude], 13);
                } else {
                    if(marker) map.removeLayer(marker);
                    marker = null;
                    map.setView([-7.7956, 110.3695], 13);
                }
            }, 200);

        } else {
            // Create Mode
            title.textContent = 'Tambah Proyek Baru';
            form.action = "{{ route('dashboard.storeProject') }}";
            methodField.value = 'POST';
            submitBtn.textContent = 'Simpan Proyek Baru';
            imageHint.classList.add('hidden');
            
            form.reset();
            pBudgetHidden.value = ''; // Ensure hidden is clear

            // Map handling
            setTimeout(() => {
                map.invalidateSize();
                if(marker) map.removeLayer(marker);
                marker = null;
                map.setView([-7.7956, 110.3695], 13);
                document.getElementById('input-lat').value = '';
                document.getElementById('input-lng').value = '';
            }, 200);
        }
    }

    function closeProjectModal(e) {
        if (e.target.id === 'projectModal' || e.target.tagName === 'BUTTON') {
             const modal = document.getElementById('projectModal');
             modal.classList.add('hidden');
             modal.classList.remove('flex');
        }
    }

    function showSection(sectionId) {
        document.querySelectorAll('.section-content').forEach(section => {
            section.classList.remove('active');
        });
        
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.classList.remove('active');
        });

        document.getElementById('section-' + sectionId).classList.add('active');
        document.getElementById('link-' + sectionId).classList.add('active');
        
        if(sectionId === 'projects' && map) {
            setTimeout(() => { map.invalidateSize(); }, 100);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        if (section) {
            showSection(section);
        }
    });
</script>
@endsection
