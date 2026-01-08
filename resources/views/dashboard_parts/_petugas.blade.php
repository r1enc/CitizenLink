<x-app-layout>
    <div class="relative rounded-[30px] p-8 mb-8 border transition-all duration-500 overflow-hidden shadow-xl"
         :class="dark ? 'bg-gradient-to-r from-cyan-900/40 to-[#0f1115] border-white/5' : 'bg-white border-black/10 shadow-lg'">
        
        <div class="absolute right-0 top-0 w-64 h-64 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none" 
             :class="dark ? 'bg-cyan-500/10' : 'bg-black/5'"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border transition-colors"
                          :class="dark ? 'bg-cyan-500/20 text-cyan-400 border-cyan-500/20' : 'bg-black text-white border-black'">
                        Dashboard Petugas
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight transition-colors">
                    Halo, {{ explode(' ', Auth::user()->name)[0] }}
                </h1>
                <p class="text-sm mt-2 max-w-xl opacity-60 font-medium">
                    Silakan ambil laporan yang telah divalidasi admin untuk memulai pengerjaan.
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-[30px] border transition-all duration-500 overflow-hidden"
         :class="dark ? 'bg-[#161b22] border-white/5' : 'bg-white border-black/10 shadow-xl'">
        
        <div class="p-6 border-b flex items-center justify-between" 
             :class="dark ? 'border-gray-800' : 'border-black/5'">
            <h2 class="text-lg font-bold uppercase tracking-tight">Daftar Laporan Masuk</h2>
            <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-lg transition-colors"
                  :class="dark ? 'text-cyan-500 bg-cyan-500/10' : 'text-black bg-gray-100'">Siap Dikerjakan</span>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Loop Data Laporan (Dari Controller indexPetugas) --}}
                @forelse($laporans as $pool)
                <div class="p-6 rounded-[2rem] border transition-all duration-300 flex flex-col justify-between group hover:scale-[1.01] hover:shadow-xl"
                     :class="dark ? 'bg-[#0f1115] border-gray-800' : 'bg-white border-black/20 hover:border-black'">
                    
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono opacity-50 font-medium">#{{ $pool->id_laporan }}</span>
                            
                            {{-- Penentuan Warna Badge Prioritas --}}
                            @php
                                $priColor = match($pool->prioritas) {
                                    'Sangat Tinggi' => 'text-red-500 bg-red-500/10 border-red-500/20',
                                    'Tinggi'        => 'text-orange-500 bg-orange-500/10 border-orange-500/20',
                                    'Sedang'        => 'text-yellow-500 bg-yellow-500/10 border-yellow-500/20',
                                    default         => 'text-black bg-gray-100 border-gray-300 dark:text-cyan-500 dark:bg-cyan-500/10 dark:border-cyan-500/20'
                                };
                            @endphp
                            
                            <span class="px-2 py-1 rounded text-[9px] font-bold uppercase tracking-wider border {{ $priColor }}">
                                {{ $pool->prioritas }}
                            </span>
                        </div>

                        <h4 class="font-bold text-lg mb-2 leading-snug line-clamp-2">
                            {{ $pool->isi_laporan }}
                        </h4>
                        
                        <div class="flex items-center gap-2 mb-4 text-xs opacity-60 font-medium">
                             <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                             <span>{{ Str::limit($pool->lokasi, 25) }}</span>
                        </div>
                    </div>

                    {{-- Form Ambil Tugas --}}
                    <form action="{{ route('laporan.ambil', $pool->id_laporan) }}" method="POST" class="mt-4">
                        @csrf 
                        
                        <button type="submit" 
                                class="w-full py-3 font-black text-[11px] tracking-widest uppercase rounded-xl transition-all shadow-lg hover:shadow-xl active:scale-95"
                                :class="dark ? 'bg-cyan-500 hover:bg-cyan-400 text-black shadow-cyan-500/20' : 'bg-black hover:bg-gray-800 text-white shadow-black/20'">
                            Ambil Kasus Ini
                        </button>
                    </form>
                </div>
                @empty
                <div class="col-span-full text-center py-20 border-2 border-dashed rounded-[30px]"
                     :class="dark ? 'border-white/5' : 'border-gray-300'">
                    <div class="opacity-30">
                        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        <p class="text-xs font-bold uppercase tracking-widest">Tidak ada laporan baru yang divalidasi.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>