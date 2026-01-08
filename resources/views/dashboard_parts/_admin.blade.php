<x-app-layout>
    
    {{-- Header & Statistik Global --}}
    <div class="mb-10 relative rounded-[30px] overflow-hidden border transition-all duration-500 shadow-xl"
         :class="dark ? 'bg-harmony-darkcard border-white/10' : 'bg-white border-slate-200 shadow-slate-200'">
        
        <div class="absolute top-0 left-0 w-full h-1.5" :class="dark ? 'bg-harmony-cyan shadow-[0_0_20px_#06b6d4]' : 'bg-slate-800'"></div>
        
        <div class="p-8 md:p-10 flex flex-col gap-10">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-lg shrink-0 transition-transform hover:scale-105"
                         :class="dark ? 'bg-harmony-cyan text-[#0f1115] shadow-[0_0_25px_rgba(6,182,212,0.4)]' : 'bg-slate-900 text-white'">
                        <svg class="w-10 h-10 font-bold" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-5xl font-black tracking-tighter uppercase leading-none mb-2">COMMAND CENTER</h1>
                        <p class="font-bold text-xs tracking-[0.4em] uppercase opacity-50" :class="dark ? 'text-harmony-cyan' : 'text-slate-500'">Executive Monitoring System</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.laporan.duplikat') }}" class="px-6 py-4 rounded-xl font-bold text-[11px] tracking-widest uppercase border transition-all hover:-translate-y-1 flex items-center gap-2"
                       :class="dark ? 'bg-[#21262d] text-orange-500 border-orange-500/20 hover:border-orange-500' : 'bg-orange-50 text-orange-600 border-orange-200 hover:bg-orange-100'">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                       <span>Duplikat</span>
                    </a>
                    <a href="{{ route('admin.petugas') }}" class="px-6 py-4 rounded-xl font-bold text-[11px] tracking-widest uppercase border transition-all hover:-translate-y-1 flex items-center gap-2"
                       :class="dark ? 'bg-[#21262d] text-white border-white/10 hover:border-white/30' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                       <span>Kelola Petugas</span>
                    </a>
                    <a href="{{ route('admin.timeline') }}" class="px-8 py-4 rounded-xl font-bold text-[11px] tracking-widest uppercase shadow-lg transition-all hover:-translate-y-1 flex items-center gap-2"
                       :class="dark ? 'bg-harmony-cyan text-black hover:bg-[#22d3ee]' : 'bg-slate-900 text-white hover:bg-slate-700'">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                       <span>Timeline</span>
                    </a>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="p-8 rounded-[2rem] border transition-colors relative overflow-hidden group"
                     :class="dark ? 'bg-[#161b22] border-white/5 hover:border-white/20' : 'bg-white border-slate-200 shadow-sm hover:shadow-md'">
                    <p class="text-[10px] font-black tracking-widest uppercase mb-3 opacity-50">Total Laporan</p>
                    <h3 class="text-5xl font-black tracking-tighter">{{ $stats['total'] }}</h3>
                </div>

                <div class="p-8 rounded-[2rem] border transition-colors relative overflow-hidden group"
                     :class="dark ? 'bg-[#161b22] border-white/5 hover:border-white/20' : 'bg-white border-slate-200 shadow-sm hover:shadow-md'">
                    <p class="text-[10px] font-black tracking-widest uppercase mb-3 opacity-50">Laporan Baru</p>
                    <h3 class="text-5xl font-black tracking-tighter">{{ $stats['baru'] }}</h3>
                </div>

                <div class="p-8 rounded-[2rem] border transition-colors relative overflow-hidden group"
                     :class="dark ? 'bg-[#161b22] border-white/5 hover:border-white/20' : 'bg-white border-slate-200 shadow-sm hover:shadow-md'">
                    <p class="text-[10px] font-black tracking-widest uppercase mb-3 opacity-50">Prioritas Tinggi</p>
                    <h3 class="text-5xl font-black tracking-tighter">{{ $stats['tinggi'] }}</h3>
                </div>

                <div class="p-8 rounded-[2rem] border transition-colors relative overflow-hidden group"
                     :class="dark ? 'bg-[#161b22] border-emerald-500/20 hover:border-emerald-500' : 'bg-emerald-50 border-emerald-200 shadow-sm hover:shadow-md'">
                    <p class="text-[10px] font-black tracking-widest uppercase mb-3 opacity-50 text-emerald-500">Laporan Tuntas</p>
                    <h3 class="text-5xl font-black tracking-tighter text-emerald-500">{{ $stats['selesai'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-end md:items-center gap-4 px-2">
        <h2 class="text-2xl font-black uppercase tracking-tighter flex items-center gap-3">
            <span class="w-3 h-8 rounded-full" :class="dark ? 'bg-harmony-cyan' : 'bg-slate-800'"></span> 
            @if(request('status') == 'ditolak') Arsip Ditolak @elseif(request('status') == 'selesai') Laporan Selesai @elseif(request('status') == 'proses') Dalam Pengerjaan @else Antrian Laporan @endif
        </h2>

        <div class="flex bg-white/5 p-1 rounded-xl border" :class="dark ? 'border-white/10' : 'border-slate-200 bg-slate-100'">
            <a href="{{ route('dashboard') }}" 
               class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all"
               :class="{{ !request('status') ? 'true' : 'false' }} ? (dark ? 'bg-harmony-cyan text-black shadow-lg' : 'bg-white text-slate-900 shadow') : 'opacity-50 hover:opacity-100'">
               Antrian
            </a>
            <a href="?status=proses" 
               class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all"
               :class="{{ request('status') == 'proses' ? 'true' : 'false' }} ? 'bg-yellow-500 text-black shadow-lg' : 'opacity-50 hover:opacity-100'">
               Proses
            </a>
            <a href="?status=selesai" 
               class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all"
               :class="{{ request('status') == 'selesai' ? 'true' : 'false' }} ? 'bg-emerald-500 text-black shadow-lg' : 'opacity-50 hover:opacity-100'">
               Selesai
            </a>
            <a href="?status=ditolak" 
               class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all"
               :class="{{ request('status') == 'ditolak' ? 'true' : 'false' }} ? 'bg-red-500 text-white shadow-lg' : 'opacity-50 hover:opacity-100'">
               Ditolak
            </a>
        </div>
    </div>

    {{-- Grid Laporan --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        @forelse($laporans as $lp)
        
        <div class="relative p-8 rounded-[2rem] border transition-all duration-300 hover:shadow-2xl group flex flex-col justify-between"
             :class="dark ? 'bg-[#161b22] border-white/5 hover:border-harmony-cyan/40' : 'bg-white border-slate-200 hover:border-slate-400 hover:shadow-lg'">
            
            <div class="flex justify-between items-start mb-6">
                <div class="flex-1">
                    <span class="text-[10px] font-bold font-mono px-2 py-1 rounded border uppercase mb-3 inline-block"
                          :class="dark ? 'bg-[#21262d] border-white/10 text-harmony-cyan' : 'bg-slate-100 border-slate-300 text-slate-600'">
                        #ID-{{ $lp->id_laporan }}
                    </span>
                    <h3 class="text-2xl font-bold leading-tight line-clamp-2">{{ $lp->isi_laporan }}</h3>
                </div>
                
                @if($lp->status_laporan != '0')
                    <div class="px-4 py-2 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-500 text-[10px] font-black uppercase tracking-widest shrink-0">
                        {{ $lp->status_laporan }}
                    </div>
                @endif
            </div>

            <div class="flex flex-wrap items-center gap-3 mb-6 pb-6 border-b" :class="dark ? 'border-white/5' : 'border-slate-100'">
                <div class="flex items-center gap-2 text-[11px] font-bold opacity-60">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ Str::limit($lp->lokasi, 25) }}
                    </span>
                    <span class="w-1 h-1 bg-current rounded-full"></span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $lp->pelapor->name ?? 'User' }}
                    </span>
                </div>
                <div class="px-2 py-1 rounded border border-dashed text-[10px] font-bold uppercase flex items-center gap-1" 
                     :class="dark ? 'border-harmony-cyan/30 text-harmony-cyan' : 'border-slate-300 text-slate-600'">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                    {{ $lp->jumlah_upvote ?? 0 }} Upvotes
                </div>
            </div>

            {{-- Controls Kategori & Prioritas --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="relative">
                    <div class="flex justify-between mb-1 px-1 items-center">
                        <label class="text-[9px] font-bold uppercase tracking-wider opacity-50">Kategori</label>
                        @if($lp->is_manual_category)
                            <span class="text-[8px] font-black text-orange-400 bg-orange-900/30 px-1.5 py-0.5 rounded tracking-wider border border-orange-500/30">EDITED</span>
                        @else
                            <span class="text-[8px] font-black text-cyan-400 bg-cyan-900/30 px-1.5 py-0.5 rounded tracking-wider border border-cyan-500/30">AUTO</span>
                        @endif
                    </div>
                    {{-- Auto Submit on Change --}}
                    <form action="{{ route('laporan.update_status', $lp->id_laporan) }}" method="POST" id="form-cat-{{ $lp->id_laporan }}">
                        @csrf @method('PATCH')
                        <select name="kategori" onchange="document.getElementById('form-cat-{{ $lp->id_laporan }}').submit()"
                                class="w-full px-4 py-3 text-[11px] font-bold rounded-xl border uppercase tracking-wide cursor-pointer appearance-none transition focus:outline-none"
                                :class="dark ? 'bg-[#21262d] border-white/10 hover:border-white/30 text-white' : 'bg-white border-slate-300 text-slate-800 hover:border-slate-400'">
                            @foreach(['Bencana & Darurat', 'Infrastruktur Kritis', 'Utilitas Umum', 'Kesehatan & Lingkungan', 'Ketertiban & Keamanan', 'Pelayanan Publik', 'Lainnya'] as $kat)
                                <option :class="dark ? 'bg-[#21262d]' : 'bg-white'" value="{{ $kat }}" {{ $lp->kategori == $kat ? 'selected' : '' }}>
                                    {{ $kat }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div>
                    <label class="text-[9px] font-bold uppercase tracking-wider opacity-50 mb-1 px-1 block">Prioritas</label>
                    <form action="{{ route('laporan.update_status', $lp->id_laporan) }}" method="POST">@csrf @method('PATCH')
                        <select name="prioritas" onchange="this.form.submit()" 
                            class="w-full bg-transparent border-2 text-[11px] font-bold rounded-xl py-2.5 px-4 uppercase focus:outline-none cursor-pointer transition-colors"
                            :class="dark ? 'border-white/10 hover:border-white focus:border-white text-white' : 'border-slate-300 hover:border-black focus:border-black text-slate-800'">
                            @foreach(['Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'] as $pri)
                                <option :class="dark ? 'bg-[#21262d]' : 'bg-white'" value="{{ $pri }}" {{ $lp->prioritas == $pri ? 'selected' : '' }}>
                                    {{ $pri }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <div class="flex justify-between items-center mt-auto pt-2">
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-50">Dibuat</span>
                    <span class="text-xs font-bold">{{ $lp->created_at->format('d M') }}</span>
                </div>

                <div class="flex flex-col text-center">
                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-50">Deadline</span>
                    @if(now()->greaterThan($lp->deadline_date) && $lp->status_laporan != 'selesai')
                        <span class="text-xs font-black text-red-500 animate-pulse">
                            {{ $lp->deadline_date->format('d M, H:i') }} (Telat)
                        </span>
                    @else
                        <span class="text-xs font-black text-emerald-500">
                            {{ $lp->deadline_date->format('d M, H:i') }} (Aman)
                        </span>
                    @endif
                </div>

                {{-- Action Buttons --}}
                @if($lp->status_laporan == '0')
                    <div class="flex gap-2">
                        {{-- Setuju / Proses --}}
                        <form action="{{ route('laporan.update_status', $lp->id_laporan) }}" method="POST">@csrf @method('PATCH')
                            <input type="hidden" name="status" value="proses">
                            <button type="submit" class="w-12 h-12 flex items-center justify-center bg-emerald-500 text-black rounded-xl hover:scale-110 transition shadow-[0_5px_20px_rgba(16,185,129,0.4)]">
                                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </form>
                        {{-- Tolak --}}
                        <form action="{{ route('laporan.update_status', $lp->id_laporan) }}" method="POST">@csrf @method('PATCH')
                            <input type="hidden" name="status" value="ditolak">
                            <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-xl border-2 transition hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-[0_5px_20px_rgba(239,68,68,0.4)]" :class="dark ? 'bg-[#21262d] text-red-500 border-red-500/30' : 'bg-white text-red-600 border-red-200'">
                                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="w-24"></div> 
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center border-2 border-dashed rounded-[30px]" :class="dark ? 'border-white/5' : 'border-slate-300'">
            <p class="text-lg font-bold uppercase tracking-widest opacity-30">Tidak ada data laporan.</p>
        </div>
        @endforelse
    </div>
</x-app-layout>