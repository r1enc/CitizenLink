<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panduan Penggunaan - CitizenLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Poppins', sans-serif;
                @apply bg-[#0f1115] text-gray-400 transition-colors duration-700 ease-in-out;
            }
            body.light { @apply bg-slate-50 text-slate-900; }
        }
        @layer utilities {
            .glass-card { @apply backdrop-blur-xl border border-white/5 bg-white/5; }
            .light .glass-card { @apply bg-white border-slate-200 shadow-xl; }
            .step-number { background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%); }
        }
    </style>
</head>

<body x-data="{ dark: localStorage.getItem('theme') === 'light' ? false : true }" 
      :class="{ 'light': !dark }" 
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      class="antialiased min-h-screen flex flex-col transition-colors duration-500">

    <nav class="border-b transition-colors duration-500 sticky top-0 z-50 backdrop-blur-md"
         :class="dark ? 'border-white/5 bg-[#0a0a0a]/80' : 'border-slate-200 bg-white/80'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-cyan-500 rounded-xl flex items-center justify-center text-black shadow-[0_0_15px_rgba(6,182,212,0.5)] group-hover:rotate-12 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <span class="text-xl font-extrabold italic tracking-tighter uppercase" :class="dark ? 'text-white' : 'text-slate-900'">CitizenLink</span>
            </a>
            
            <div class="flex items-center gap-6">
                <div class="hidden md:flex gap-8 text-sm font-bold tracking-wide">
                    <a href="{{ route('feed') }}" class="transition" :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-500 hover:text-slate-900'">Jelajah</a>
                    <a href="{{ route('komunitas') }}" class="transition" :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-500 hover:text-slate-900'">Komunitas</a>
                    <a href="{{ route('panduan') }}" class="border-b-2 border-cyan-400 pb-1 text-cyan-500">Panduan</a>
                </div>

                 <button @click="dark = !dark" class="relative w-12 h-6 rounded-full transition-colors duration-300 flex items-center px-1 border" 
                        :class="dark ? 'bg-gray-800 border-gray-700' : 'bg-cyan-100 border-cyan-200'">
                    <div class="w-4 h-4 rounded-full bg-cyan-500 shadow-sm transition-transform duration-500 transform" :class="!dark && 'translate-x-6'"></div>
                </button>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 pt-20 pb-16 text-center">
        <span class="px-4 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[10px] font-bold tracking-[0.2em] uppercase mb-6 inline-block">Informasi Prosedur</span>
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Bagaimana Prosedur <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">CitizenLink?</span></h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto leading-relaxed transition-colors font-medium" :class="dark ? 'text-gray-400' : 'text-slate-500'">Sampaikan aspirasi dan laporan kendala di lingkungan Anda, berikan dukungan pada laporan warga, serta pantau proses penyelesaian secara transparan.</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 pb-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="glass-card p-8 rounded-[32px] hover:border-cyan-500/30 transition-all group">
                <div class="w-14 h-14 step-number rounded-2xl flex items-center justify-center text-black font-bold text-2xl mb-6 shadow-lg shadow-cyan-500/20 group-hover:-translate-y-2 transition-transform">1</div>
                <h3 class="text-xl font-bold mb-3 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Pendaftaran Akun</h3>
                <p class="text-sm leading-relaxed transition-colors font-normal" :class="dark ? 'text-gray-500' : 'text-slate-500'">Warga diwajibkan melakukan pendaftaran menggunakan NIK guna menjamin validitas data pelapor dan akuntabilitas aduan.</p>
            </div>

            <div class="glass-card p-8 rounded-[32px] hover:border-blue-500/30 transition-all group">
                <div class="w-14 h-14 step-number rounded-2xl flex items-center justify-center text-black font-bold text-2xl mb-6 shadow-lg shadow-blue-500/20 group-hover:-translate-y-2 transition-transform" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">2</div>
                <h3 class="text-xl font-bold mb-3 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Penyampaian Laporan</h3>
                <p class="text-sm leading-relaxed transition-colors font-normal" :class="dark ? 'text-gray-500' : 'text-slate-500'">Unggah foto dokumentasi kejadian, tentukan lokasi presisi, dan deskripsikan kendala. Sistem akan mendistribusikan laporan ke instansi terkait secara otomatis.</p>
            </div>

            <div class="glass-card p-8 rounded-[32px] hover:border-purple-500/30 transition-all group">
                <div class="w-14 h-14 step-number rounded-2xl flex items-center justify-center text-black font-bold text-2xl mb-6 shadow-lg shadow-purple-500/20 group-hover:-translate-y-2 transition-transform" style="background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);">3</div>
                <h3 class="text-xl font-bold mb-3 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Dukungan Upvote</h3>
                <p class="text-sm leading-relaxed transition-colors font-normal" :class="dark ? 'text-gray-500' : 'text-slate-500'">Pantau laporan publik melalui menu Jelajah. Gunakan fitur <b>Upvote</b> sebagai bentuk urgensi dukungan warga guna meningkatkan prioritas penanganan.</p>
            </div>

             <div class="glass-card p-8 rounded-[32px] hover:border-emerald-500/30 transition-all group">
                <div class="w-14 h-14 step-number rounded-2xl flex items-center justify-center text-black font-bold text-2xl mb-6 shadow-lg shadow-emerald-500/20 group-hover:-translate-y-2 transition-transform" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">4</div>
                <h3 class="text-xl font-bold mb-3 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Pemantauan</h3>
                <p class="text-sm leading-relaxed transition-colors font-normal" :class="dark ? 'text-gray-500' : 'text-slate-500'">Gunakan ID Laporan atau pemindaian kode QR untuk memantau perkembangan status secara langsung, termasuk estimasi waktu penyelesaian.</p>
            </div>
        </div>
    </div>

    <div class="border-t py-20 text-center relative overflow-hidden transition-colors" :class="dark ? 'bg-[#161b22] border-white/5' : 'bg-slate-50 border-slate-200'">
        <div class="relative z-10 px-4">
            <h2 class="text-3xl font-bold mb-8 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Siap Berkontribusi bagi Lingkungan Anda?</h2>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard') }}" class="px-10 py-4 font-bold rounded-2xl hover:bg-cyan-400 transition-all shadow-xl shadow-cyan-500/10 transform hover:scale-105" :class="dark ? 'bg-white text-black' : 'bg-slate-900 text-white'">
                    Dashboard Pengguna
                </a>
            </div>
        </div>
    </div>

</body>
</html>