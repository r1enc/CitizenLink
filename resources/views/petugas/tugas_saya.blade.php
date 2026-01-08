<x-app-layout>
    {{-- State Management AlpineJS untuk Modal Popup --}}
    <div x-data="{ showModal: false, activeId: null, activeTitle: '', submitUrl: '', photoPreview: null }">

        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight mb-2" :class="dark ? 'text-white' : 'text-slate-900'">Tugas Saya</h1>
            <p class="text-sm font-normal" :class="dark ? 'text-gray-400' : 'text-slate-500'">Kelola laporan yang sedang kamu kerjakan.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- KOLOM KIRI: Daftar Tugas Aktif (Status 'proses') --}}
            <div class="lg:col-span-8 space-y-8">
                <div class="rounded-[30px] border transition-all duration-500 overflow-hidden"
                     :class="dark ? 'bg-[#161b22] border-white/5' : 'bg-white border-slate-200 shadow-lg'">
                    
                    <div class="p-6 border-b flex items-center justify-between" :class="dark ? 'border-gray-800' : 'border-slate-100'">
                        <h2 class="text-xl font-bold uppercase tracking-tight" :class="dark ? 'text-white' : 'text-slate-900'">
                            Sedang Dikerjakan
                        </h2>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </div>

                    <div class="p-6 space-y-6">
                        @forelse($mytasks->where('status_laporan', 'proses') as $task)
                        <div class="relative p-6 rounded-2xl border transition-all duration-300"
                             :class="dark ? 'bg-[#0f1115] border-gray-800' : 'bg-slate-50 border-slate-200'">
                            
                            <div class="flex flex-col md:flex-row justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="px-2 py-1 rounded bg-black/10 font-mono text-[10px] border uppercase font-medium">#ID-{{ $task->id_laporan }}</span>
                                        {{-- Badge Prioritas Dinamis --}}
                                        @php
                                            $priColor = match($task->prioritas) {
                                                'Sangat Tinggi' => 'text-red-500 bg-red-500/10 border-red-500/20',
                                                'Tinggi' => 'text-orange-500 bg-orange-500/10 border-orange-500/20',
                                                'Sedang' => 'text-yellow-500 bg-yellow-500/10 border-yellow-500/20',
                                                default => 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded text-[9px] font-bold uppercase tracking-wider border {{ $priColor }}">
                                            {{ $task->prioritas }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-semibold mb-2 leading-snug" :class="dark ? 'text-white' : 'text-slate-900'">
                                        "{{ $task->isi_laporan }}"
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-gray-500">
                                        <span>📍 {{ $task->lokasi }}</span>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                            <span class="font-bold">{{ $task->jumlah_upvote ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-3 min-w-[160px]">
                                    {{-- Tombol Trigger Modal Selesai --}}
                                    <button type="button" 
                                            @click="
                                                showModal = true; 
                                                activeId = {{ $task->id_laporan }}; 
                                                activeTitle = '{{ addslashes($task->isi_laporan) }}';
                                                submitUrl = '{{ route('laporan.selesaikan', $task->id_laporan) }}';
                                                photoPreview = null;
                                            "
                                            class="w-full px-4 py-3 bg-emerald-500 hover:bg-emerald-400 text-white font-bold text-[10px] tracking-widest uppercase rounded-xl transition-all shadow-lg shadow-emerald-500/20">
                                        Selesaikan
                                    </button>
                                    
                                    {{-- Tombol Lepas Tugas (Kembalikan ke Pool) --}}
                                    <form action="{{ route('laporan.lepas', $task->id_laporan) }}" method="POST" class="w-full">
                                        @csrf 
                                        <button type="submit" class="w-full px-4 py-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white font-bold text-[10px] tracking-widest uppercase rounded-xl transition-all border border-red-500/20">
                                            Lepas Tugas
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 border-2 border-dashed rounded-3xl" :class="dark ? 'border-gray-800' : 'border-slate-100'">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest">Tidak ada tugas aktif.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Riwayat Tugas Selesai --}}
            <div class="lg:col-span-4">
                <div class="rounded-[30px] p-6 border transition-all duration-500 sticky top-6"
                     :class="dark ? 'bg-[#161b22] border-white/5 shadow-2xl' : 'bg-white border-slate-200 shadow-xl'">
                    <h3 class="text-lg font-bold uppercase tracking-tight mb-6 pb-4 border-b transition-colors"
                        :class="dark ? 'text-white border-gray-800' : 'text-slate-900 border-slate-100'">
                         Riwayat Selesai
                    </h3>
                    <div class="space-y-6">
                        @forelse($mytasks->where('status_laporan', 'selesai')->take(10) as $log)
                        <div class="relative pl-6 border-l-2" :class="dark ? 'border-gray-800' : 'border-slate-200'">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                            <div>
                                <p class="text-[10px] font-bold uppercase text-emerald-500 mb-1 tracking-widest">Selesai</p>
                                <h4 class="text-sm font-semibold leading-tight line-clamp-2 mb-1 transition-colors" :class="dark ? 'text-white' : 'text-slate-800'">
                                    {{ $log->isi_laporan }}
                                </h4>
                                <div class="text-[10px] text-gray-500 font-mono">
                                    {{ $log->updated_at->format('d M, H:i') }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-center text-gray-600 font-medium">Belum ada riwayat.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- MODAL POPUP (AlpineJS Teleport ke Body) --}}
        <template x-teleport="body">
            <div x-show="showModal" 
                 style="display: none;"
                 class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <div class="w-full max-w-md rounded-[30px] p-8 relative shadow-2xl border"
                     :class="dark ? 'bg-[#161b22] border-white/10' : 'bg-white border-black/10'"
                     @click.away="showModal = false">
                    
                    <button @click="showModal = false" class="absolute top-4 right-4 p-2 rounded-full hover:bg-white/10 transition">
                        <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <div class="text-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-emerald-500/10 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black uppercase tracking-tight" :class="dark ? 'text-white' : 'text-slate-900'">Selesaikan Tugas</h3>
                        <p class="text-xs font-mono opacity-50 mt-1" :class="dark ? 'text-gray-400' : 'text-slate-500'" x-text="'Laporan #' + activeId"></p>
                        <p class="text-sm font-medium mt-2 opacity-80" :class="dark ? 'text-gray-300' : 'text-slate-700'" x-text="activeTitle"></p>
                    </div>

                    <form :action="submitUrl" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-[10px] font-bold uppercase tracking-widest mb-3 opacity-60" :class="dark ? 'text-white' : 'text-slate-900'">Upload Bukti Foto (Wajib)</label>
                            
                            {{-- Logic Preview Foto sebelum Upload --}}
                            <input type="file" name="foto_penanganan" class="hidden" x-ref="photo" required
                                   x-on:change="
                                        const file = $refs.photo.files[0];
                                        if(file){
                                            const reader = new FileReader();
                                            reader.onload = (e) => { photoPreview = e.target.result; };
                                            reader.readAsDataURL(file);
                                        }
                                   ">
                            
                            <div class="w-full h-40 rounded-2xl border-2 border-dashed flex flex-col items-center justify-center cursor-pointer transition-all hover:border-emerald-500 group relative overflow-hidden"
                                 :class="dark ? 'bg-[#0f1115] border-gray-700' : 'bg-gray-50 border-gray-300'"
                                 x-on:click.prevent="$refs.photo.click()">
                                
                                <div x-show="!photoPreview" class="text-center p-4">
                                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30 group-hover:text-emerald-500 transition-colors" :class="dark ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-50" :class="dark ? 'text-white' : 'text-slate-900'">Klik untuk upload foto</p>
                                </div>
                                
                                <img x-show="photoPreview" :src="photoPreview" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="showModal = false" 
                                    class="flex-1 py-3 rounded-xl font-bold text-xs uppercase tracking-widest border transition hover:bg-white/5"
                                    :class="dark ? 'border-white/10 text-white' : 'border-black/10 text-black'">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="flex-[2] py-3 rounded-xl font-bold text-xs uppercase tracking-widest bg-emerald-500 text-black hover:bg-emerald-400 shadow-lg shadow-emerald-500/20 transition-all active:scale-95">
                                Kirim & Selesai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>
</x-app-layout>