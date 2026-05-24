<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-[#F4F9F4] min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Container Utama -->
    <div class="relative w-full max-w-4xl h-[500px] flex items-center justify-center px-4">
        
        <!-- Form membungkus kedua card agar input dan button saling terhubung -->
        <form action="{{ route('login') }}" method="POST" class="relative w-full h-full flex items-center">
            @csrf
            
            <!-- KARTU BELAKANG (Hijau Tua) -->
            <div class="absolute left-0 md:left-[10%] w-[90%] md:w-[60%] h-[380px] bg-[#85A385] rounded-l-3xl p-10 text-white z-10 shadow-xl flex flex-col justify-center">
                <h2 class="text-4xl font-extrabold mb-1">Hello There</h2>
                <p class="text-lg font-medium mb-8 border-b border-white/40 pb-2 inline-block">Welcome to Perpus Digital</p>
                
                @if(session('error'))
                    <div class="bg-red-500/20 text-red-100 text-sm p-2 rounded mb-4">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="bg-green-500/20 text-green-100 text-sm p-2 rounded mb-4">{{ session('success') }}</div>
                @endif

                <!-- Input Fields (Minimalist Line Design) -->
                <div class="space-y-6 w-3/4">
                    <div class="relative border-b border-white/50 focus-within:border-white transition-colors">
                        <input type="email" name="email" placeholder="Email" required class="w-full bg-transparent outline-none text-white placeholder-white/70 py-1 text-sm font-medium">
                    </div>
                    <div class="relative border-b border-white/50 focus-within:border-white transition-colors">
                        <input type="password" name="password" placeholder="Password" required class="w-full bg-transparent outline-none text-white placeholder-white/70 py-1 text-sm font-medium">
                    </div>
                </div>
            </div>

            <!-- KARTU DEPAN (Hijau Muda, Numpuk di Kanan) -->
            <div class="absolute right-0 md:right-[15%] w-[80%] md:w-[320px] h-[460px] bg-[#E8F0E8] rounded-2xl shadow-2xl z-20 p-8 flex flex-col items-center justify-between border border-white/50 transform transition-transform hover:scale-105 duration-500">
                
                <div class="w-full text-left">
                    <h3 class="text-[#4A6B4A] font-black text-sm leading-tight">Perpus<br><span class="font-semibold text-[#7DA07D]">Digital</span></h3>
                </div>

                <div class="flex flex-col items-center text-center">
                    <!-- User Icon -->
                    <div class="w-24 h-24 mb-6 text-[#4A6B4A]">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-[#4A6B4A] mb-1">Welcome back!</h2>
                    <p class="text-xs text-[#7DA07D] font-medium border-b border-[#7DA07D] pb-1">Ready to begin again?</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-3/4 bg-[#85A385] text-white font-bold py-2.5 rounded-md shadow-md hover:bg-[#5C805C] transition-colors mt-6">
                    Login
                </button>
            </div>
        </form>

    </div>
    
    <!-- Teks Bawah -->
    <div class="absolute bottom-10 text-xs font-semibold text-[#5C805C]">
        Belum punya akun? <a href="{{ route('register') }}" class="text-[#4A6B4A] hover:underline font-bold">Sign in</a>
    </div>

</body>
</html>