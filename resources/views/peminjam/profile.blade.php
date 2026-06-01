<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #EEF4EE; overflow-x: hidden; }
        .soft-shadow { box-shadow: 0 20px 50px -10px rgba(74, 107, 74, 0.25); }
        
        /* Glassmorphism Input Styling */
        .profile-input {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .profile-input:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: white;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        }
        .profile-input::placeholder { color: rgba(255, 255, 255, 0.6); }
    </style>
</head>
<body class="text-[#4A6B4A] flex flex-col min-h-screen">

   <nav class="w-full pt-6 pb-4 px-8 md:px-16 flex justify-between items-center bg-[#85A385] text-white relative z-50 shadow-sm">
        <a href="{{ route('home') }}" class="font-black text-2xl leading-tight text-white hover:text-slate-100 transition-colors">
            Perpus<br><span class="font-medium text-lg">Digital</span>
        </a>
        
        <div class="hidden md:flex space-x-10 font-semibold text-sm">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Beranda</a>
            <a href="{{ route('koleksi') }}" class="{{ request()->routeIs('koleksi') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Koleksi</a>
            <a href="{{ auth()->check() ? route('riwayat.index') : route('login') }}" class="{{ request()->routeIs('riwayat.index') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Riwayat</a>
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Tentang Kami</a>
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'border-b-2 border-white pb-1 text-white' : 'text-white/80 hover:text-white transition-colors' }}">Profile</a>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <div class="hidden md:block text-right mr-2">
                    <p class="text-sm font-bold text-[#4A6B4A]">{{ auth()->user()->NamaLengkap ?? auth()->user()->Username ?? 'Member' }}</p>
                </div>
                
                <a href="{{ auth()->user()->role === 'administrator' || auth()->user()->role === 'petugas' ? route('admin.dashboard') : route('profile') }}" 
                   class="bg-[#85A385] text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    {{ auth()->user()->role === 'peminjam' ? 'Akun Saya' : 'Dashboard' }}
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-[#85A385] text-white hover:bg-[#6B8E6B] px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md transform hover:-translate-y-1">
                    Login / Sign in
                </a>
            @endauth
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-12 w-full mt-4" data-aos="zoom-in" data-aos-duration="800">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-white border-l-4 border-[#6B8E6B] text-[#4A6B4A] font-bold rounded-xl shadow-md flex items-center gap-3">
                <span class="text-2xl">✨</span> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 font-bold rounded-xl shadow-md">
                ❌ Gagal menyimpan: {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-[#85A385] rounded-[32px] p-8 md:p-12 soft-shadow relative overflow-hidden flex flex-col md:flex-row items-center md:items-start gap-12">
            
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col md:flex-row items-center md:items-start gap-12 relative z-10">
                @csrf
                @method('PUT')

                <div class="relative group flex-shrink-0" data-aos="fade-right" data-aos-delay="300">
                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-xl bg-slate-100 relative flex items-center justify-center">
                       @if($user->FotoProfil)
                            <img id="avatarPreview" src="{{ asset('avatars/' . $user->FotoProfil) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <div id="avatarPlaceholder" class="text-slate-300 flex flex-col items-center">
                                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            </div>
                            <img id="avatarPreview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                        @endif
                        
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                            <span class="text-white font-bold text-sm text-center px-2">Klik Icon Di Bawah <br> Untuk Ganti</span>
                        </div>
                    </div>
                    
                    <input type="file" name="FotoProfil" id="fotoUpload" class="hidden" accept="image/*" onchange="previewImage(event)">
                    
                    <label for="fotoUpload" class="absolute bottom-2 right-4 bg-white text-[#4A6B4A] w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-[#EEF4EE] transition-transform transform hover:scale-110 border-2 border-[#85A385] cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </label>
                </div>

                <div class="flex-1 w-full space-y-5" data-aos="fade-left" data-aos-delay="400">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-white/80 uppercase tracking-wider ml-1">Nama Lengkap</label>
                            <input type="text" name="NamaLengkap" value="{{ old('NamaLengkap', $user->NamaLengkap) }}" class="profile-input" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-white/80 uppercase tracking-wider ml-1">Username</label>
                            <input type="text" name="Username" value="{{ old('Username', $user->Username) }}" class="profile-input" required>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-white/80 uppercase tracking-wider ml-1">Email Address</label>
                        <input type="email" name="Email" value="{{ old('Email', $user->Email) }}" class="profile-input" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-white/80 uppercase tracking-wider ml-1">Alamat Lengkap</label>
                        <textarea name="Alamat" rows="2" class="profile-input resize-none" placeholder="Masukkan alamat...">{{ old('Alamat', $user->Alamat) }}</textarea>
                    </div>

                    <div class="pt-5 border-t border-white/20 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-white/80 uppercase tracking-wider ml-1">Sandi Baru</label>
                            <input type="password" name="Password" class="profile-input" placeholder="••••••••">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-white/80 uppercase tracking-wider ml-1">Konfirmasi Sandi</label>
                            <input type="password" name="Password_confirmation" class="profile-input" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col md:flex-row justify-end gap-4">
                        <button type="submit" class="bg-white text-[#4A6B4A] hover:bg-[#EEF4EE] px-10 py-3 rounded-xl font-black text-sm transition-all shadow-xl transform hover:-translate-y-1">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <form action="{{ route('logout') }}" method="POST" class="absolute top-8 right-8">
                @csrf
                <button type="submit" class="bg-red-500/20 hover:bg-red-500 text-red-100 hover:text-white px-4 py-2 rounded-lg font-bold text-xs transition-all flex items-center gap-2 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </main>

    <section class="max-w-6xl mx-auto px-6 py-12 w-full text-center" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-4xl font-black text-[#5C805C] mb-1">Your Collections</h2>
        <p class="text-[#7DA07D] font-medium mb-12">Your saved reading collection</p>

        <div class="hidden md:grid grid-cols-12 gap-4 text-center border-b-2 border-[#C8DAC8] pb-4 mb-6 text-[#7DA07D] font-bold text-sm uppercase tracking-widest px-4">
            <div class="col-span-2">Cover</div>
            <div class="col-span-4 text-left">Judul Buku</div>
            <div class="col-span-2 text-left">Penulis</div>
            <div class="col-span-2 text-left">Penerbit</div>
            <div class="col-span-2">Aksi</div>
        </div>

        <div class="space-y-4">
            @forelse($koleksi as $item)
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-white/50 hover:bg-white p-4 rounded-2xl border border-transparent hover:border-[#C8DAC8] transition-all duration-300 shadow-sm hover:shadow-md">
                    
                    <div class="col-span-2 flex justify-center">
                        <div class="w-20 h-28 bg-slate-200 rounded-lg overflow-hidden shadow-sm">
                            @if($item->buku && $item->buku->Cover)
                                <img src="{{ asset('covers/' . $item->buku->Cover) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl opacity-20">📚</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-span-4 text-center md:text-left">
                        <h4 class="font-bold text-slate-800 text-lg leading-tight">{{ $item->buku ? $item->buku->Judul : 'Buku Tidak Tersedia' }}</h4>
                    </div>

                    <div class="col-span-2 text-center md:text-left text-sm font-semibold text-slate-600">
                        <span class="md:hidden text-xs text-slate-400 block mb-1">Penulis:</span>
                        {{ $item->buku ? $item->buku->Penulis : '-' }}
                    </div>

                    <div class="col-span-2 text-center md:text-left text-sm font-semibold text-slate-600">
                        <span class="md:hidden text-xs text-slate-400 block mb-1">Penerbit:</span>
                        {{ $item->buku ? $item->buku->Penerbit : '-' }}
                    </div>

                    {{-- PERUBAHAN: Tombol Pinjam dihapus, sisa Detail dan Hapus --}}
                    <div class="col-span-2 flex flex-col gap-2 px-4 md:px-0">
                        <a href="{{ route('buku.detail', $item->BukuID) }}" class="bg-[#85A385] hover:bg-[#6B8E6B] text-white px-4 py-2 rounded-lg text-[11px] font-bold uppercase transition-all text-center w-full">Detail</a>
                        
                        <form action="{{ route('koleksi.destroy', $item->BukuID) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin mau hapus buku ini dari koleksi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border border-red-300 text-red-500 hover:bg-red-500 hover:text-white px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase w-full transition-all text-center">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white/30 rounded-3xl border-2 border-dashed border-[#C8DAC8]">
                    <span class="text-5xl block mb-4">🔖</span>
                    <p class="text-[#7DA07D] font-bold">Belum ada buku di koleksi pribadimu.</p>
                </div>
            @endforelse
        </div>
    </section>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50 });

        // Fungsi Live Preview Foto
        function previewImage(event) {
            const reader = new FileReader();
            const output = document.getElementById('avatarPreview');
            const placeholder = document.getElementById('avatarPlaceholder');
            
            reader.onload = function() {
                output.src = reader.result;
                output.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>