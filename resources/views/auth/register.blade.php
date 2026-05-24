<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
        }
        /* Custom scrollbar biar estetik kalau alamatnya bikin scroll */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #94B494; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#E8F0E8] min-h-screen relative text-[#4A6B4A] overflow-x-hidden">

    {{-- WALLPAPER DIAGONAL (Hanya Background, Tidak Mengganggu Konten) --}}
    <div class="hidden md:block absolute top-0 left-0 w-[50%] lg:w-[45%] h-full z-0 pointer-events-none" style="filter: drop-shadow(15px 0px 25px rgba(0,0,0,0.15));">
        <div class="w-full h-full bg-[#85A385]" style="clip-path: polygon(0 0, 100% 0, 75% 100%, 0% 100%);"></div>
    </div>

    {{-- KONTEN UTAMA (Pakai Flexbox biar nggak tabrakan kayak sebelumnya) --}}
    <div class="relative z-10 flex w-full h-screen">
        
        {{-- AREA KIRI: Teks & Ikon --}}
        <div class="hidden md:flex w-[45%] flex-col justify-between px-12 lg:px-20 py-20 text-white">
            <div>
                <h2 class="text-5xl lg:text-7xl font-bold mb-4 tracking-wide leading-tight">Hello<br>There</h2>
                <p class="text-lg lg:text-xl font-medium">Welcome to<br>Perpus Digital</p>
            </div>
            
            {{-- User Icon (Kiri Bawah) --}}
            <div class="w-40 h-40 text-black/10 mt-auto mb-10 -ml-4">
                <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
        </div>

        {{-- AREA KANAN: Form Register --}}
        <div class="w-full md:w-[55%] flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-10 overflow-y-auto">
            
            <div class="w-full max-w-xl mx-auto md:ml-0 md:mr-auto">
                
                {{-- HEADER AREA KANAN --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center w-full mb-12 gap-4">
                    <div>
                        <h3 class="text-[#4A6B4A] font-black text-2xl leading-tight">Perpus<br><span class="font-bold text-[#7DA07D]">Digital</span></h3>
                    </div>
                    <div class="text-left sm:text-right">
                        <h2 class="text-4xl font-medium text-[#4A6B4A] tracking-wide mb-2">Create Account</h2>
                        <div class="flex items-center justify-start sm:justify-end">
                            <div class="hidden sm:block h-[1px] w-20 bg-[#94B494] mr-3"></div>
                            <p class="text-sm text-[#7DA07D] font-medium">Ready to begin your journey?</p>
                        </div>
                    </div>
                </div>

                {{-- NOTIFIKASI ERROR BILA ADA --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 text-red-600 text-sm p-4 rounded-lg border-l-4 border-red-500 shadow-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM REGISTRASI --}}
                <form action="{{ route('register') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    {{-- Input: Full Name & Username --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="relative">
                            <input type="text" name="NamaLengkap" value="{{ old('NamaLengkap') }}" placeholder="Full Name" required 
                                   class="w-full bg-transparent border-b border-[#94B494] py-2 text-[#4A6B4A] placeholder-[#7DA07D] font-medium text-base outline-none focus:border-[#4A6B4A] focus:border-b-2 transition-all">
                        </div>
                        <div class="relative">
                            <input type="text" name="Username" value="{{ old('Username') }}" placeholder="Username" required 
                                   class="w-full bg-transparent border-b border-[#94B494] py-2 text-[#4A6B4A] placeholder-[#7DA07D] font-medium text-base outline-none focus:border-[#4A6B4A] focus:border-b-2 transition-all">
                        </div>
                    </div>
                    
                    {{-- Input: Email --}}
                    <div class="relative">
                        <input type="email" name="Email" value="{{ old('Email') }}" placeholder="Email Address" required 
                               class="w-full bg-transparent border-b border-[#94B494] py-2 text-[#4A6B4A] placeholder-[#7DA07D] font-medium text-base outline-none focus:border-[#4A6B4A] focus:border-b-2 transition-all">
                    </div>

                    {{-- FUNGSI BARU: Input Alamat --}}
                    <div class="relative">
                        <input type="text" name="Alamat" value="{{ old('Alamat') }}" placeholder="Full Home Address" required 
                               class="w-full bg-transparent border-b border-[#94B494] py-2 text-[#4A6B4A] placeholder-[#7DA07D] font-medium text-base outline-none focus:border-[#4A6B4A] focus:border-b-2 transition-all">
                    </div>
                    
                    {{-- Input: Password & Confirm --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="relative">
                            <input type="password" name="Password" placeholder="Password" required 
                                   class="w-full bg-transparent border-b border-[#94B494] py-2 text-[#4A6B4A] placeholder-[#7DA07D] font-medium text-base outline-none focus:border-[#4A6B4A] focus:border-b-2 transition-all">
                        </div>
                        <div class="relative">
                            <input type="password" name="Password_confirmation" placeholder="Confirm Password" required 
                                   class="w-full bg-transparent border-b border-[#94B494] py-2 text-[#4A6B4A] placeholder-[#7DA07D] font-medium text-base outline-none focus:border-[#4A6B4A] focus:border-b-2 transition-all">
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="flex justify-start sm:justify-end pt-6">
                        <button type="submit" class="w-full sm:w-auto bg-[#85A385] text-white font-medium py-3 px-14 rounded-xl shadow-lg hover:bg-[#5C805C] hover:-translate-y-1 transition-all duration-300 text-lg tracking-wide">
                            Sign Up
                        </button>
                    </div>
                </form>
                
                {{-- Link Login --}}
                <p class="text-left sm:text-right mt-10 text-sm font-semibold text-[#7DA07D]">
                    Already have an account? <a href="{{ route('login') }}" class="text-[#4A6B4A] hover:text-[#5C805C] hover:underline font-bold transition-colors">Login here</a>
                </p>

            </div>
        </div>
    </div>

</body>
</html>