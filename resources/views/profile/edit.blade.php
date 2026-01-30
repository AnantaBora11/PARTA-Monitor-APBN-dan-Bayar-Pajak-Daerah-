@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-baloo-bhai font-bold text-white">Pengaturan Profil</h1>
                <p class="text-slate-400 mt-1">Kelola informasi akun dan keamanan Anda</p>
            </div>
            <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('pajak') }}" 
               class="bg-white/10 hover:bg-white/20 border border-white/10 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all">
                &larr; Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-300 p-4 rounded-xl mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Information Card -->
        <div class="bg-neutral-900/60 backdrop-blur-xl rounded-[2rem] border border-white/10 shadow-2xl p-8 mb-6">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                Informasi Profil
            </h2>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Photo -->
                <div class="text-center mb-8">
                    <div class="w-28 h-28 rounded-full overflow-hidden mx-auto mb-4 border-4 border-blue-500/30 bg-neutral-800 flex items-center justify-center shadow-lg">
                        @if($user->profile_photo_path)
                            <img src="{{ $user->profile_photo_path }}" alt="Profile Photo" class="w-full h-full object-cover" id="profile-preview">
                        @else
                            <span class="text-4xl font-bold text-slate-400" id="profile-initial">{{ substr($user->name, 0, 1) }}</span>
                            <img src="" alt="Profile Photo" class="w-full h-full object-cover hidden" id="profile-preview">
                        @endif
                    </div>
                    <label for="profile_photo" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 cursor-pointer text-sm font-medium transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Ubah Foto Profil
                        <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </label>
                    @error('profile_photo')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full p-4 bg-black/30 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all" 
                               required>
                        @error('name') <p class="text-red-400 text-sm mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full p-4 bg-black/30 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all" 
                               required>
                        @error('email') <p class="text-red-400 text-sm mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full p-4 bg-black/30 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all" 
                               required>
                        @error('phone') <p class="text-red-400 text-sm mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="w-full mt-8 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Change Password Card -->
        <div class="bg-neutral-900/60 backdrop-blur-xl rounded-[2rem] border border-white/10 shadow-2xl p-8">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                Ubah Password
            </h2>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <!-- Current Password -->
                    <div>
                        <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Password Saat Ini</label>
                        <input type="password" name="current_password" 
                               class="w-full p-4 bg-black/30 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all" 
                               placeholder="Masukkan password saat ini"
                               required>
                        @error('current_password') <p class="text-red-400 text-sm mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- New Password -->
                        <div>
                            <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Password Baru</label>
                            <input type="password" name="password" 
                                   class="w-full p-4 bg-black/30 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all" 
                                   placeholder="Min. 8 karakter"
                                   required>
                            @error('password') <p class="text-red-400 text-sm mt-1 pl-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block mb-2 text-slate-300 text-sm font-medium pl-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full p-4 bg-black/30 border border-white/10 text-white placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all" 
                                   placeholder="Ulangi password baru"
                                   required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full mt-8 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-500/30 transition-all hover:-translate-y-1">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('profile-preview');
                var initial = document.getElementById('profile-initial');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                
                if (initial) {
                    initial.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
