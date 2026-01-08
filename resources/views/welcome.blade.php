<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CitizenLink - Layanan Aspirasi Digital</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                @apply bg-[#0f1115] text-gray-400 transition-colors duration-700 ease-in-out;
            }
            body.light {
                @apply bg-slate-50 text-slate-900;
            }
        }
        @layer utilities {
            .text-outline {
                -webkit-text-stroke: 1.5px rgba(6, 182, 212, 0.4);
                color: transparent;
            }
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }
            .glass-card {
                @apply backdrop-blur-xl border border-white/5 bg-white/5 shadow-2xl;
            }
            .light .glass-card {
                @apply bg-white/80 border-slate-200 shadow-xl;
            }
            .blob {
                filter: blur(100px);
                @apply absolute rounded-full mix-blend-screen animate-pulse opacity-20 pointer-events-none;
            }
            .parallax-bg {
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        }
    </style>
</head>
<body x-data="{ dark: true }" :class="{ 'light': !dark }" class="antialiased overflow-x-hidden">

    <nav class="fixed top-0 w-full z-50 transition-all duration-300 px-6 py-5 bg-opacity-80 backdrop-blur-md"
         :class="dark ? 'bg-[#0f1115]/80 border-b border-gray-800' : 'bg-white/80 border-b border-gray-200'">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
        <div class="flex items-center space-x-3 group cursor-pointer">
            <div class="w-10 h-10 bg-cyan-500 rounded-2xl flex items-center justify-center text-[#0f1115] group-hover:rotate-6 transition-transform shadow-lg shadow-cyan-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
            </div>
            <span class="text-xl font-extrabold italic tracking-tighter uppercase" :class="dark ? 'text-white' : 'text-slate-900'">CitizenLink</span>
        </div>
            
            <div class="flex items-center space-x-4 md:space-x-8">
                
                <div class="hidden lg:flex items-center space-x-8">
                    
                    <a href="{{ route('feed') }}" class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-cyan-500 transition" :class="dark ? 'text-gray-400' : 'text-slate-600'">
                        Jelajah
                    </a>

                    <a href="{{ route('komunitas') }}" class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-cyan-500 transition" :class="dark ? 'text-gray-400' : 'text-slate-600'">
                        Komunitas
                    </a>

                    <a href="{{ route('panduan') }}" class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-cyan-500 transition" :class="dark ? 'text-gray-400' : 'text-slate-600'">
                        Panduan
                    </a>

                    <div class="h-4 w-[1px] bg-gray-700 opacity-30"></div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-full border text-[10px] font-black uppercase tracking-[0.2em] transition hover:-translate-y-1 flex items-center gap-2"
                           :class="dark ? 'border-cyan-500/50 text-cyan-400 hover:bg-cyan-500/10' : 'border-slate-300 text-slate-700 hover:bg-slate-100'">
                            <span>Dashboard</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-cyan-500 transition" :class="dark ? 'text-gray-400' : 'text-slate-600'">
                            Masuk
                        </a>

                        <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-cyan-500 text-[#0f1115] text-[10px] font-black uppercase tracking-[0.2em] hover:bg-cyan-400 hover:-translate-y-1 transition shadow-lg shadow-cyan-500/20">
                            Daftar
                        </a>
                    @endauth
                    
                </div>

                <button @click="dark = !dark" class="relative w-12 h-6 rounded-full transition-colors duration-300 flex items-center px-1 border" 
                        :class="dark ? 'bg-gray-800 border-gray-700' : 'bg-cyan-100 border-cyan-200'">
                    <div class="w-4 h-4 rounded-full bg-cyan-500 shadow-sm transition-transform duration-500 transform" :class="!dark && 'translate-x-6'"></div>
                </button>
            </div>
        </div>
    </nav>

    <section class="relative min-h-screen flex items-center justify-center pt-24 px-6 overflow-hidden parallax-bg" style="background-image: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop');">
        <div class="absolute inset-0 z-0 transition-colors duration-700" :class="dark ? 'bg-[#0f1115]/90' : 'bg-slate-50/90'"></div>
        
        <div class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t z-10 transition-colors duration-700" 
             :class="dark ? 'from-[#0f1115] to-transparent' : 'from-slate-50 to-transparent'"></div>

        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="blob w-[600px] h-[600px] bg-cyan-500/15 top-1/4 left-1/4 animate-pulse"></div>
            <div class="blob w-[500px] h-[500px] bg-indigo-500/10 bottom-1/4 right-1/4 animate-pulse delay-700"></div>
        </div>

        <div class="relative z-10 text-center max-w-6xl w-full pb-20">
            @if(session('error'))
            <div class="reveal active bg-red-500/10 border border-red-500 text-red-500 px-4 py-2 rounded-full inline-block mb-6 text-xs font-bold uppercase tracking-widest">
                {{ session('error') }}
            </div>
            @endif

            <div class="reveal active inline-block px-5 py-2 rounded-full border border-cyan-500/20 bg-cyan-500/5 mb-10 backdrop-blur-sm">
                <span class="text-[10px] font-black uppercase tracking-[0.5em] text-cyan-500">Layanan Aspirasi Warga Terpadu</span>
            </div>
            
            <h1 class="text-5xl md:text-[9rem] font-[900] tracking-tighter leading-[0.8] uppercase reveal active mb-14 drop-shadow-2xl transition-colors duration-500"
                :class="dark ? 'text-white' : 'text-slate-900'">
                SPEAK UP <br> 
                YOUR VOICE <br> 
                <span class="text-outline italic">MATTERS</span>
            </h1>

            <div class="flex flex-col items-center gap-12 reveal active delay-200">
                <div class="flex flex-col md:flex-row gap-5 w-full justify-center max-w-4xl">
                    
                    <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="flex-1 px-10 py-7 bg-cyan-500 text-[#0f1115] font-[900] rounded-[2.5rem] text-xl shadow-2xl shadow-cyan-500/40 hover:-translate-y-2 transition-all uppercase tracking-tight transform hover:scale-105 duration-300 flex items-center justify-center">
                        Kirim Laporan 
                    </a>
                    
                    <form action="{{ route('laporan.search') }}" method="GET" class="flex-1 relative group hover:-translate-y-2 transition-transform duration-300">
                        <input type="text" name="keyword" placeholder="Masukkan ID Laporan..." required
                               class="w-full h-full px-10 py-7 rounded-[2.5rem] bg-transparent border-2 font-[900] text-xl text-center uppercase tracking-tight outline-none placeholder:text-gray-500 placeholder:normal-case focus:border-cyan-500 transition-all backdrop-blur-sm"
                               :class="dark ? 'border-gray-800 text-white focus:bg-[#0f1115]/50' : 'border-slate-300 text-slate-900 focus:bg-white/50'">
                        
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-cyan-500 rounded-full flex items-center justify-center text-black hover:scale-110 transition shadow-lg opacity-0 group-hover:opacity-100 focus-within:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
                
                <div class="flex flex-wrap justify-center gap-14">
                    <p class="text-xs font-bold uppercase tracking-widest opacity-50">
                        Atau scan QR Code yang didapatkan setelah mengisi laporan
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="relative py-20 px-6 transition-colors duration-700 overflow-hidden" 
             :class="dark ? 'bg-[#0f1115]' : 'bg-slate-50'">
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="blob w-[800px] h-[800px] bg-cyan-500/5 -bottom-40 -left-40 animate-pulse duration-[4000ms]"></div>
            <div class="blob w-[600px] h-[600px] bg-indigo-500/5 top-20 -right-20 animate-pulse delay-1000 duration-[5000ms]"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="mb-32 text-center reveal">
                <h2 class="text-5xl md:text-7xl font-[900] mb-5 tracking-tighter uppercase italic transition-colors duration-500" :class="dark ? 'text-white' : 'text-slate-900'">7 Fitur Unggulan</h2>
                <div class="w-32 h-2 bg-cyan-500 mx-auto rounded-full mb-8 shadow-lg shadow-cyan-500/50"></div>
                <p class="text-cyan-500 font-bold tracking-[0.4em] uppercase text-xs">Inovasi Layanan Aspirasi Terintegrasi</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <div class="reveal glass-card p-12 rounded-[3.5rem] transition-all duration-700 hover:-translate-y-4 group relative overflow-hidden hover:shadow-cyan-500/20">
                    <div class="w-20 h-20 bg-cyan-500 rounded-3xl flex items-center justify-center mb-10 shadow-lg shadow-cyan-500/20 group-hover:rotate-12 transition-transform text-[#0f1115]">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-5 uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Priority Task</h3>
                    <p class="text-sm leading-relaxed font-medium opacity-50">Sistem pengurutan otomatis berdasarkan tingkat urgensi dan akumulasi dukungan (upvote) dari warga.</p>
                </div>
                
                <div class="reveal glass-card p-12 rounded-[3.5rem] transition-all duration-700 hover:-translate-y-4 delay-100 group relative overflow-hidden hover:shadow-indigo-500/20">
                    <div class="w-20 h-20 bg-indigo-500 rounded-3xl flex items-center justify-center mb-10 shadow-lg shadow-indigo-500/20 group-hover:rotate-12 transition-transform text-white">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-5 uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">SLA Tracking</h3>
                    <p class="text-sm leading-relaxed font-medium opacity-50">Monitoring tenggat waktu penyelesaian aduan guna memastikan setiap laporan ditangani secara tepat waktu.</p>
                </div>

                <div class="reveal glass-card p-12 rounded-[3.5rem] transition-all duration-700 hover:-translate-y-4 delay-200 group relative overflow-hidden hover:shadow-emerald-500/20">
                    <div class="w-20 h-20 bg-emerald-500 rounded-3xl flex items-center justify-center mb-10 shadow-lg shadow-emerald-500/20 group-hover:rotate-12 transition-transform text-white">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-5 uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Smart Dispatch</h3>
                    <p class="text-sm leading-relaxed font-medium opacity-50">Klasifikasi otomatis laporan ke bidang terkait menggunakan analisis keyword cerdas.</p>
                </div>

                <div class="reveal glass-card p-12 rounded-[3.5rem] transition-all duration-700 hover:-translate-y-5 group relative overflow-hidden hover:shadow-blue-600/20">
                    <div class="w-20 h-20 bg-blue-600 rounded-3xl flex items-center justify-center mb-10 shadow-lg shadow-blue-600/20 group-hover:rotate-12 transition-transform text-white">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-5 uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Smart Duplicate</h3>
                    <p class="text-sm leading-relaxed font-medium opacity-50">Deteksi kesamaan laporan secara otomatis menggunakan 3 kata kunci awal untuk efisiensi database.</p>
                </div>

                <div class="reveal glass-card p-12 rounded-[3.5rem] transition-all duration-700 hover:-translate-y-5 delay-100 group relative overflow-hidden hover:shadow-cyan-600/20">
                    <div class="w-20 h-20 bg-cyan-600 rounded-3xl flex items-center justify-center mb-10 shadow-lg shadow-cyan-600/20 group-hover:rotate-12 transition-transform text-white">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-5 uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Interactive Timeline</h3>
                    <p class="text-sm leading-relaxed font-medium opacity-50">Visualisasi jadwal penugasan seluruh petugas lapangan yang terpusat.</p>
                </div>

                <div class="reveal glass-card p-12 rounded-[3.5rem] transition-all duration-700 hover:-translate-y-5 delay-200 group relative overflow-hidden hover:shadow-teal-500/20">
                    <div class="w-20 h-20 bg-teal-500 rounded-3xl flex items-center justify-center mb-10 shadow-lg shadow-teal-500/20 group-hover:rotate-12 transition-transform text-white">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 12h1m-1 4h-1m1-4h.01M12 16h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-5 uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">QR Tracking</h3>
                    <p class="text-sm leading-relaxed font-medium opacity-50">Pantau progres laporan real-time cukup dengan scan kode unik tanpa login rumit.</p>
                </div>

                <div class="reveal glass-card p-12 rounded-[3.5rem] transition-all duration-700 hover:-translate-y-5 lg:col-span-3 flex flex-col md:flex-row items-center gap-14 group relative overflow-hidden hover:shadow-cyan-500/20">
                    <div class="w-24 h-24 bg-cyan-500 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-cyan-500/30 group-hover:rotate-12 transition-transform text-[#0f1115] relative z-10">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                    </div>
                    <div class="flex-1 text-center md:text-left relative z-10">
                        <h3 class="text-4xl font-bold mb-5 uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Smart Upvote Community</h3>
                        <p class="text-base leading-relaxed font-medium opacity-50">Wadah dukungan bagi warga untuk memperkuat laporan mendesak.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-24 border-t transition-colors duration-500" :class="dark ? 'border-gray-900 bg-[#0a0c10]' : 'border-gray-200 bg-white text-slate-900'">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-[10px] font-black tracking-[1.2em] text-gray-700 uppercase mb-5">CITIZENLINK &copy; 2025</p>
            <p class="text-[10px] font-black tracking-[0.5em] text-cyan-500 uppercase italic">Designed by Wildan Ariel</p>
        </div>
    </footer>

    <script>
        const observerOptions = { threshold: 0.15 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>