<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $diskusi->judul }} - CitizenLink</title>
    
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
            body { @apply font-sans transition-colors duration-500 ease-in-out; } 
        }
    </style>
</head>

{{-- State Management: Dark Mode & Reply Target --}}
<body x-data="{ 
        dark: localStorage.getItem('theme') === 'light' ? false : true,
        replyTo: null,
        replyName: null
      }" 
      :class="dark ? 'bg-[#0f1115] text-gray-400' : 'bg-[#F1F5F9] text-slate-900'"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      class="antialiased min-h-screen flex flex-col pb-40"> 

    <nav class="border-b backdrop-blur-md sticky top-0 z-50 transition-colors duration-500"
         :class="dark ? 'border-white/10 bg-[#0a0a0a]/90' : 'border-slate-200 bg-white/90'">
        <div class="max-w-3xl mx-auto px-4 h-16 flex items-center gap-4">
            <a href="{{ route('komunitas') }}" class="w-8 h-8 rounded-full border flex items-center justify-center transition"
               :class="dark ? 'border-white/10 hover:bg-white/10 text-gray-400' : 'border-slate-200 hover:bg-slate-100 text-slate-600'">
                &larr;
            </a>
            <div class="flex-1 min-w-0">
                <h1 class="text-sm font-bold truncate" :class="dark ? 'text-white' : 'text-slate-900'">{{ $diskusi->judul }}</h1>
                <p class="text-[10px]" :class="dark ? 'text-gray-500' : 'text-slate-500'">Oleh {{ $diskusi->user->nama_lengkap }} • {{ $diskusi->created_at->diffForHumans() }}</p>
            </div>
            
            <button @click="dark = !dark" class="relative w-12 h-6 rounded-full transition-colors duration-300 flex items-center px-1 border shrink-0" 
                    :class="dark ? 'bg-gray-800 border-gray-700' : 'bg-cyan-100 border-cyan-200'">
                <div class="w-4 h-4 rounded-full bg-cyan-500 shadow-sm transition-transform duration-500 transform" 
                     :class="!dark && 'translate-x-6'"></div>
            </button>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto w-full px-4 pt-6 space-y-6">
        
        {{-- KONTEN UTAMA DISKUSI --}}
        <div class="border p-6 md:p-8 rounded-[30px] transition-colors duration-500"
             :class="dark ? 'bg-[#161b22] border-white/10' : 'bg-white border-slate-200 shadow-lg'">
            
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-500 flex items-center justify-center font-bold text-sm border border-cyan-500/20">
                    {{ substr($diskusi->user->nama_lengkap, 0, 1) }}
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border transition-colors"
                      :class="dark ? 'bg-white/5 border-white/10 text-gray-300' : 'bg-slate-100 border-slate-200 text-slate-600'">
                    {{ $diskusi->kategori }}
                </span>
            </div>

            <h2 class="text-xl md:text-2xl font-black mb-4" :class="dark ? 'text-white' : 'text-slate-900'">{{ $diskusi->judul }}</h2>
            <div class="text-sm md:text-base mb-4 leading-relaxed whitespace-pre-wrap font-medium" :class="dark ? 'text-gray-300' : 'text-slate-700'">{{ $diskusi->konten }}</div>
            
            @if($diskusi->foto)
                <div class="rounded-2xl overflow-hidden border mt-4" :class="dark ? 'border-white/10' : 'border-slate-200'">
                    <img src="{{ asset('storage/' . $diskusi->foto) }}" class="w-full max-h-[400px] object-cover" alt="Foto Diskusi">
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 py-2">
            <div class="h-px flex-1" :class="dark ? 'bg-white/10' : 'bg-slate-200'"></div>
            <span class="text-[10px] font-bold uppercase tracking-widest" :class="dark ? 'text-gray-600' : 'text-slate-400'">Balasan</span>
            <div class="h-px flex-1" :class="dark ? 'bg-white/10' : 'bg-slate-200'"></div>
        </div>

        {{-- LIST KOMENTAR --}}
        <div class="space-y-6 mb-10">
            @php
                // Logic: Ambil komentar utama (parent_id null)
                $mainComments = $diskusi->komentars->whereNull('parent_id');
            @endphp

            @forelse($mainComments as $komentar)
                <div class="group">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 rounded-lg border flex items-center justify-center text-xs font-bold transition-colors"
                                 :class="dark ? 'bg-[#161b22] border-white/10 text-gray-400' : 'bg-white border-slate-200 text-slate-600'">
                                {{ substr($komentar->user->nama_lengkap, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="border px-5 py-4 rounded-2xl rounded-tl-none transition-colors relative"
                                 :class="dark ? 'bg-[#161b22] border-white/10' : 'bg-white border-slate-200 shadow-sm'">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold" :class="dark ? 'text-white' : 'text-slate-900'">{{ $komentar->user->nama_lengkap }}</span>
                                    <span class="text-[10px]" :class="dark ? 'text-gray-600' : 'text-slate-400'">{{ $komentar->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm leading-relaxed font-medium" :class="dark ? 'text-gray-300' : 'text-slate-700'">{{ $komentar->isi_komentar }}</p>
                                
                                @if($komentar->foto)
                                    <div class="mt-3 rounded-xl overflow-hidden w-fit border" :class="dark ? 'border-white/10' : 'border-slate-200'">
                                        <img src="{{ asset('storage/' . $komentar->foto) }}" class="max-h-48 object-cover" alt="Foto Komentar">
                                    </div>
                                @endif

                                {{-- Tombol Balas: Set state replyTo & Focus ke input --}}
                                <button @click="replyTo = {{ $komentar->id }}; replyName = '{{ $komentar->user->nama_lengkap }}'; $nextTick(() => $refs.commentInput.focus())" 
                                        class="mt-3 text-[10px] font-bold uppercase tracking-wider text-cyan-500 hover:text-cyan-400 transition">
                                    Balas
                                </button>
                            </div>

                            {{-- LOGIC NESTED REPLY (Balasan Bertingkat) --}}
                            @php
                                $replies = $diskusi->komentars->where('parent_id', $komentar->id);
                            @endphp
                            @if($replies->count() > 0)
                                <div class="mt-3 ml-4 pl-4 border-l-2 space-y-3" :class="dark ? 'border-white/10' : 'border-slate-200'">
                                    @foreach($replies as $reply)
                                        <div class="flex gap-3">
                                            <div class="w-6 h-6 rounded border flex items-center justify-center text-[10px] font-bold shrink-0"
                                                 :class="dark ? 'bg-[#161b22] border-white/10 text-gray-500' : 'bg-white border-slate-200 text-slate-500'">
                                                {{ substr($reply->user->nama_lengkap, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-xs font-bold" :class="dark ? 'text-gray-300' : 'text-slate-800'">{{ $reply->user->nama_lengkap }}</span>
                                                    <span class="text-[9px]" :class="dark ? 'text-gray-600' : 'text-slate-400'">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-xs font-medium leading-relaxed" :class="dark ? 'text-gray-400' : 'text-slate-600'">{{ $reply->isi_komentar }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 opacity-50 text-sm font-medium" :class="dark ? 'text-gray-600' : 'text-slate-400'">
                    Belum ada tanggapan.
                </div>
            @endforelse
        </div>
    </div>

    {{-- INPUT KOMENTAR STICKY (BAWAH) --}}
    <div class="fixed bottom-0 left-0 right-0 p-4 backdrop-blur-md border-t transition-colors duration-500"
         :class="dark ? 'bg-[#0a0a0a]/90 border-white/10' : 'bg-white/90 border-slate-200'"
         x-data="{ photo: null, preview: null }">
        <div class="max-w-3xl mx-auto w-full">
            
            {{-- Indikator Sedang Membalas --}}
            <div x-show="replyName" x-transition class="mb-2 px-4 py-2 rounded-lg text-xs font-bold flex justify-between items-center"
                 :class="dark ? 'bg-cyan-500/10 text-cyan-400' : 'bg-cyan-50 text-cyan-600'">
                <span>Membalas <span x-text="replyName"></span></span>
                <button @click="replyTo = null; replyName = null" class="hover:text-red-500">&times;</button>
            </div>

            {{-- Preview Foto Upload --}}
            <div x-show="preview" class="mb-3 relative inline-block">
                <img :src="preview" class="h-16 rounded-lg border border-cyan-500/50">
                <button @click="photo = null; preview = null" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold shadow-md">&times;</button>
            </div>

            <form action="{{ route('komunitas.komentar.store', $diskusi->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-3 items-end">
                @csrf
                <input type="hidden" name="parent_id" :value="replyTo">

                <label class="p-3 rounded-xl cursor-pointer border transition-colors shrink-0"
                       :class="dark ? 'bg-[#161b22] border-white/10 text-gray-400 hover:text-white' : 'bg-white border-slate-200 text-slate-400 hover:text-slate-600 shadow-sm'">
                    <input type="file" name="foto" class="hidden" accept="image/*"
                           @change="const file = $event.target.files[0]; 
                                    if(file){ photo = file; preview = URL.createObjectURL(file); }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </label>

                <div class="flex-1 relative">
                    <input type="text" name="isi_komentar" x-ref="commentInput" required placeholder="Tulis tanggapan..."
                           class="w-full pl-5 pr-12 py-3 rounded-xl border font-medium focus:outline-none focus:border-cyan-500 transition-all shadow-sm"
                           :class="dark ? 'bg-[#161b22] border-white/10 text-white placeholder-gray-600' : 'bg-white border-slate-200 text-slate-900 placeholder-slate-400'">
                </div>

                <button type="submit" class="p-3 rounded-xl bg-cyan-500 text-black hover:bg-cyan-400 transition-all shadow-lg shadow-cyan-500/20 shrink-0">
                    <svg class="w-5 h-5 -rotate-45 translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>
</body>
</html>