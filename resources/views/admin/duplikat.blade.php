<x-app-layout>
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-2" :class="dark ? 'text-white' : 'text-slate-900'">
                Manajemen Duplikat
            </h2>
            <p class="text-xs font-bold tracking-[0.2em] uppercase opacity-50">Gabungkan laporan serupa menjadi satu fokus penanganan.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest border transition-all flex items-center gap-2"
           :class="dark ? 'border-white/10 hover:bg-white/5 text-white' : 'border-slate-300 hover:bg-slate-100 text-slate-700'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="space-y-12">
        {{-- Loop Induk Laporan --}}
        @forelse($laporans as $induk)
        <div class="relative group">
            
            <div class="hidden lg:flex absolute top-1/2 left-[50%] -translate-x-1/2 -translate-y-1/2 z-10 p-2 rounded-full border-2 transition-colors"
                 :class="dark ? 'bg-[#0f1115] border-white/10 text-white' : 'bg-white border-slate-200 text-slate-400'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-16">
                
                {{-- KARTU INDUK (UTAMA) --}}
                <div class="rounded-[2rem] p-8 border-2 transition-all relative overflow-hidden"
                     :class="dark ? 'bg-[#161b22] border-emerald-500/30' : 'bg-white border-emerald-500/30 shadow-lg'">
                    
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-32 h-32 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-emerald-500 text-black shadow-[0_0_15px_rgba(16,185,129,0.4)]">
                                UTAMA / INDUK
                            </span>
                            <div class="text-right">
                                <span class="text-3xl font-black text-emerald-500">{{ $induk->jumlah_upvote }}</span>
                                <p class="text-[8px] font-bold uppercase tracking-widest opacity-50">Total Upvotes</p>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-black mb-3 leading-tight" :class="dark ? 'text-white' : 'text-slate-900'">{{ $induk->isi_laporan }}</h3>
                        
                        <div class="flex items-center gap-2 text-xs font-bold opacity-60 mb-6">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $induk->lokasi }}</span>
                            <span class="mx-1">•</span>
                            <span>#ID-{{ $induk->id_laporan }}</span>
                        </div>

                        {{-- Avatar Stack Pelapor --}}
                        <div class="pt-6 border-t flex items-center gap-4" :class="dark ? 'border-white/10' : 'border-slate-100'">
                            <div class="flex -space-x-2 overflow-hidden">
                                <div class="w-8 h-8 rounded-full border-2 bg-gray-500 flex items-center justify-center text-xs font-bold text-white" :class="dark ? 'border-[#161b22]' : 'border-white'">{{ substr($induk->pelapor->name ?? 'U', 0, 1) }}</div>
                                @foreach($induk->duplicates->take(3) as $child)
                                    <div class="w-8 h-8 rounded-full border-2 bg-orange-500 flex items-center justify-center text-xs font-bold text-white" :class="dark ? 'border-[#161b22]' : 'border-white'">{{ substr($child->pelapor->name ?? 'U', 0, 1) }}</div>
                                @endforeach
                                @if($induk->duplicates->count() > 3)
                                    <div class="w-8 h-8 rounded-full border-2 bg-gray-700 flex items-center justify-center text-[8px] font-bold text-white" :class="dark ? 'border-[#161b22]' : 'border-white'">+{{ $induk->duplicates->count() - 3 }}</div>
                                @endif
                            </div>
                            <p class="text-[10px] font-bold opacity-60 uppercase tracking-wider">
                                {{ $induk->duplicates->count() }} Laporan digabungkan ke sini
                            </p>
                        </div>
                    </div>
                </div>

                {{-- LIST ANAK (DUPLIKAT) --}}
                <div class="flex flex-col justify-center">
                    <div class="mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-orange-500">Laporan Duplikat (Anak)</span>
                    </div>

                    <div class="space-y-3">
                        @foreach($induk->duplicates as $anak)
                        <div class="p-4 rounded-2xl border transition-all flex items-center justify-between group hover:pl-6"
                             :class="dark ? 'bg-[#161b22] border-white/5 hover:border-orange-500/30' : 'bg-white border-slate-200 shadow-sm hover:border-orange-300'">
                            
                            <div class="min-w-0 flex-1 mr-4">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 rounded bg-orange-500/10 text-orange-500 border border-orange-500/20">
                                        #ID-{{ $anak->id_laporan }}
                                    </span>
                                    <span class="text-[10px] font-bold opacity-50">{{ $anak->created_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="font-bold text-sm truncate" :class="dark ? 'text-gray-300' : 'text-slate-700'">{{ $anak->isi_laporan }}</h4>
                                <p class="text-xs opacity-50 truncate">{{ $anak->pelapor->name ?? 'User' }} • {{ $anak->lokasi }}</p>
                            </div>
                            
                            {{-- Fitur Pisahkan Duplikat (Manual Split) --}}
                            <form action="{{ route('laporan.update_status', $anak->id_laporan) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="pisahkan_duplikat" value="true">
                                <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all group-hover:scale-105" title="Pisahkan dari grup ini">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="py-32 text-center border-2 border-dashed rounded-[30px]" :class="dark ? 'border-white/5' : 'border-slate-300'">
            <div class="w-20 h-20 mx-auto bg-gray-800 rounded-full flex items-center justify-center mb-6 opacity-50">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-black uppercase tracking-widest" :class="dark ? 'text-white' : 'text-slate-800'">Bersih!</h3>
            <p class="text-sm mt-2 opacity-50 font-bold uppercase tracking-wider">Tidak ada grup duplikat yang perlu ditangani.</p>
        </div>
        @endforelse
    </div>
</x-app-layout>