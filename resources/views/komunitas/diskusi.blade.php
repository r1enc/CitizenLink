<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Diskusi Baru - CitizenLink</title>
    
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
        [x-cloak] { display: none !important; }
    </style>
</head>

<body x-data="{ dark: localStorage.getItem('theme') === 'light' ? false : true }" 
      :class="dark ? 'bg-[#0f1115] text-gray-400' : 'bg-[#F1F5F9] text-slate-900'"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      class="antialiased min-h-screen flex flex-col"> 
      
    <nav class="border-b backdrop-blur-md sticky top-0 z-50 transition-colors duration-500"
         :class="dark ? 'border-white/5 bg-[#0a0a0a]/80' : 'border-slate-200 bg-white/80'">
        <div class="max-w-4xl mx-auto px-6 h-20 flex items-center justify-between">
            
            <a href="{{ route('komunitas') }}" class="text-sm font-bold uppercase tracking-widest transition-colors flex items-center gap-2"
               :class="dark ? 'text-gray-400 hover:text-white' : 'text-slate-500 hover:text-slate-900'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Batal
            </a>
            
            <span class="font-bold text-lg" :class="dark ? 'text-white' : 'text-slate-900'">Mulai Diskusi</span>
            
            <button @click="dark = !dark" class="relative w-12 h-6 rounded-full transition-colors duration-300 flex items-center px-1 border" 
                    :class="dark ? 'bg-gray-800 border-gray-700' : 'bg-cyan-100 border-cyan-200'">
                <div class="w-4 h-4 rounded-full bg-cyan-500 shadow-sm transition-transform duration-500 transform" 
                     :class="!dark && 'translate-x-6'"></div>
            </button>

        </div>
    </nav>

    <div class="max-w-4xl mx-auto w-full px-6 py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black mb-2" :class="dark ? 'text-white' : 'text-slate-900'">Suarakan Aspirasimu</h1>
            <p class="font-medium" :class="dark ? 'text-gray-500' : 'text-slate-500'">Mulai percakapan yang membangun untuk lingkungan kita.</p>
        </div>

        {{-- FORM DISKUSI (x-data untuk handling preview foto) --}}
        <form action="{{ route('komunitas.store') }}" method="POST" enctype="multipart/form-data" 
              class="border p-8 md:p-10 rounded-[40px] transition-colors duration-500"
              :class="dark ? 'bg-[#161b22] border-white/10' : 'bg-white border-slate-200 shadow-xl'"
              x-data="{ photoPreview: null, fileName: null }">
            @csrf

            <div class="space-y-3 mb-8">
                <label for="judul" class="text-xs font-bold uppercase tracking-widest ml-1 text-cyan-500">Topik Diskusi</label>
                <input type="text" name="judul" id="judul" required placeholder="Contoh: Lampu jalan di RT 05 mati total..."
                       class="w-full border rounded-2xl px-6 py-4 font-bold text-lg focus:outline-none focus:border-cyan-500 transition-all placeholder-gray-500"
                       :class="dark ? 'bg-[#0f1115] border-white/10 text-white' : 'bg-slate-50 border-slate-200 text-slate-900'">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-3">
                    <label for="kategori" class="text-xs font-bold uppercase tracking-widest ml-1 text-cyan-500">Kategori</label>
                    <div class="relative">
                        <select name="kategori" id="kategori" required
                                class="w-full border rounded-2xl px-6 py-4 font-bold appearance-none focus:outline-none focus:border-cyan-500 cursor-pointer"
                                :class="dark ? 'bg-[#0f1115] border-white/10 text-white' : 'bg-slate-50 border-slate-200 text-slate-900'">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Sosialisasi">Sosialisasi</option>
                            <option value="Bencana & Darurat">Bencana & Darurat</option>
                            <option value="Infrastruktur Kritis">Infrastruktur Kritis</option>
                            <option value="Utilitas Umum">Utilitas Umum</option>
                            <option value="Kesehatan & Lingkungan">Kesehatan & Lingkungan</option>
                            <option value="Ketertiban & Keamanan">Ketertiban & Keamanan</option>
                            <option value="Pelayanan Publik">Pelayanan Publik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-xs font-bold uppercase tracking-widest ml-1 text-cyan-500">Foto Pendukung (Opsional)</label>
                    <label class="relative flex items-center gap-4 p-2 rounded-2xl border-2 border-dashed cursor-pointer transition-all hover:border-cyan-500 hover:bg-cyan-500/5 h-[60px]"
                           :class="dark ? 'border-gray-700' : 'border-slate-300'">
                        {{-- Logic Preview Gambar --}}
                        <input type="file" name="foto" class="hidden" accept="image/*"
                               @change="const file = $event.target.files[0]; 
                                        if(file){ photoPreview = URL.createObjectURL(file); fileName = file.name; }">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center overflow-hidden shrink-0 transition-colors"
                             :class="dark ? 'bg-white/10' : 'bg-slate-200'">
                            <template x-if="!photoPreview">
                                <span class="text-xs font-bold" :class="dark ? 'text-gray-400' : 'text-slate-500'">IMG</span>
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold truncate" :class="dark ? 'text-gray-300' : 'text-slate-600'" 
                               x-text="fileName || 'Klik untuk upload foto'">Klik untuk upload foto</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="space-y-3">
                <label for="konten" class="text-xs font-bold uppercase tracking-widest ml-1 text-cyan-500">Detail Pembahasan</label>
                <textarea name="konten" id="konten" rows="8" required placeholder="Ceritakan detail masalah atau idemu di sini..."
                          class="w-full border rounded-2xl px-6 py-4 leading-relaxed focus:outline-none focus:border-cyan-500 resize-none placeholder-gray-500 font-medium"
                          :class="dark ? 'bg-[#0f1115] border-white/10 text-white' : 'bg-slate-50 border-slate-200 text-slate-900'"></textarea>
            </div>

            <div class="pt-6 mt-8 border-t flex items-center justify-end gap-4" :class="dark ? 'border-white/5' : 'border-slate-100'">
                <a href="{{ route('komunitas') }}" class="px-6 py-3 text-sm font-bold transition" :class="dark ? 'text-gray-500 hover:text-white' : 'text-slate-500 hover:text-slate-900'">BATAL</a>
                <button type="submit" class="px-10 py-4 bg-cyan-600 hover:bg-cyan-500 text-white font-black uppercase text-xs tracking-widest rounded-2xl transition-all shadow-lg shadow-cyan-500/20">
                    TERBITKAN DISKUSI
                </button>
            </div>
        </form>
    </div>
</body>
</html>