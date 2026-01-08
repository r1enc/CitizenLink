<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ruang Komunitas - CitizenLink</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Poppins', sans-serif;
                @apply bg-[#0f1115] text-gray-400 transition-colors duration-700 ease-in-out;
            }
            body.light { @apply bg-[#F1F5F9] text-slate-900; }
        }
        @layer utilities {
            .glass-card { @apply backdrop-blur-xl border border-white/5 bg-white/5 shadow-2xl; }
            .light .glass-card { @apply bg-white border-slate-200 shadow-xl; }
            .gradient-text { 
                background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%); 
                -webkit-background-clip: text; 
                -webkit-text-fill-color: transparent; 
            }
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
            
            <div class="flex items-center gap-6 md:gap-8">
                <div class="hidden md:flex gap-6 text-sm font-bold tracking-wide">
                    <a href="{{ route('feed') }}" class="transition" :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-500 hover:text-slate-900'">Jelajah</a>
                    <a href="{{ route('komunitas') }}" class="text-cyan-500 border-b-2 border-cyan-400 pb-1">Komunitas</a>
                    <a href="{{ route('panduan') }}" class="transition" :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-500 hover:text-slate-900'">Panduan</a>
                </div>
                <div class="hidden md:block h-4 w-[1px] bg-gray-700/50"></div>
                <div class="flex items-center gap-4">
                    <button @click="dark = !dark" class="relative w-12 h-6 rounded-full transition-colors duration-300 flex items-center px-1 border" 
                            :class="dark ? 'bg-gray-800 border-gray-700' : 'bg-cyan-100 border-cyan-200'">
                        <div class="w-4 h-4 rounded-full bg-cyan-500 shadow-sm transition-transform duration-500 transform" :class="!dark && 'translate-x-6'"></div>
                    </button>
                    @auth
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-cyan-500 to-blue-500 border border-white/10 flex items-center justify-center text-[10px] font-bold text-black">
                            {{ substr(Auth::user()->nama_lengkap ?? Auth::user()->name, 0, 2) }}
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold px-4 py-2 rounded-lg border transition"
                           :class="dark ? 'text-white bg-white/5 border-white/10 hover:bg-white/10' : 'text-slate-700 bg-slate-100 border-slate-200 hover:bg-slate-200'">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto w-full px-4 pt-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <span class="px-4 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[10px] font-bold tracking-[0.2em] uppercase mb-4 inline-block">Forum Musyawarah Digital</span>
                <h1 class="text-4xl md:text-5xl font-black leading-tight transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Ruang <span class="gradient-text">Komunitas</span></h1>
                <p class="mt-2 max-w-xl transition-colors font-medium" :class="dark ? 'text-gray-400' : 'text-slate-500'">Sampaikan aspirasi dan diskusikan solusi untuk lingkungan yang lebih baik secara kolektif.</p>
            </div>
            <a href="{{ route('komunitas.create') }}" class="px-8 py-3 bg-cyan-500 hover:bg-cyan-400 text-black font-bold rounded-2xl transition-all shadow-lg shadow-cyan-500/20 transform hover:-translate-y-1 text-center flex items-center justify-center gap-2">
                <svg class="w-4 h-4 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                BUAT DISKUSI BARU
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto w-full px-4 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-3 space-y-6">
            <div class="glass-card p-6 rounded-[32px] transition-colors duration-500">
                <h3 class="font-bold mb-6 text-xs uppercase tracking-[0.2em] transition-colors flex items-center gap-2" :class="dark ? 'text-white' : 'text-slate-900'">
                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Topik Utama
                </h3>
                <nav class="space-y-2">
                    <a href="{{ route('komunitas') }}" class="flex items-center gap-3 p-3 rounded-xl transition font-medium text-sm"
                       :class="[
                           !request('kategori') 
                           ? 'bg-cyan-500/10 text-cyan-500 border border-cyan-500/20' 
                           : (dark ? 'text-gray-500 hover:bg-white/5 hover:text-white border border-transparent' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900 border border-transparent')
                       ]">
                        # Semua
                    </a>

                    @php 
                        $kategoris = [
                            'Sosialisasi',
                            'Bencana & Darurat', 
                            'Infrastruktur Kritis', 
                            'Utilitas Umum', 
                            'Kesehatan & Lingkungan', 
                            'Ketertiban & Keamanan', 
                            'Pelayanan Publik',
                            'Lainnya'
                        ]; 
                    @endphp
                    @foreach($kategoris as $kat)
                        <a href="?kategori={{ $kat }}" class="flex items-center gap-3 p-3 rounded-xl transition font-medium text-sm"
                           :class="[
                               request('kategori') == '{{ $kat }}' 
                               ? 'bg-cyan-500/10 text-cyan-500 border border-cyan-500/20' 
                               : (dark ? 'text-gray-500 hover:bg-white/5 hover:text-white border border-transparent' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900 border border-transparent')
                           ]">
                            # {{ $kat }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <div class="lg:col-span-6 space-y-6">
            @forelse($diskusis as $diskusi)
                <div class="glass-card p-8 rounded-[40px] transition-all hover:border-cyan-500/20 group">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold uppercase transition-colors"
                             :class="dark ? 'bg-gradient-to-br from-gray-800 to-gray-900 border border-white/5 text-white' : 'bg-slate-100 text-slate-700'">
                            {{ substr($diskusi->user->nama_lengkap ?? $diskusi->user->name, 0, 2) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-sm transition-colors flex items-center gap-2" :class="dark ? 'text-white' : 'text-slate-900'">
                                {{ $diskusi->user->nama_lengkap ?? $diskusi->user->name }} 
                                @if($diskusi->user->role == 'admin')
                                    <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </h4>
                            <p class="text-xs transition-colors font-medium" :class="dark ? 'text-gray-600' : 'text-slate-400'">{{ $diskusi->created_at->diffForHumans() }} dalam <span class="text-cyan-500">{{ $diskusi->kategori }}</span></p>
                        </div>
                    </div>
                    
                    <a href="{{ route('komunitas.show', $diskusi->id) }}" class="block">
                        <h2 class="text-xl font-bold mb-4 leading-relaxed transition-colors group-hover:text-cyan-500" :class="dark ? 'text-white' : 'text-slate-900'">"{{ $diskusi->judul }}"</h2>
                    </a>

                    <p class="text-sm leading-relaxed mb-6 transition-colors font-normal" :class="dark ? 'text-gray-400' : 'text-slate-500'">
                        {{ Str::limit($diskusi->konten, 200) }}
                    </p>
                    
                    <div class="flex items-center justify-between border-t pt-6 transition-colors" :class="dark ? 'border-white/5' : 'border-slate-100'">
                        <a href="{{ route('komunitas.show', $diskusi->id) }}" class="flex items-center gap-2 text-xs font-bold transition-colors" :class="dark ? 'text-gray-600 hover:text-white' : 'text-slate-400 hover:text-slate-700'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            {{ $diskusi->komentars_count }} Komentar
                        </a>
                        <button class="text-xs font-bold uppercase tracking-widest transition-colors flex items-center gap-2" :class="dark ? 'text-gray-700 hover:text-white' : 'text-slate-300 hover:text-slate-500'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            BAGIKAN
                        </button>
                    </div>
                </div>
            @empty
                <div class="glass-card p-12 rounded-[40px] border-dashed transition-colors text-center" :class="dark ? 'border-gray-800' : 'border-slate-200'">
                    <h3 class="font-bold text-lg mb-2 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Belum ada diskusi</h3>
                    <p class="text-sm max-w-xs mx-auto transition-colors font-medium" :class="dark ? 'text-gray-600' : 'text-slate-400'">Jadilah warga pertama yang memulai percakapan di ruang komunitas ini.</p>
                </div>
            @endforelse
        </div>

        <div class="lg:col-span-3 space-y-6">
            
            <div class="glass-card p-6 rounded-[32px] transition-colors" :class="dark ? 'bg-[#161b22]/50' : 'bg-white'">
                <h3 class="font-bold mb-6 text-xs uppercase tracking-[0.2em] transition-colors flex items-center gap-2" :class="dark ? 'text-white' : 'text-slate-900'">
                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    Top Pelapor
                </h3>
                <div class="space-y-4">
                    @forelse($topPelapor ?? [] as $index => $item)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-bold transition-colors" 
                                 :class="dark ? 'bg-white/5 text-gray-400' : 'bg-slate-100 text-slate-600'">{{ $index + 1 }}</div>
                            <div class="flex-1">
                                <p class="text-xs font-bold transition-colors truncate" :class="dark ? 'text-white' : 'text-slate-800'">
                                    {{ Str::limit($item->user->nama_lengkap ?? $item->user->name, 15) }}
                                </p>
                                <p class="text-[9px] opacity-50">Warga</p>
                            </div>
                            <span class="text-[10px] font-bold text-cyan-500">{{ $item->total }} Lapor</span>
                        </div>
                    @empty
                        <p class="text-[10px] transition-colors font-medium opacity-50 text-center" :class="dark ? 'text-gray-700' : 'text-slate-400'">Belum ada data pelapor.</p>
                    @endforelse
                </div>
            </div>

            <div class="glass-card p-6 rounded-[32px] transition-colors relative overflow-hidden" 
                 :class="dark ? 'bg-gradient-to-br from-emerald-900/10 to-transparent border-emerald-500/20' : 'bg-gradient-to-br from-emerald-50 to-white border-emerald-100'">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-500/20 rounded-full blur-2xl"></div>
                
                <h3 class="font-bold mb-6 text-xs uppercase tracking-[0.2em] transition-colors flex items-center gap-2 relative z-10" :class="dark ? 'text-white' : 'text-slate-900'">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Top Petugas
                </h3>
                <div class="space-y-4 relative z-10">
                    @forelse($topPetugas ?? [] as $index => $item)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-bold transition-colors"
                                 :class="dark ? 'bg-emerald-500/10 text-emerald-500' : 'bg-emerald-100 text-emerald-700'">{{ $index + 1 }}</div>
                            <div class="flex-1">
                                <p class="text-xs font-bold transition-colors truncate" :class="dark ? 'text-white' : 'text-slate-800'">
                                    {{ Str::limit($item->user->nama_lengkap ?? $item->user->name, 15) }}
                                </p>
                                <p class="text-[9px] opacity-50">Petugas</p>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-500">{{ $item->total }} Selesai</span>
                        </div>
                    @empty
                        <p class="text-[10px] transition-colors font-medium opacity-50 text-center" :class="dark ? 'text-gray-700' : 'text-slate-400'">Belum ada data petugas.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <footer class="mt-auto py-10 border-t text-center transition-colors" :class="dark ? 'border-white/5 text-gray-700' : 'border-slate-200 text-slate-400'">
        <p class="text-[10px] font-bold uppercase tracking-[0.4em]">CitizenLink &bull; Forum Aspirasi Publik</p>
    </footer>

</body>
</html>