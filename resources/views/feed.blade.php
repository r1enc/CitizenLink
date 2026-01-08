<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jelajah Laporan - CitizenLink</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] } } }
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Poppins', sans-serif;
                @apply bg-[#0f1115] text-gray-400 transition-colors duration-700 ease-in-out;
            }
            body.light { @apply bg-slate-50 text-slate-900; }
        }
        @layer utilities {
            .glass { @apply backdrop-blur-xl border border-white/5 bg-white/5; }
            .light .glass { @apply bg-white border-slate-200 shadow-xl; }
        }
        [x-cloak] { display: none !important; }
    </style>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
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
                <div class="hidden lg:flex gap-6 text-sm font-bold tracking-wide">
                    <a href="{{ route('feed') }}" class="text-cyan-500 border-b-2 border-cyan-400 pb-1">Jelajah</a>
                    <a href="{{ route('komunitas') }}" class="transition" :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-500 hover:text-slate-900'">Komunitas</a>
                    <a href="{{ route('panduan') }}" class="transition" :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-500 hover:text-slate-900'">Panduan</a>
                </div>

                <div class="hidden lg:block h-4 w-[1px] bg-gray-700/50"></div>

                <div class="flex items-center gap-4">
                    
                    <button @click="dark = !dark" 
                            class="relative w-12 h-6 rounded-full transition-colors duration-300 flex items-center px-1 border" 
                            :class="dark ? 'bg-gray-800 border-gray-700' : 'bg-cyan-100 border-cyan-200'">
                        <div class="w-4 h-4 rounded-full bg-cyan-500 shadow-sm transition-transform duration-300 transform" 
                             :class="!dark ? 'translate-x-6' : 'translate-x-0'"></div>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white bg-cyan-500 px-4 py-2 rounded-lg hover:bg-cyan-600 transition shadow-lg shadow-cyan-500/20">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] transition" :class="dark ? 'text-gray-400 hover:text-cyan-500' : 'text-slate-500 hover:text-slate-900'">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="relative py-16 px-4 text-center overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-cyan-500/10 rounded-full blur-[100px] -z-10"></div>
        <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">
            Pantau Masalah <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Lingkunganmu</span>
        </h1>
        <p class="max-w-2xl mx-auto mb-8 transition-colors font-medium" :class="dark ? 'text-gray-500' : 'text-slate-500'">Cari laporan yang relevan, berikan dukungan, dan pantau penyelesaiannya.</p>

        <form action="{{ route('feed') }}" method="GET" class="max-w-xl mx-auto relative group">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari: 'Jalan rusak', 'Sampah', 'Banjir'..." 
                   class="w-full border rounded-2xl py-4 pl-6 pr-14 focus:outline-none focus:border-cyan-500 transition shadow-2xl transition-colors font-medium"
                   :class="dark ? 'bg-[#161b22] border-gray-700 text-white placeholder-gray-600' : 'bg-white border-slate-200 text-slate-900 placeholder-slate-400'">
            <button type="submit" class="absolute right-3 top-3 p-2 bg-cyan-500 rounded-xl text-black hover:bg-cyan-400 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 w-full flex-1">
        @if($laporan->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($laporan as $item)
                <div class="glass rounded-[24px] overflow-hidden group hover:border-cyan-500/30 transition duration-500 flex flex-col relative">
                    
                    <div class="h-48 relative overflow-hidden" :class="dark ? 'bg-[#161b22]' : 'bg-slate-200'">
                        @if($item->foto_bukti)
                            <img src="{{ asset('storage/' . $item->foto_bukti) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-500">
                                <span class="text-[10px] font-bold uppercase">Tanpa Foto</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-4 right-4">
                             @php
                                $statusClass = match($item->status_laporan) {
                                    'selesai' => 'bg-emerald-500 text-black',
                                    'proses' => 'bg-yellow-500 text-black',
                                    default => 'bg-black/50 text-white backdrop-blur'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                {{ $item->status_laporan == '0' ? 'Pending' : $item->status_laporan }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-3 text-[10px] font-bold uppercase tracking-wide transition-colors" :class="dark ? 'text-gray-500' : 'text-slate-400'">
                            <span class="flex items-center gap-1 text-cyan-500">📍 {{ Str::limit($item->lokasi, 15) }}</span>
                            <span>•</span>
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </div>

                        <h3 class="text-lg font-bold mb-2 line-clamp-2 leading-tight group-hover:text-cyan-500 transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">
                            <a href="{{ route('laporan.tracking', $item->id_laporan) }}">{{ $item->isi_laporan }}</a>
                        </h3>
                        
                        <div class="mt-auto pt-6 border-t flex items-center justify-between transition-colors" :class="dark ? 'border-white/5' : 'border-slate-100'">
                            <a href="{{ route('laporan.tracking', $item->id_laporan) }}" class="text-xs font-bold flex items-center gap-1 transition-colors" :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-400 hover:text-slate-700'">
                                Cek Detail &rarr;
                            </a>

                            <button onclick="upvoteLaporan({{ $item->id_laporan }})" 
                                    id="btn-upvote-{{ $item->id_laporan }}"
                                    class="flex items-center gap-2 px-3 py-1.5 rounded-lg transition group/vote border
                                           bg-slate-100 border-slate-200 hover:bg-slate-200 text-slate-600
                                           dark:bg-white/5 dark:border-white/5 dark:hover:bg-cyan-500/20 dark:text-gray-400 hover:text-cyan-500">
                                <svg class="w-4 h-4 transition-transform group-active/vote:scale-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                                <span class="text-xs font-bold" id="count-upvote-{{ $item->id_laporan }}">
                                    {{ $item->jumlah_upvote ?? 0 }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12">{{ $laporan->links() }}</div>
        @else
             <div class="text-center py-20">
                <h3 class="text-xl font-bold transition-colors" :class="dark ? 'text-white' : 'text-slate-900'">Laporan tidak ditemukan</h3>
                <p class="text-sm mt-2 transition-colors font-medium" :class="dark ? 'text-gray-500' : 'text-slate-500'">Coba cari dengan kata kunci lain.</p>
                @auth
                <a href="{{ route('dashboard') }}" class="inline-block mt-6 px-8 py-3 bg-cyan-600 text-white font-bold rounded-xl hover:bg-cyan-500 transition shadow-lg shadow-cyan-500/20">
                    Buat Laporan Baru
                </a>
                @endauth
            </div>
        @endif
    </div>

    <script>
        function upvoteLaporan(id) {
            const btn = document.getElementById(`btn-upvote-${id}`);
            btn.style.transform = "scale(0.95)";
            setTimeout(() => btn.style.transform = "scale(1)", 150);

            fetch(`/laporan/${id}/upvote`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            })
            .then(response => {
                if (response.status === 401) {
                    alert('Eits, Login dulu dong kalau mau dukung laporan ini! 😉');
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.status === 'success') {
                    document.getElementById(`count-upvote-${id}`).innerText = data.new_count;
                    if(data.action === 'voted' || data.action === 'upvote'){
                        btn.classList.add('text-cyan-500', 'border-cyan-500');
                        btn.classList.remove('text-slate-600', 'text-gray-400');
                    } else {
                        btn.classList.remove('text-cyan-500', 'border-cyan-500');
                        btn.classList.add('dark:text-gray-400', 'text-slate-600'); 
                    }
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</body>
</html>