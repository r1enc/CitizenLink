<x-app-layout>
    
    <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-2" :class="dark ? 'text-white' : 'text-slate-900'">
                Interactive Timeline
            </h2>
            <p class="text-xs font-bold tracking-[0.2em] uppercase opacity-50">Monitoring Pergerakan Laporan Real-Time</p>
        </div>
        
        <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest border transition-all flex items-center gap-2 hover:-translate-y-1"
           :class="dark ? 'border-white/10 hover:bg-white/5 text-white' : 'border-slate-300 hover:bg-slate-100 text-slate-700'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        @forelse($laporans as $lp)
        <div class="group relative rounded-[2rem] p-6 border transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col justify-between"
             :class="dark ? 'bg-[#161b22] border-white/5 hover:shadow-black/50' : 'bg-white border-slate-200 hover:shadow-slate-200/50'">
            
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold font-mono uppercase tracking-widest border"
                          :class="dark ? 'bg-white/5 text-gray-400 border-white/5' : 'bg-slate-50 text-slate-600 border-slate-200'">
                        #{{ $lp->id_laporan }}
                    </span>
                    <span class="text-[10px] font-bold opacity-40">{{ $lp->created_at->diffForHumans() }}</span>
                </div>

                {{-- Status Badge Color Logic --}}
                @php
                    $statusColor = match($lp->status_laporan) {
                        'selesai' => 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20',
                        'proses' => 'text-blue-500 bg-blue-500/10 border-blue-500/20',
                        'ditolak' => 'text-red-500 bg-red-500/10 border-red-500/20',
                        default => 'text-gray-500 bg-gray-500/10 border-gray-500/20'
                    };
                @endphp
                <span class="px-3 py-1 rounded-lg border text-[10px] font-black uppercase tracking-widest {{ $statusColor }}">
                    {{ $lp->status_laporan == '0' ? 'MENUNGGU' : $lp->status_laporan }}
                </span>
            </div>

            <div class="flex gap-4 h-full">
                
                <div class="flex-1 flex flex-col">
                    <h3 class="text-xl font-bold mb-2 leading-snug line-clamp-3" :class="dark ? 'text-white' : 'text-slate-900'">
                        "{{ $lp->isi_laporan }}"
                    </h3>
                    
                    <div class="flex items-center gap-2 text-xs font-bold opacity-60 mb-auto">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="truncate">{{ Str::limit($lp->lokasi, 30) }}</span>
                    </div>

                    <div class="mt-6 pt-4 border-t grid grid-cols-2 gap-2" :class="dark ? 'border-white/5' : 'border-slate-100'">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-wider opacity-40 mb-1">Kategori</p>
                            <p class="text-xs font-bold text-cyan-500 truncate">{{ $lp->kategori ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-wider opacity-40 mb-1">Petugas</p>
                            <p class="text-xs font-bold truncate" :class="dark ? 'text-white' : 'text-slate-900'">
                                {{ $lp->petugas->name ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tampilkan Foto Bukti Selesai (Jika Ada) --}}
                @if($lp->foto_penanganan)
                <div class="w-1/3 min-w-[120px]">
                    <div class="h-full rounded-2xl overflow-hidden relative group/img cursor-pointer border"
                         :class="dark ? 'border-white/10' : 'border-slate-200'"
                         onclick="window.open('{{ asset('storage/' . $lp->foto_penanganan) }}', '_blank')">
                        
                        <img src="{{ asset('storage/' . $lp->foto_penanganan) }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-110" 
                             alt="Bukti">
                        
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        </div>
                        
                        <div class="absolute bottom-2 right-2 bg-black/60 backdrop-blur rounded px-2 py-0.5">
                            <p class="text-[8px] font-bold text-white uppercase">Bukti</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center border-2 border-dashed rounded-[3rem]"
             :class="dark ? 'border-white/5' : 'border-slate-200'">
            <div class="opacity-30 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-sm font-bold uppercase tracking-widest opacity-50">Belum ada aktivitas laporan.</p>
        </div>
        @endforelse

    </div>
</x-app-layout>